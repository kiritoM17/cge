<?php
@set_time_limit(-1);
ini_set('memory_limit', '4048M');

$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__, 2)) . 'includes/class-cge-api.php';
class Cron_Job_Listing
{
        public function import_datas()
        {
                $api = new API_CGE();
                $parameters = 'filterActive=1&order%5Bacronym%5D=asc&member.memberApplicationStatus.id=1&start=0&length=800';
                $response = $api->getApi('/api/public/schools?' . $parameters);
                $meta_prefix = ''; //_msalumni_
                $apiUrl = 'https://api.cge.asso.fr';
                $ids_ecoles = [];
                $response = isset($response->{'hydra:member'}) ? $response->{'hydra:member'} : [];
                $index = 0;
                foreach ($response as $ecole) {
                        if ($index > 4)
                                break;
                        if (!$ecole->validated) {
                                $ids_ecoles[] = $ecole->id;
                                continue;
                        }
                        $posts_ecoles = new WP_Query("post_type=job_listing&meta_key=_ecole_id&meta_value=" . $ecole->id);
                        $ids_ecoles[] = $ecole->id;
                        // Create post object
                        $my_post = array();
                        $my_post['post_title'] = esc_attr($ecole->acronym);
                        $my_post['post_content'] = $ecole->presentationFrench;
                        $my_post['post_status'] = 'publish';
                        $my_post['post_author'] = 1; //the id of the author
                        $my_post['post_type'] = 'job_listing'; //the id's of the categories
                        if (sizeof($posts_ecoles->posts) > 0) {
                                $my_post['ID'] = $posts_ecoles->posts[0]->ID;
                                wp_update_post($my_post);
                                $this->updateEcoleApiV2('update_post_meta', $posts_ecoles->posts[0]->ID, $ecole, $apiUrl);
                                echo "<p>post <strong>#ID " . $posts_ecoles->posts[0]->ID . "</strong> have been updated successfully</p>";
                        } else {
                                $post_id = wp_insert_post($my_post);
                                $this->updateEcoleApiV2('add_post_meta', $post_id, $ecole, $apiUrl);
                                echo "<p>post #ID <strong>" . $post_id . "</strong> have been created successfully</p>";
                        }
                        $index++;
                }
        }

        public function deleteAllDatas()
        {
                global $wpdb;
                $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_type ="job_listing" ');
                $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE post_id NOT IN (SELECT ID FROM ' . $wpdb->prefix . 'posts )');
        }

        public function getIfPostExist($id)
        {
                global $wpdb;
                $response = $wpdb->get_results('SELECT `post_id` FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = "_ecole_id" AND meta_value = ' . $id);
                return $response;
        }

