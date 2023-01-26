<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Cpt_Formation
{
    public function import_datas()
    {
        global $wpdb;
        $api = new API_CGE();
        $parameters = '';
        $formations = simplexml_load_file('https://api-v1.cge.asso.fr/formations?limit=0&type=detail'); //simplexml_load_string($response);

        $formations = isset($formations->formations->formation) ? $formations->formations->formation : [];

        $ids_formations = [];

        $index = 1;
        foreach ($formations as $formation) {
            $program_course_details = $api->getApi('/api/programs/' . (int)$formation->id);
            //die(var_dump($formation, $program_course_details));

            if ($index > 4)
                break;
            $posts_formations = new WP_Query("post_type=cpt_formation&meta_key=_formation_id&meta_value=$formation->id");
            $ids_formations[] = $formation->id;

            $action = 'update_post_meta';

            // La formation existe déjà
            if (sizeof($posts_formations->posts) > 0) {
                $my_post = $posts_formations->posts[0];
                $my_post->post_title = esc_attr($formation->intitule);
                $my_post->post_status = 'publish';
                $my_post->post_author = 1;
                $my_post->post_type = 'cpt_formation';

                wp_update_post($my_post);
                $action = 'update_post_meta';
                $post_id = $my_post->ID;
                // La formation n'existe pas: on la crée
            } else {
                $my_post = array();
                $my_post['post_title'] = esc_attr($formation->intitule);
                $my_post['post_status'] = 'publish';
                $my_post['post_author'] = 1;
                $my_post['post_type'] = 'cpt_formation';

                $post_id = wp_insert_post($my_post);
                $action = 'add_post_meta';
            }

            $action($post_id, '_formation_id', esc_attr($formation->id));
            $action($post_id, '_formation_ecole_id', esc_attr($formation->ecole->id));
            $action($post_id, '_formation_ecole_acronyme', esc_attr($formation->ecole->acronyme));
            $action($post_id, '_formation_ecole_nom', esc_attr($formation->ecole->nom));

            $co_acc = [];
            foreach ($formation->co_accreditations->co_accreditation as $acc) {
                $co_acc[] = esc_attr($acc->acronyme);
            }

            $action($post_id, '_formation_co_accrediteurs', $co_acc);
            $action($post_id, '_formation_langues_enseignements', esc_attr($formation->langues_enseignements));
            $action($post_id, '_formation_partenaires', esc_attr($formation->partenaires));
            $action($post_id, '_formation_description_lieu_formation', esc_attr($formation->description_lieu_formation));
            $action($post_id, '_formation_duree_formation_mois', esc_attr($formation->duree_formation_mois));

            $site = $formation->websites->website;
            if (stripos($site, 'http://') === false && stripos($site, 'https://') === false) {
                $site = 'http://' . $site;
            }
            $action($post_id, '_formation_website', esc_attr($site));


            $action($post_id, '_formation_directeur_responsable_ms_msc_badge_cqc', esc_attr($formation->directeur_responsable_ms_msc_badge_cqc->email));
            $action($post_id, '_formation_responsable_academique', esc_attr($formation->responsable_academique->email));

            if (!term_exists('ecole_' . $formation->ecole->id, 'formation_ecole')) {
                $term_id = wp_insert_term(esc_attr($formation->ecole->acronyme), 'formation_ecole', array('slug' => 'ecole_' . $formation->ecole->id));
            } else {
                $term_id = get_term_by('slug', 'ecole_' . $formation->ecole->id, 'formation_ecole')->term_id;
            }
            wp_set_object_terms($post_id, $term_id, "formation_ecole");

            if (!term_exists($formation->type_formation, 'formation_type')) {
                $term_id = wp_insert_term(esc_attr($formation->type_formation), 'formation_type');
            } else {
                $term_id = get_term_by('name', $formation->type_formation, 'formation_type')->term_id;
            }
            wp_set_object_terms($post_id, $term_id, "formation_type");

            wp_set_object_terms($post_id, $co_acc, "formation_co_accrediteurs");

            foreach ($formation->domaines->domaine as $domaine) {
                if (!term_exists($domaine, 'formations_domaines')) {
                    $term_id = wp_insert_term(esc_attr($domaine), 'formations_domaines');
                } else {
                    $term_id = get_term_by('name', $domaine, 'formations_domaines')->term_id;
                }
                wp_set_object_terms($post_id, $term_id, "formations_domaines", true);
            }

            foreach ($formation->themes->theme as $theme) {
                if (!term_exists($theme, 'formations_themes')) {
                    $term_id = wp_insert_term(esc_attr($theme), 'formations_themes');
                } else {
                    $term_id = get_term_by('name', $theme, 'formations_themes')->term_id;
                }
                wp_set_object_terms($post_id, $term_id, "formations_themes", true);
            }

            if ($action == 'add_post_meta')
                echo "<p>post <strong>#ID " . $post_id . "</strong> have been created successfully</p>";
            else
                echo "<p>post #ID <strong>" . $post_id . "</strong> have been updated successfully</p>";
            $index++;
        }

        // FIN : Suppression des cpt_formation qui n'ont pas d'ID formation ou dont l'id formation n'est pas dans $ids_formations et leurs metas
        $query_all_posts = $wpdb->get_results('SELECT * FROM  ' . $wpdb->prefix . 'posts WHERE post_type= "cpt_formation"');
        foreach ($query_all_posts as $t_post) {
            $my_post_meta = get_post_meta($t_post->ID, '_formation_id', true);
            if (empty($my_post_meta) || $my_post_meta == '' || !in_array($my_post_meta, $ids_formations))
                wp_delete_post($t_post->ID, true);
        }

        // Suppression des terms qui n'ont aucun item
        $formation_type = get_terms('formation_type', array(
            'hide_empty' => false,
        ));
        foreach ($formation_type as $value) {
            if ($value->count == 0)
                wp_delete_term($value->term_id, 'formation_type');
        }
        $formation_ecole = get_terms('formation_ecole', array(
            'hide_empty' => false,
        ));
        foreach ($formation_ecole as $value) {
            if ($value->count == 0)
                wp_delete_term($value->term_id, 'formation_ecole');
        }
        $formation_co_accrediteurs = get_terms('formation_co_accrediteurs', array(
            'hide_empty' => false,
        ));
        foreach ($formation_co_accrediteurs as $value) {
            if ($value->count == 0)
                wp_delete_term($value->term_id, 'formation_co_accrediteurs');
        }
        $formations_domaines = get_terms('formations_domaines', array(
            'hide_empty' => false,
        ));
        foreach ($formations_domaines as $value) {
            if ($value->count == 0)
                wp_delete_term($value->term_id, 'formations_domaines');
        }
        $formations_themes = get_terms('formations_themes', array(
            'hide_empty' => false,
        ));
        foreach ($formations_themes as $value) {
            if ($value->count == 0)
                wp_delete_term($value->term_id, 'formations_themes');
        }
    }

    public function import_datas_v2()
    {
        global $wpdb;
        $api = new API_CGE();
        $parameters = 'filterActive=1&order%5BupdatedAt%5D=desc&start=0&length=800';
        $formations = $api->getApi("/api/programs?$parameters");
        $formations = isset($formations->{'hydra:member'}) ? $formations->{'hydra:member'} : [];
        $index = 0;
        foreach ($formations as $formation) {
            if ($index > 4)
                break;
            $posts_formations = new WP_Query("post_type=cpt_formation&meta_key=_formation_id&meta_value=$formation->id");
            $ids_formations[] = $formation->id;
            $action = 'update_post_meta';
            // La formation existe déjà
            if (sizeof($posts_formations->posts) > 0) {
                $my_post = $posts_formations->posts[0];
                $my_post->post_title = esc_attr($formation->name);
                $my_post->post_status = 'publish';
                $my_post->post_author = 1;
                $my_post->post_type = 'cpt_formation';

                wp_update_post($my_post);
                $action = 'update_post_meta';
                $post_id = $my_post->ID;
                // La formation n'existe pas: on la crée
            } else {
                $my_post = array();
                $my_post['post_title'] = esc_attr($formation->name);
                $my_post['post_status'] = 'publish';
                $my_post['post_author'] = 1;
                $my_post['post_type'] = 'cpt_formation';
                $post_id = wp_insert_post($my_post);
                $action = 'add_post_meta';
            }
            $action($post_id, '_formation_id', esc_attr($formation->id));
            $action($post_id, '_formation_ecole_id', esc_attr($formation->school->id));
            $action($post_id, '_formation_ecole_acronyme', esc_attr($formation->school->acronym));
            $action($post_id, '_formation_ecole_nom', esc_attr($formation->school->name));

            $co_acc = [];
            foreach ($formation->coAccreditations as $acc) {
                $co_acc[] = esc_attr($acc->school->acronym);
            }
            $action($post_id, '_formation_co_accrediteurs', $co_acc);
            //programCourses
            //die(var_dump($formation, $co_acc, $formation->academicProgramPartners));
            $langues_enseignements = [];
            if (isset($formation->programCourses)) {
                foreach ($formation->programCourses as $course) {
                }
            }
            // $action($post_id, '_formation_langues_enseignements', esc_attr($formation->langues_enseignements));

            //partenaires
            $partenaires = [];
            if (isset($formation->academicProgramPartners)) {
                foreach ($formation->academicProgramPartners as $partenaire) {
                    $partenaires[] = $partenaire->name;
                }
            }

            if (isset($formation->professionalProgramPartners)) {
                foreach ($formation->professionalProgramPartners as $partenaire) {
                    $partenaires[] = $partenaire->name;
                }
            }

            if (isset($formation->associatedProgramPartners)) {
                foreach ($formation->associatedProgramPartners as $partenaire) {
                    $partenaires[] = $partenaire->name;
                }
            }
            $action($post_id, '_formation_partenaires', implode(",", $partenaires));

            //Lieu formation
            $description_lieu_formation = [];
            if (isset($formation->school->member->establishments)) {
                foreach ($formation->school->member->establishments as $etablissement) {
                    $description_lieu_formation[] = $etablissement->postalAddress->city;
                }
            }
            $action($post_id, '_formation_description_lieu_formation', implode(",", $description_lieu_formation));

            //pas encore trouvé
            // $action($post_id, '_formation_duree_formation_mois', esc_attr($formation->duree_formation_mois));
            $index++;
        }
    }
}

$cron = new Cron_Cpt_Formation();
// $cron->deleteAllDatas();
// die(var_dump('end'));
$cron->import_datas();
