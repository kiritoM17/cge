<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Cpt_Publication
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
                if (strpos($item->name, "CP") === false || $item->file_source == "Publications de la CGE" || $item->file_source == "Sources et références externes") {
                    $file_url = $item->file_url_with_name;
                    $posts_publications = new WP_Query("post_type=cpt_publication&meta_key=_cge_publication_id&meta_value=" . $item->id);
                    $files_id[] = $item->id;

                    $pahtInfo = pathinfo(rawurldecode($item->name));
                    if (sizeof($posts_publications->posts) > 0) {
                        $my_post = $posts_publications->posts[0];
                        $my_post->post_title = $pahtInfo['filename'];
                        $my_post->post_status = 'publish';
                        $my_post->post_author = 1;
                        $my_post->post_type = 'cpt_publication';

                        wp_update_post($my_post);
                        $action = 'update_post_meta';
                        $post_id = $my_post->ID;
                    } else {
                        $my_post = array();
                        $my_post['post_title'] = $pahtInfo['filename'];
                        $my_post['post_status'] = 'publish';
                        $my_post['post_author'] = 1;
                        $my_post['post_type'] = 'cpt_publication';

                        $post_id = wp_insert_post($my_post);
                        $action = 'add_post_meta';
                    }

                    $action($post_id, '_cge_publication_url', $file_url);
                    $action($post_id, '_cge_publication_id', $item->id);

                    wp_set_object_terms($post_id, $item->file_source, "sources");
                    wp_set_object_terms($post_id, $item->file_type, "document_type");

                    $themes = array();
                    if (!is_string($item->file_themes)) {
                        foreach ($item->file_themes as $theme) {
                            $themes[] = $theme;
                        }
                    }
                    wp_set_object_terms($post_id, $themes, "type_document_spe");
                    

                    if (!empty($item->file_date_publication))
                        {$action($post_id, '_cge_publication_date', (string)$item->file_date_publication);
                        wp_set_object_terms($post_id, date('Y', strtotime((string)$item->file_date_publication)), "document_annee_publication");}
                    else
                        {$action($post_id, '_cge_publication_date', (string)$item->file_annee);
                        wp_set_object_terms($post_id, date('Y', strtotime((string)$item->file_annee)), "document_annee_publication");}

                    if ($action == 'add_post_meta')
                        echo "<p>post <strong>#ID " . $post_id . "</strong> have been created successfully</p>";
                    else
                        echo "<p>post #ID <strong>" . $post_id . "</strong> have been updated successfully</p>";
                }
            }
            $index++;
        }

        // FIN : Suppression
        $query_all_posts = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'posts WHERE post_type= "cpt_publication"');
        foreach ($query_all_posts as $t_post) {
            $my_post_meta = get_post_meta($t_post->ID, '_cge_publication_id', true);
            if (empty($my_post_meta) || !in_array($my_post_meta, $files_id))
                wp_delete_post($t_post->ID, true);
        }

        // Suppression des terms vides
        $sources = get_terms('sources');
        foreach ($sources as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'sources');
        }
        $document_type = get_terms('document_type');
        foreach ($document_type as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'document_type');
        }
        $type_document_spe = get_terms('type_document_spe');
        foreach ($type_document_spe as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'type_document_spe');
        }
        $annee_publication = get_terms('document_annee_publication');
        foreach ($annee_publication as $value) {
            if ($value->count == 0)
                wp_delete_term($value, 'document_annee_publication');
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

$cron = new Cron_Cpt_Publication();
//$cron->deleteAllDatas();
$cron->import_datas();