        public function updateEcoleApiV2($action, $post_id, $ecole, $apiUrl = '')
        {
                $action($post_id, '_ecole_id', esc_attr($ecole->id));
                if (isset($ecole->picture)) {
                        $picUrl = $apiUrl . '/uploads/media/' . $ecole->picture->slug . '/documents/' . $ecole->picture->filePath;
                        $action($post_id, '_ecole_logo', esc_attr($picUrl));
                }

                $action($post_id, '_ecole_acronyme', esc_attr($ecole->acronym));
                $action($post_id, '_ecole_nom_usage', esc_attr($ecole->brandName));
                $action($post_id, '_ecole_nom', esc_attr($ecole->name));
                $ptLabel = '';
                foreach ($ecole->schoolProgramTypes as $pt) {
                        if ($ptLabel != '') {
                                $ptLabel .= ' / ';
                        }

                        $ptLabel .= $pt->name;
                }
                $action($post_id, '_ecole_type_formation', esc_attr($ptLabel));
                $action($post_id, '_ecole_statut', esc_attr($ecole->schoolStatus->name));
                $action($post_id, '_ecole_annee_creation', esc_attr($ecole->creationYear));

                $action($post_id, '_job_location', esc_attr($ecole->headoffice->postalAddress->city));
                $action($post_id, '_job_hours', 'Mon-Thur: 12:00 – 23:00\nFri: 12:00 – 00:00\nSat: 9:00 – 00:00\nSun: 9:00 – 23:30\n');
                $site = $ecole->member->webLink->url;
                if (stripos($site, 'http://') === false && stripos($site, 'https://') === false) {
                        $site = 'http://' . $site;
                }
                $action($post_id, '_company_website', esc_attr($site));

                if (sizeof($ecole->structureTypes) > 0) {
                        $action($post_id, '_ecole_type_structure', esc_attr($ecole->structureTypes[0]->name . ' ' . (isset($ecole->structureTypes[1]) ? $ecole->structureTypes[1]->name : '')));
                } else {
                        delete_post_meta($post_id, '_ecole_type_structure');
                }
                if (sizeof($ecole->supervisingMinistries) > 0) {
                        $action($post_id, '_ecole_ministere_tutelle_1', esc_attr($ecole->supervisingMinistries[0]->name));
                } else {
                        delete_post_meta($post_id, '_ecole_ministere_tutelle_1');
                }
                if (sizeof($ecole->linkedOrganizations) > 0) {
                        $action($post_id, '_ecole_organisme_rattachement', esc_attr($ecole->linkedOrganizations[0]->name));
                } else {
                        delete_post_meta($post_id, '_ecole_organisme_rattachement');
                }

                $action($post_id, '_ecole_habilitation_delivrer_doctorat', esc_attr($ecole->phdCapacity ? 'Oui' : 'Non'));
                $action($post_id, '_ecole_prepa_integree', esc_attr($ecole->fiveYearsCurriculum ? 'Oui' : 'Non'));
                $action($post_id, '_ecole_type_habilitation', esc_attr(isset($ecole->accreditationType) ? $ecole->accreditationType->name : ''));

                //centres_documentations
                if (sizeof($ecole->schoolLibraries) > 0) {
                        $action($post_id, '_ecole_centres_documentation_horaires', esc_attr($ecole->schoolLibraries[0]->schedule));
                        $action($post_id, '_ecole_centres_documentation_responsable_civilite', esc_attr($ecole->schoolLibraries[0]->responsiblePerson->honorificPrefix->name));
                        $action($post_id, '_ecole_centres_documentation_responsable_nom', esc_attr($ecole->schoolLibraries[0]->responsiblePerson->familyName));
                        $action($post_id, '_ecole_centres_documentation_responsable_prenom', esc_attr($ecole->schoolLibraries[0]->responsiblePerson->givenName));
                        $action($post_id, '_ecole_centres_documentation_responsable_telephone', esc_attr(sizeof($ecole->schoolLibraries[0]->responsiblePerson->phones) > 0 ? $ecole->schoolLibraries[0]->responsiblePerson->phones[0]->number : ''));
                        $action($post_id, '_ecole_centres_documentation_responsable_email', esc_attr(sizeof($ecole->schoolLibraries[0]->responsiblePerson->emails) > 0 ? $ecole->schoolLibraries[0]->responsiblePerson->emails[0]->address : ''));
                } else {
                        delete_post_meta($post_id, '_ecole_centres_documentation_horaires');
                        delete_post_meta($post_id, '_ecole_centres_documentation_responsable_civilite');
                        delete_post_meta($post_id, '_ecole_centres_documentation_responsable_nom');
                        delete_post_meta($post_id, '_ecole_centres_documentation_responsable_prenom');
                        delete_post_meta($post_id, '_ecole_centres_documentation_responsable_telephone');
                        delete_post_meta($post_id, '_ecole_centres_documentation_responsable_email');
                }
                //contact
                if (isset($ecole->director)) {
                        $action($post_id, '_ecole_dg_civilite', esc_attr($ecole->director->honorificPrefix->name));
                        $action($post_id, '_ecole_dg_nom', esc_attr($ecole->director->familyName));
                        $action($post_id, '_ecole_dg_prenom', esc_attr($ecole->director->givenName));
                } else {
                        delete_post_meta($post_id, '_ecole_dg_civilite');
                        delete_post_meta($post_id, '_ecole_dg_nom');
                        delete_post_meta($post_id, '_ecole_dg_prenom');
                }

                if (isset($ecole->studyDirector)) {
                        $action($post_id, '_ecole_de_civilite', esc_attr($ecole->studyDirector->honorificPrefix->name));
                        $action($post_id, '_ecole_de_nom', esc_attr($ecole->studyDirector->familyName));
                        $action($post_id, '_ecole_de_prenom', esc_attr($ecole->studyDirector->givenName));
                } else {
                        delete_post_meta($post_id, '_ecole_de_civilite');
                        delete_post_meta($post_id, '_ecole_de_nom');
                        delete_post_meta($post_id, '_ecole_de_prenom');
                }

                $resp_for = "";
                $assoc = "";
                foreach ($ecole->programResponsiblePersons as $responsable_formation) {
                        if ($resp_for != '')
                                $resp_for .= ' - ';
                        $resp_for .= "##" . esc_attr($responsable_formation->givenName) . " " . esc_attr($responsable_formation->familyName);
                }
                $action($post_id, '_ecole_resp_formation', $resp_for);

                foreach ($ecole->associations as $association) {
                        $assoc .= esc_attr($association->name) . "##";
                }
                $action($post_id, '_ecole_associations', $assoc);

                //    RETRAIT ACCORDS INTERNATIONAUX
                $id_accords = [];

                delete_post_meta($post_id, '_ecole_accords_internationaux_');
                $metas = get_post_meta($post_id);
                foreach ($metas as $k => $v) {
                        // Suppression de l'accord si il est encore avec l'ancienne notation
                        // Ou si il n'est pas dans la liste
                        $value = explode('_ecole_accords_internationaux', $k);
                        if (sizeof($value) > 1) {
                                if (($value[1] && ($k == '_ecole_accords_internationaux' . $value[1] && !in_array($value[1], $id_accords)))) {
                                        delete_post_meta($post_id, $k);
                                }
                        }

                        if ($k == '_ecole_accords_internationaux_' || $k == '_ecole_accords_internationaux') {
                                delete_post_meta($post_id, $k);
                        }
                }

                wp_set_object_terms($post_id, $ecole->academy->region->name, "job_listing_region");
                $types_formation = '';
                foreach ($ecole->schoolProgramTypes as $pt) {
                        if ($types_formation != '')
                                $types_formation .= ' / ';
                        $types_formation .= $pt->name;
                }
                wp_set_object_terms($post_id, $types_formation, "job_listing_type");

                if (isset($ecole->headoffice)) {
                        if (isset($ecole->headoffice->postalAddress->country) && strtoupper($ecole->headoffice->postalAddress->country->name) == "FRANCE") {
                                wp_set_object_terms($post_id, "France", "job_listing_amenity");
                        } else {
                                wp_set_object_terms($post_id, "Étranger", "job_listing_amenity");
                        }

                        $action($post_id, 'geolocation_long', esc_attr($ecole->headoffice->postalAddress->longitude));
                        $action($post_id, 'geolocation_lat', esc_attr($ecole->headoffice->postalAddress->latitude));
                }

                $cat = get_term_by('slug', 'chapitre', 'job_listing_category');

                if ($cat) {
                        $catID = $cat->term_id;
                        if ($ecole->isHeading) {
                                wp_set_post_terms($post_id, $catID, 'job_listing_category');
                        } else {
                                wp_remove_object_terms($post_id, $catID, 'job_listing_category');
                        }
                }

                if (isset($ecole->headoffice)) {
                        $action($post_id, 'geolocation_formatted_address', esc_attr($ecole->headoffice->postalAddress->streetAddressLine1) . ", " . esc_attr($ecole->headoffice->postalAddress->city) . " " . esc_attr($ecole->headoffice->postalAddress->postalCode) . ", " . esc_attr(isset($ecole->headoffice->postalAddress->country) ? $ecole->headoffice->postalAddress->country->name : ''));
                        $action($post_id, 'geolocation_city', esc_attr($ecole->headoffice->postalAddress->city));
                        if (isset($ecole->headoffice->postalAddress->country)) {
                                $action($post_id, 'geolocation_state_short', esc_attr($ecole->headoffice->postalAddress->country->alpha2Code));
                                $action($post_id, 'geolocation_state_long', esc_attr($ecole->headoffice->postalAddress->country->name));
                                $action($post_id, 'geolocation_country_long', esc_attr($ecole->headoffice->postalAddress->country->name));
                                $action($post_id, 'geolocation_country_short', esc_attr($ecole->headoffice->postalAddress->country->alpha2Code));
                        }

                        // Override des valeurs générées par l'appli maps
                        $action($post_id, 'geolocation_street', esc_attr($ecole->headoffice->postalAddress->streetAddressLine1));
                        $action($post_id, 'geolocation_street_number', esc_attr(''));
                }

                $campusInfos = [];
                foreach ($ecole->member->establishments as $etablissement) {
                        if ($etablissement->establishmentType->name == "Campus") {
                                $campus = $etablissement;
                                if ($campus && isset($campus->postalAddress->latitude) && isset($campus->postalAddress->longitude)) {
                                        $latitude = $campus->postalAddress->latitude;
                                        $longitude = $campus->postalAddress->longitude;

                                        if ($latitude && $longitude) {
                                                $campusInfos[] = [
                                                        'latitude' => (string)$latitude,
                                                        'longitude' => (string)$longitude
                                                ];
                                        }
                                }
                        }
                }
                $action($post_id, 'localisation_campus', json_encode($campusInfos));
        }
}

$cron = new Cron_Job_Listing();
// $cron->deleteAllDatas();
// die(var_dump('end'));
$cron->import_datas();
