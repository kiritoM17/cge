<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Cpt_Presse
{
    public function import_datas()
    {
        global $wpdb;
        $api = new API_CGE();
        $parameters = '';
        $response = $api->getApi('https://api-ms.cge.asso.fr/api/drives/synchronize-website' . $parameters, [], true);
        $meta_prefix = ''; //_msalumni_
        $response = isset($response->resultats->nodes) ? $response->resultats->nodes : [];
        $result = [];
        $result = $this->synchro_doc_action_v2_create_tab($response, $result);

        $files_id = [];
        $index = 0;
        foreach ($result as $item) {
            if ($index > 4)
                break;
            if ($item->type == "file" && $item->file_name != "") {
                if ($item->file_type == "Communiqué de presse" || $item->file_type == "Dossier de presse") {
                    $file_url = $item->file_url_with_name;
                    $posts_presse = new WP_Query("post_type=cpt_presse&meta_key=_cge_presse_id&meta_value=" . $item->id);
                    $files_id[] = $item->id;

                    if (isset($item->file_date_publication) && $item->file_date_publication != '') {
                        $dateExplode = explode('T', $item->file_date_publication);
                        $annees = explode('-', $dateExplode[0]);
                    } elseif (isset($item->file_annee) && $item->file_annee != '') {
                        $annees[0] = $item->file_annee;
                    } else {
                        $annees[0] = date('Y');
                    }
                    $annees_1 = '01';
                    $annees_2 = '01';
                    if (isset($annees[1]))
                        $annees_1 = $annees[1];
                    if (isset($annees[2]))
                        $annees_2 = $annees[2];

                    $pahtInfo = pathinfo(rawurldecode($item->name));
                    if (sizeof($posts_presse->posts) > 0) {
                        $my_post = $posts_presse->posts[0];
                        $my_post->post_title = $pahtInfo['filename'];

                        $my_post->post_status = 'publish';
                        $my_post->post_author = 1; //the id of the author
                        $my_post->post_type = 'cpt_presse'; //the id's of the categories
                        $my_post->post_date = $annees[0] . "-" . $annees_1 . "-" . $annees_2; //the id's of the categories

                        wp_update_post($my_post);
                        $action = 'update_post_meta';
                        $post_id = $my_post->ID;
                    } else {
                        $my_post = array();

                        $my_post['post_title'] = $pahtInfo['filename'];

                        $my_post['post_status'] = 'publish';
                        $my_post['post_author'] = 1; //the id of the author
                        $my_post['post_type'] = 'cpt_presse'; //the id's of the categories
                        $my_post['post_date'] = $annees[0] . "-" . $annees_1 . "-" . $annees_2; //the id's of the categories

                        $post_id = wp_insert_post($my_post);
                        $action = 'add_post_meta';
                    }

                    // Ne garde que les CP et Dossiers de presse
                    $action($post_id, '_cge_presse_id', $item->id);
                    $action($post_id, '_cge_presse_url', $file_url);
                    $action($post_id, '_cge_presse_file_name', $pahtInfo['filename']);
                    wp_set_object_terms($post_id, $item->file_extension, "document_format_presse");
                    if (sizeof($annees) > 0)
                        wp_set_object_terms($post_id, $annees[0], "annee_presse");
                    wp_set_object_terms($post_id, $item->file_type, "type_document_presse");

                    if ($action == 'add_post_meta')
                        echo "<p>post <strong>#ID " . $post_id . "</strong> have been created successfully</p>";
                    else
                        echo "<p>post #ID <strong>" . $post_id . "</strong> have been updated successfully</p>";
                }
            }
            $index++;
        }

        // FIN : Suppression
        $query_all_posts = $wpdb->get_results('SELECT * FROM  ' . $wpdb->prefix . 'posts WHERE post_type= "cpt_presse"');

        foreach ($query_all_posts as $t_post) {
            $my_post_meta = get_post_meta($t_post->ID, '_cge_presse_id', true);
            if (empty($my_post_meta) || !in_array($my_post_meta, $files_id))
                wp_delete_post($t_post->ID, true);
        }

        $document_format_presse = get_terms('document_format_presse');
        foreach ($document_format_presse as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'document_format_presse');
        }

        $annee_presse = get_terms('annee_presse');
        foreach ($annee_presse as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'annee_presse');
        }

        $type_document_presse = get_terms('type_document_presse');
        foreach ($type_document_presse as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'type_document_presse');
        }
    }

    public function synchro_doc_action_v2_create_tab($json_pubs, $result)
    {
        foreach ($json_pubs as $json_pub) {
            if (isset($json_pub->nodes))
                $result = $this->synchro_doc_action_v2_create_tab($json_pub->nodes, $result);
            else
                $result[] = $json_pub;
        }

        return $result;
    }
}

$cron = new Cron_Cpt_Presse();
//$cron->deleteAllDatas();
$cron->import_datas();
