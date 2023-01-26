<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Cpt_Membre
{
    public $apiUrl = 'https://api.cge.asso.fr';
    public function import_datas($type)
    {
        if ($type == 'organization')
            $this->importOrganizations();
        else if ($type == 'compagny')
            $this->importCompagnies();
    }

    public function importCompagnies()
    {
        $api = new API_CGE();
        $parameters = '';
        $response = $api->getApi('/api/companies?' . $parameters);
        $response = isset($response->{'hydra:member'}) ? $response->{'hydra:member'} : [];
        $index = 0;
        foreach ($response as $compagny) {
            //die(var_dump($compagny));
            if ($index > 4)
                break;
            $posts_ecoles = new WP_Query("post_type=cge_membre&meta_key=cge_membre_id&meta_value=" . $compagny->id);
            $ids_ecoles[] = $compagny->id;
            // Create post object
            $my_post = array();
            $my_post['post_title'] = esc_attr($compagny->acronym);
            $my_post['post_content'] = $compagny->name;
            $my_post['post_status'] = 'publish';
            $my_post['post_author'] = 1; //the id of the author
            $my_post['post_type'] = 'cge_membre'; //the id's of the categories
            if (sizeof($posts_ecoles->posts) > 0) {
                $my_post['ID'] = $posts_ecoles->posts[0]->ID;
                wp_update_post($my_post);
                $action = 'update_post_meta';
                $action($posts_ecoles->posts[0]->ID, '_cge_membre_type', 'entreprise');
                $this->updateMeta($action, $posts_ecoles->posts[0]->ID, $compagny);
                echo "<p>post <strong>#ID " . $posts_ecoles->posts[0]->ID . "</strong> have been updated successfully</p>";
            } else {
                $action = 'add_post_meta';
                $post_id = wp_insert_post($my_post);
                $action($post_id, '_cge_membre_type', 'entreprise');
                $this->updateMeta($action, $post_id, $compagny);
                echo "<p>post #ID <strong>" . $post_id . "</strong> have been created successfully</p>";
            }
            $index++;
        }
    }

    public function importOrganizations()
    {
        $api = new API_CGE();
        $parameters = ''; //'filterActive=1&order%5Bacronym%5D=asc&&start=0&length=-1';
        $response = $api->getApi('/api/organizations?' . $parameters);
        $response = isset($response->{'hydra:member'}) ? $response->{'hydra:member'} : [];
        $index = 0;
        foreach ($response as $organization) {
            //var_dump($organization);
            if ($index > 4)
                break;
            $posts_ecoles = new WP_Query("post_type=cge_membre&meta_key=cge_membre_id&meta_value=" . $organization->id);
            $ids_ecoles[] = $organization->id;
            // Create post object
            $my_post = array();
            $my_post['post_title'] = esc_attr($organization->acronym);
            $my_post['post_content'] = $organization->name;
            $my_post['post_status'] = 'publish';
            $my_post['post_author'] = 1; //the id of the author
            $my_post['post_type'] = 'cge_membre'; //the id's of the categories
            $association = isset($organization->teacherAssociation) && $organization->teacherAssociation ? 'association_professeur' : (isset($organization->alumniAssociation) && $organization->alumniAssociation ? 'association_alumni' : 'association_autre');
            if (sizeof($posts_ecoles->posts) > 0) {
                $action = 'update_post_meta';
                $my_post['ID'] = $posts_ecoles->posts[0]->ID;
                wp_update_post($my_post);
                $action($posts_ecoles->posts[0]->ID, '_cge_membre_type', 'organisme');
                $action($posts_ecoles->posts[0]->ID, '_cge_membre_organisme', $association);
                $this->updateMeta('update_post_meta', $posts_ecoles->posts[0]->ID, $organization);
                echo "<p>post <strong>#ID " . $posts_ecoles->posts[0]->ID . "</strong> have been updated successfully</p>";
            } else {
                $action = 'add_post_meta';
                $post_id = wp_insert_post($my_post);
                $action($post_id, '_cge_membre_type', 'organisme');
                $action($post_id, '_cge_membre_organisme', $association);
                $this->updateMeta('add_post_meta', $post_id, $organization);
                echo "<p>post #ID <strong>" . $post_id . "</strong> have been created successfully</p>";
            }
            $index++;
        }
    }

    public function updateMeta($action, $post_id, $post)
    {
        $action($post_id, 'cge_membre_id', esc_attr($post->id));
        $action($post_id, '_cge_membre_url', esc_attr($post->member->webLink->url));
        $fileUrl = $this->apiUrl . '/uploads/media/' . $post->picture->slug . '/documents/' . rawurlencode($post->picture->filePath);
        $upload_path = dirname(__FILE__, 5);
        $targetDocument = $upload_path  . "/uploads/members/" . date_format(new \DateTime(), 'Y') . "/" . rawurlencode('member-' . $post->id . '.jpg');
        $picture = "/wp-content/uploads/members/" . date_format(new \DateTime(), 'Y') . "/" . rawurlencode('member-' . $post->id . '.jpg');
        if (!file_exists($upload_path  . "/uploads/members/" . date_format(new \DateTime(), 'Y') . "/"))
            mkdir($upload_path  . "/uploads/members/" . date_format(new \DateTime(), 'Y') . "/", 0755, true);
        file_put_contents($targetDocument, file_get_contents($fileUrl, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)))));
        $action($post_id, '_cge_membre_image', esc_attr($picture));
    }
}

$cron = new Cron_Cpt_Membre();
// $cron->deleteAllDatas();
// die(var_dump('end'));
$cron->import_datas('organization');
