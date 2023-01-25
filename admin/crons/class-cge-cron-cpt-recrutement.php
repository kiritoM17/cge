<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Cpt_Recrutement
{
    public function import_datas()
    {
        global $wpdb;
        $api = new API_CGE();
        $parameters = '?filterActive=1&order%5BvisibilityDate%5D=desc';
        $response = $api->getApi('/api/public/job_offers' . $parameters);
        $response = isset($response->{'hydra:member'}) ? $response->{'hydra:member'} : [];
        $apiUrl = 'https://api.cge.asso.fr';
        $emplois_id = [];
        $index = 0;
        foreach ($response as $emploi) {
            if ($index > 4)
                break;
            if (!$emploi->validated && !$emploi->deletedAt) {
                continue;
            } else if ($emploi->deletedAt) {
                continue;
            }
            $posts_emplois = new WP_Query("post_type=cpt_recrutement&meta_key=id_emploi&meta_value=" . $emploi->id);
            $emplois_id[] = $emploi->id;

            if (sizeof($posts_emplois->posts) > 0) {
                $my_post = $posts_emplois->posts[0];

                $my_post->post_title = esc_attr($emploi->name);
                $my_post->post_content = $emploi->description;
                $my_post->post_status = 'publish';
                $my_post->post_date = (string)$emploi->visibilityDate;
                $my_post->post_author = 1;
                $my_post->post_type = 'cpt_recrutement';

                wp_update_post($my_post);
                $action = 'update_post_meta';
                $post_id = $my_post->ID;
            } else {
                $my_post = array();
                $my_post['post_title'] = esc_attr($emploi->name);
                $my_post['post_content'] = $emploi->description;
                $my_post['post_status'] = 'publish';
                $my_post['post_date'] = (string)$emploi->visibilityDate;
                $my_post['post_author'] = 1;
                $my_post['post_type'] = 'cpt_recrutement';

                $post_id = wp_insert_post($my_post);
                $action = 'add_post_meta';
            }

            $action($post_id, 'id_emploi', esc_attr($emploi->id));
            $action($post_id, 'demandeur_emplois', esc_attr($emploi->applicant));
            $action($post_id, 'poste_propose_emplois', esc_attr($emploi->mainPost));
            $action($post_id, 'lieu_emplois', esc_attr($emploi->place));
            $action($post_id, 'date_candidature_emplois', esc_attr($emploi->deadlineForSubmissionOfApplications));
            if (isset($emploi->file)) {
                $fileUrl = $apiUrl . '/uploads/media/' . $emploi->file->slug . '/documents/' . rawurlencode($emploi->file->filePath);
                $upload_path = dirname(__FILE__, 5);
                $targetDocument = $upload_path  . "/uploads/jobs/" . date_format(new \DateTime(), 'Y') . "/" . rawurlencode('document-' . $emploi->id . '.pdf');
                $saved_path = "/wp-content/uploads/jobs/" . date_format(new \DateTime(), 'Y') . "/" . rawurlencode('document-' . $emploi->id . '.pdf');
                try {
                    $regexp = '/&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);/i';
                    $newString = @str_replace('-pdf', '', trim($emploi->file->filePath));
                    //die(var_dump($newString));
                    $targetDocument = $upload_path  . "/uploads/jobs/" . date_format(new \DateTime(), 'Y') . "/" . rawurlencode($newString . '.pdf');
                    $saved_path = "/wp-content/uploads/jobs/" . date_format(new \DateTime(), 'Y') . "/" . rawurlencode($newString . '.pdf');
                } catch (\Exception $e) {
                }

                if (!file_exists($upload_path  . "/uploads/jobs/" . date_format(new \DateTime(), 'Y') . "/"))
                    mkdir($upload_path  . "/uploads/jobs/" . date_format(new \DateTime(), 'Y') . "/", 0755, true);
                file_put_contents($targetDocument, file_get_contents($fileUrl, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)))));
                $action($post_id, 'document_emplois', esc_attr($saved_path));
            }
            
            $action($post_id, 'date_debut_emplois', esc_attr($emploi->startDate));
            $action($post_id, 'date_depot_emplois', esc_attr($emploi->visibilityDate));

            if ($action == 'add_post_meta')
                echo "<p>post <strong>#ID " . $post_id . "</strong> have been created successfully</p>";
            else
                echo "<p>post #ID <strong>" . $post_id . "</strong> have been updated successfully</p>";

            $index++;
        }

        // FIN : Suppression
        $query_all_posts = $wpdb->get_results('SELECT * FROM  ' . $wpdb->prefix . 'posts WHERE post_type= "cpt_recrutement"');
        foreach ($query_all_posts as $t_post) {
            $my_post_meta = get_post_meta($t_post->ID, 'id_emploi', true);
            if (empty($my_post_meta) || $my_post_meta == '' || !in_array($my_post_meta, $emplois_id))
                wp_delete_post($t_post->ID, true);
        }
    }
}

$cron = new Cron_Cpt_Recrutement();
//$cron->deleteAllDatas();
$cron->import_datas();
