<?php
$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__,2)) . 'includes/class-cge-api.php';
class Cron_Job_Listing
{
    public function import_job_listing()
    {
        $ecoles = simplexml_load_file('https://api-v1.cge.asso.fr/ecoles?limit=10&type=detail');
        $index = 0;
        foreach ($ecoles->ecoles->ecole as $ecole){
            if($index > 4)
                break;

            // Create post object
            $my_post = array();
            $my_post['post_title'] = esc_attr($ecole->acronyme);
            $my_post['post_content'] = $ecole->presentation;
            $my_post['post_status'] = 'publish';
            $my_post['post_author'] = 1; //the id of the author
            $my_post['post_type'] = 'job_listing'; //the id's of the categories

            // Insert the post into the database
            $post_id = wp_insert_post( $my_post ); //store new post id into $post_id

            add_post_meta(  $post_id,  '_ecole_id', esc_attr($ecole->id));
            add_post_meta(  $post_id,  '_ecole_logo', esc_attr($ecole->logo));
            add_post_meta(  $post_id,  '_ecole_acronyme', esc_attr($ecole->acronyme));
            add_post_meta(  $post_id,  '_ecole_nom', esc_attr($ecole->nom));
            add_post_meta(  $post_id,  '_ecole_type_formation', esc_attr($ecole->type_formation));
            add_post_meta(  $post_id,  '_ecole_statut', esc_attr($ecole->statut));
            add_post_meta(  $post_id,  '_ecole_annee_creation', esc_attr($ecole->annee_creation));

            add_post_meta(  $post_id, '_job_location', esc_attr($ecole->siege_social->ville));
            add_post_meta(  $post_id,  '_job_hours', 'Mon-Thur: 12:00 – 23:00\nFri: 12:00 – 00:00\nSat: 9:00 – 00:00\nSun: 9:00 – 23:30\n');
            add_post_meta(  $post_id, '_company_website',esc_attr($ecole->websites->website));

            add_post_meta(  $post_id,  'geolocation_formatted_address', esc_attr($ecole->siege_social->adresse_1).", ".esc_attr($ecole->siege_social->adresse_2.", ". esc_attr($ecole->siege_social->code_postal)  .", ". esc_attr($ecole->siege_social->ville) .", ".esc_attr($ecole->siege_social->pays)));
            add_post_meta(  $post_id,  'geolocation_city', esc_attr($ecole->siege_social->ville));
            add_post_meta(  $post_id,  'geolocation_state_short', esc_attr($ecole->siege_social->pays));
            add_post_meta(  $post_id,  'geolocation_state_long', esc_attr($ecole->siege_social->pays));
            add_post_meta(  $post_id,  'geolocation_country_long', esc_attr($ecole->siege_social->pays));

            add_post_meta(  $post_id,  '_ecole_type_structure', esc_attr($ecole->type_structure_1) .' '.esc_attr($ecole->type_structure_2));
            add_post_meta(  $post_id,  '_ecole_ministere_tutelle_1', esc_attr($ecole->ministere_tutelle_1));
            add_post_meta(  $post_id,  '_ecole_organisme_rattachement', esc_attr($ecole->organisme_rattachement));
            add_post_meta(  $post_id,  '_ecole_habilitation_delivrer_doctorat', esc_attr($ecole->habilitation_delivrer_doctorat));
            add_post_meta(  $post_id,  '_ecole_prepa_integree', esc_attr($ecole->prepa_integree));
            add_post_meta(  $post_id,  '_ecole_type_habilitation', esc_attr($ecole->type_habilitation));

            //centres_documentations
            add_post_meta(  $post_id,  '_ecole_centres_documentation_horaires', esc_attr($ecole->centres_documentations->centre_documentation->horaires));
            add_post_meta(  $post_id,  '_ecole_centres_documentation_responsable_civilite', esc_attr($ecole->centres_documentations->centre_documentation->responsable->civilite));
            add_post_meta(  $post_id,  '_ecole_centres_documentation_responsable_nom', esc_attr($ecole->centres_documentations->centre_documentation->responsable->nom));
            add_post_meta(  $post_id,  '_ecole_centres_documentation_responsable_prenom', esc_attr($ecole->centres_documentations->centre_documentation->responsable->prenom));
            add_post_meta(  $post_id,  '_ecole_centres_documentation_responsable_telephone', esc_attr($ecole->centres_documentations->centre_documentation->responsable->telephone));
            add_post_meta(  $post_id,  '_ecole_centres_documentation_responsable_email', esc_attr($ecole->centres_documentations->centre_documentation->responsable->email));

            //contact
            add_post_meta(  $post_id,  '_ecole_dg_civilite', esc_attr($ecole->directeurs_generaux->contact->civilite));
            add_post_meta(  $post_id,  '_ecole_dg_nom', esc_attr($ecole->directeurs_generaux->contact->nom));
            add_post_meta(  $post_id,  '_ecole_dg_prenom', esc_attr($ecole->directeurs_generaux->contact->prenom));

            add_post_meta(  $post_id,  '_ecole_de_civilite', esc_attr($ecole->directeurs_etudes->contact->civilite));
            add_post_meta(  $post_id,  '_ecole_de_nom', esc_attr($ecole->directeurs_etudes->contact->nom));
            add_post_meta(  $post_id,  '_ecole_de_prenom', esc_attr($ecole->directeurs_etudes->contact->prenom));

            $resp_for ="";
            $assoc    ="";

                foreach ($ecole->responsables_formations->contact as $responsable_formation){
                $resp_for.=esc_attr($responsable_formation->prenom). " ".esc_attr($responsable_formation->nom ." - ");
                }
                add_post_meta(  $post_id,  '_ecole_resp_formation', $resp_for);

                foreach ($ecole->associations->association as $association){
                $assoc.=esc_attr($association->nom). "##";
                }
                add_post_meta(  $post_id,  '_ecole_associations', $assoc);

                foreach ($ecole->accords_internationaux->accord_international as $accord_internationaux){
                        add_post_meta(  $post_id,  '_ecole_accords_internationaux_', esc_attr($accord_internationaux->zone_geographique). "##".esc_attr($accord_internationaux->institution_partenaire_pays). "##".esc_attr($accord_internationaux->ville). "##".esc_attr($accord_internationaux->institution_partenaire). "##".esc_attr($accord_internationaux->natures));
                }


                wp_set_object_terms($post_id, $ecole->region, "job_listing_region");
                wp_set_object_terms($post_id, $ecole->type_formation, "job_listing_type");

                if($ecole->siege_social->pays == "FRANCE"){
                        wp_set_object_terms($post_id, "France", "job_listing_amenity");
                } else{
                        wp_set_object_terms($post_id, "Étranger", "job_listing_amenity");
                }

        }
    }
}

$cron_Job_Listing = new Cron_Job_Listing();
$cron_Job_Listing->import_job_listing();