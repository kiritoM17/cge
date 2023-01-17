<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');
$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Msalumni
{
    public function import_datas()
    {
        $api = new API_CGE();
        $parameters = 'authorization=1&deletedAt[exists]=false&order[name]=asc&pagination=false';
        $response = $api->getApi('/api/student_program_histories?' . $parameters);
        $meta_prefix = ''; //_msalumni_
        $response = isset($response->{'hydra:member'}) ? $response->{'hydra:member'} : [];

        $index = 0;
        foreach ($response as $json_alumni) {
            $ol_id = $this->getIfPostExist((int)esc_attr(trim($json_alumni->id)));
            $my_post = array();
            $my_post['post_title'] = trim($json_alumni->lastname . ' ' . $json_alumni->firstname);
            $my_post['post_content'] = trim($json_alumni->lastname . ' ' . $json_alumni->firstname);
            $my_post['post_status'] = 'publish';
            $my_post['post_author'] = 1;
            //the id of the author
            $my_post['post_type'] = 'msalumni';
            if (empty($ol_id)) {
                if ($index > 4)
                    break;
                //the id's of the categories
                $post_id = wp_insert_post($my_post);
                add_post_meta($post_id, 'id_msalumni', esc_attr(trim($json_alumni->id)));
                add_post_meta($post_id, 'nom', esc_attr(trim($json_alumni->lastname)));
                add_post_meta($post_id, 'prenom', esc_attr(trim($json_alumni->firstname)));
                add_post_meta($post_id, 'civilite', esc_attr($json_alumni->civility));
                add_post_meta($post_id, 'ecole', esc_attr($json_alumni->schoolAcronym));
                add_post_meta($post_id, 'formation', esc_attr($json_alumni->programTitle));
                add_post_meta($post_id, 'annee_obtention', esc_attr($json_alumni->graduationYear));
                add_post_meta($post_id, 'nationnalite', esc_attr($json_alumni->nationality));
                add_post_meta($post_id, 'date_naissance', esc_attr($json_alumni->birthdate));
                add_post_meta($post_id, 'annee_enregistrement', esc_attr($json_alumni->registrationYear));
                add_post_meta($post_id, 'id_programme', esc_attr($json_alumni->program->id));
                echo "<p>post <strong>#ID " . $post_id . "</strong> have been created successfully</p>";
            } else {
                if ($index > 4)
                    break;
                $post_id = (int)$ol_id[0]->post_id;
                $my_post['ID'] = $post_id;
                wp_update_post($my_post);
                update_post_meta($post_id, 'id_msalumni', esc_attr(trim($json_alumni->id)));
                update_post_meta($post_id, 'nom', esc_attr(trim($json_alumni->lastname)));
                update_post_meta($post_id, 'prenom', esc_attr(trim($json_alumni->firstname)));
                update_post_meta($post_id, 'civilite', esc_attr($json_alumni->civility));
                update_post_meta($post_id, 'ecole', esc_attr($json_alumni->schoolAcronym));
                update_post_meta($post_id, 'formation', esc_attr($json_alumni->programTitle));
                update_post_meta($post_id, 'annee_obtention', esc_attr($json_alumni->graduationYear));
                update_post_meta($post_id, 'nationnalite', esc_attr($json_alumni->nationality));
                update_post_meta($post_id, 'date_naissance', esc_attr($json_alumni->birthdate));
                update_post_meta($post_id, 'annee_enregistrement', esc_attr($json_alumni->registrationYear));
                update_post_meta($post_id, 'id_programme', esc_attr($json_alumni->program->id));
                echo "<p>post #ID <strong>" . $post_id . "</strong> have been updated successfully</p>";
            }
            $index++;
        }
    }

    public function deleteAllDatas()
    {
        global $wpdb;
        $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_type ="msalumni" ');
        $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key in ("nom", "prenom", "civilite", "ecole", "formation", "annee_obtention", "id_msalumni", "nationnalite", "date_naissance", "annee_enregistrement", "id_programme")');
    }

    public function getIfPostExist($id_msalumni)
    {
        global $wpdb;
        $response = $wpdb->get_results('SELECT `post_id` FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = "id_msalumni" AND meta_value = ' . $id_msalumni);
        return $response;
    }
}

$cron = new Cron_Msalumni();
//$cron->deleteAllDatas();
$cron->import_datas();
