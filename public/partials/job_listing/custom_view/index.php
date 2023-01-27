<?php
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
get_header();
global $post;
echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="">';
$datas = get_post_custom($post->ID);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">

    <section class="head-ecole">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <a href="<?= $datas['_company_website'][0]?>" target="_blanc">
                    <img src="<?php echo isset(get_post_meta($post->ID, "_ecole_logo")[0]) ? get_post_meta($post->ID, "_ecole_logo")[0] : ""; ?>" data-src="<?php echo isset(get_post_meta($post->ID, "_ecole_logo")[0]) ? get_post_meta($post->ID, "_ecole_logo")[0] : ""; ?>" alt="" class="unveil-image">
                </a>
            </div>
            <div class="col-md-8 col-xs-12">
                <a href="#" target="_blanc"><h1 class="section-title"><?= $post->post_title ?></h1></a>
                <p>
                    <?= isset($datas['_ecole_annee_creation'][0]) && $datas['_ecole_annee_creation'][0] != "" ? "Date de création : ".$datas['_ecole_annee_creation'][0] : ""?>
                    <!-- <strong>.</strong> 
                    Date d'adhésion : -->
                    <?=  isset($datas['_ecole_digital_certification_label'][0]) && $datas['_ecole_digital_certification_label'][0] == "Oui" ? "<strong>.</strong> 4Digital" : ""?>
                </p>
            </div>
        </div> 
    </section>
    <section class="ecole-section">
        <h2 class="section-title">Fiche identitaire</h2>
        <div class="row">
            <p class="entry-title-2">Type de formation : <?php echo $datas['_ecole_type_formation'][0] ?></p>
            <p class="entry-title-2">Type d'habilitation : <?php echo $datas['_ecole_type_habilitation'][0] ?></p>
            <p class="entry-title-2">Statut : <?php echo $datas['_ecole_statut'][0] ?></p>
            <p class="entry-title-2">Type de structure : <?php echo $datas['_ecole_type_structure'][0] ?></p>
            <?php if(isset($datas['_ecole_ministere_tutelle_1'][0]) && $datas['_ecole_ministere_tutelle_1'][0] != "Autres"){?>
            <!-- Ministère de tutelle -->
            <p class="entry-title-2">Ministères de tutelle  : <?php echo $datas['_ecole_ministere_tutelle_1'][0] ?></p>
            <!-- fin Ministère de tutelle -->
            <?php }?>
            <?php if(isset($datas['_ecole_organisme_rattachement'][0]) && $datas['_ecole_organisme_rattachement'][0] != ""){?>
            <!-- organisme de ratachement -->
            <p class="entry-title-2">Organisme de rattachement  : <?php echo $datas['_ecole_organisme_rattachement'][0] ?></p>
            <!-- fin organisme de ratachement -->
            <?php }?>
            <p class="entry-title-2">Année de création : <?php echo $datas['_ecole_annee_creation'][0] ?></p>
            <p class="entry-title-2">Habilitation à délivrer le doctorat : <?php echo $datas['_ecole_habilitation_delivrer_doctorat'][0] ?></p>
            <p class="entry-title-2">Prépa intégrée : <?php echo $datas['_ecole_prepa_integree'][0] ?></p> 
        </div>
    </section>
    <section class="ecole-section">
        <h2 class="section-title">Contacts</h2>
        <div class="row">
            <p class="entry-title-2">Directeur général : <?=$datas['_ecole_dg_civilite'][0] ?> <?=$datas['_ecole_dg_prenom'][0]?> <?=$datas['_ecole_dg_nom'][0]?></p>
            <p class="entry-title-2">Directeur des études : <?=$datas['_ecole_de_civilite'][0] ?> <?=$datas['_ecole_de_prenom'][0]?> <?=$datas['_ecole_de_nom'][0]?></p>
            
            <p class="entry-title-2">Responsable des formations : <?php 
                $list_resp_formation = explode('##', $datas['_ecole_resp_formation'][0]);
                $index = 0;
                foreach($list_resp_formation as $resp)
                {
                    if($resp)
                    {
                        if($index == 0)
                            echo $resp;
                        else
                            echo ', ' . $resp;

                        $index++;
                    }
                }
            ?></p>
        </div>
    </section>

    <section class="col-md-12">
        <h2 class="section-title">Adresse </h2>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <p><?=$datas['geolocation_formatted_address'][0]?></p>
            </div>
            <div class="col-md-6 col-xs-12">
                <div id="map" style="height: 200px; width: 100% !important;"></div>
            </div>
        </div>
    </section>
    <section class="col-md-12">
        <?php 
            $tax_query = array(
                'taxonomy' => 'formation_co_accrediteurs',
                'field' => 'slug',
                'operator' => 'IN',
                'terms' => $datas['_ecole_acronyme'][0], // Where term_id of Term 1 is "1".
                'include_children' => false
            );
            $tax_query['relation'] = 'AND';
            $args = array(
                'post_type' => 'cpt_formation',
                'posts_per_page' => -1
            );
            $args['tax_query'] = $tax_query;
            $query = new WP_Query($args);
            if(count($query->posts)>0)
            { ?>
        <h3>Formations </h3>
        <div class="row">
            <a href="#"> Voir nos formations</a>
        </div>
        <?php }?>
    </section>
</div>
<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script>
    let mapLat = <?php echo $datas['geolocation_lat'][0]?>;
    let mapLng = <?php echo $datas['geolocation_long'][0]?>;
    let pictoColor = 'red';
    let mapDefaultZoom = 15;
    var map = L.map('map').setView([mapLat, mapLng], mapDefaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
                    const contentString =`
                        <div class="col"  style="width:400px !important;">
                            <center>
                            <img style="width: 100% !important;height: 200px;" title="<?php echo $post->post_title;?>" alt="<?php echo $post->post_title;?>" src="<?php echo $datas['_ecole_logo'][0];?>" >
                            </center>
                            <div><h5 style="color:var(--fill-cart-title);"><b><?php echo $post->post_title;?></b></h5></div><br>
                            <div><p><i>''</i></p></div><br>
                            <div style="width:300px"><?php echo wp_trim_words( $post->post_content, 20, ' ...' );?></div>
                        </div>
                    `;
    var marker = L.marker([mapLat, mapLng], {
        icon: L.divIcon({
            className:'ship-div-icon',
            html: '<i class="fa fa-map-marker fa-4x" style="color:'+pictoColor+'"></i>'
        }),
    }).addTo(map);
    </script>
<?php get_footer(); ?>