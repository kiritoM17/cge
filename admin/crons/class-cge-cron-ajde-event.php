<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';

class Cron_Ajde_Events
{
    public function import_datas()
    {
        $api = new API_CGE();
        $parameters = 'deletedAt[exists]=false&pagination=false&order[startDate]=desc';
        $response = $api->getApi('/api/events?' . $parameters);
        $response = isset($response->{'hydra:member'}) ? $response->{'hydra:member'} : [];

        foreach ($response as $json_event) {
            $startDate = new DateTime($json_event->startDate);
            $endDate = new DateTime($json_event->endDate);

            // if (strtotime($startDate->format('Y-m-d H:i:s')) < time())
            //     continue;
            $posts_event = new WP_Query("post_status=any&post_type=ajde_events&meta_key=_cge_event_id&meta_value=" . $json_event->id);

            if (sizeof($posts_event->posts) > 0) {
                $my_post = $posts_event->posts[0];
                $my_post->post_title = $json_event->name;

                wp_update_post($my_post);
                $post_id = $my_post->ID;

                $function_meta = 'update_post_meta';
            } else {
                $my_post = array();
                $my_post['post_title'] = $json_event->name;
                $my_post['post_status'] = 'draft';
                //the id of the author
                $my_post['post_author'] = 24;
                //the id's of the categories
                $my_post['post_type'] = 'ajde_events';

                $post_id = wp_insert_post($my_post);

                $function_meta = 'add_post_meta';
                $function_meta($post_id, '_cge_event_id', $json_event->id);
            }

            // Start date
            $function_meta($post_id, 'evcal_srow', strtotime($startDate->format('Y-m-d H:i:s')));
            $function_meta($post_id, 'event_year', $startDate->format('Y'));
            $function_meta($post_id, '_event_month', intval($startDate->format('m')));

            // End date
            $function_meta($post_id, 'evcal_erow', strtotime($endDate->format('Y-m-d H:i:s')));

            // Inscription
            $function_meta($post_id, '_evcal_ec_f1a1_cus', 'INSCRIPTION');
            $function_meta($post_id, '_evcal_ec_f1a1_cusL', 'https://intranet.cge.asso.fr/public/event-subscription/' . $json_event->id);

            // Activities
            $json_event_detail = $api->getApi('/api/events/' . $json_event->id); //json_decode($json_event_detail, true);
            //die(var_dump($json_event_detail));
            $json_event_detail = isset($json_event_detail->activities) ? $json_event_detail->activities : [];

            $stashes = array();
            foreach ($json_event_detail as $activity) {
                $startDate = new DateTime($activity->startDate);
                $endDate = new DateTime($activity->endDate);
                if (!isset($stashes[$startDate->format('Y-m-d')]))
                    $stashes[$startDate->format('Y-m-d')] = array();

                $stashes[$startDate->format('Y-m-d')][$startDate->format('H-i')] = array(
                    'evo_sch_title' => $activity->name,
                    'evo_sch_date' => $startDate->format('d') . ' ' . ucfirst($arr_fr[$startDate->format('m') - 1]) . ' ' . $startDate->format('Y'),
                    'evo_sch_stime' => $startDate->format('H:i'),
                    'evo_sch_etime' => $endDate->format('H:i'),
                    'evo_sch_desc' => ($activity->description ? $activity->description : '/'),
                );
            }

            $activities = array();
            $d = 1;
            foreach ($stashes as $key => $stash) {
                ksort($stash);
                $keyObj = new DateTime($key . ' 00:00:00');
                $dateDay = $keyObj->format('d') . ' ' . ucfirst($arr_fr[$keyObj->format('m') - 1]) . ' ' . $keyObj->format('Y');
                $newKey = 'd' . $d;

                $tabIds = array();
                for ($i = 0; $i < count($stash); $i++)
                    $tabIds[] = uniqid();

                $activities[$newKey][0] = $dateDay;

                $inc = 0;
                foreach ($stash as $valueStash) {
                    $activities[$newKey][$tabIds[$inc]] = $valueStash;
                    $inc++;
                }

                $d++;
            }

            $function_meta($post_id, '_sch_blocks', serialize($activities));

            ///////////
            // Terms //
            ///////////

            // Event type
            register_taxonomy('event_type', 'event');
            wp_set_object_terms($post_id, array(812), 'event_type');

            // Adresse
            // NAME
            register_taxonomy('event_location', 'post');
            $addressL1 = trim($json_event_detail->postalAddress->streetAddressLine1);
            if ($addressL1 != '') {
                if (!term_exists($addressL1)) {
                    $idsAdd = wp_insert_term($addressL1, 'event_location');
                    $termId = $idsAdd['term_id'];
                } else {
                    $term = get_term_by('name', $addressL1, 'event_location');
                    $termId = $term->term_id;
                }

                // PLACE
                $addressL2 = trim($json_event_detail->postalAddress->streetAddressLine2);
                if ($addressL2 != '') {
                    $options = get_option('evo_tax_meta');
                    $options['event_location'][$termId] = array(
                        'evcal_location_link' => '',
                        'location_lon' => NULL,
                        'location_lat' => NULL,
                        'location_address' => $addressL2,
                        'evo_loc_img' => ''
                    );
                    update_option('evo_tax_meta', $options);
                }
            }
        }
    }
}
$cron = new Cron_Ajde_Events();
// $cron->deleteAllDatas();
// die(var_dump('end'));
$cron->import_datas();
