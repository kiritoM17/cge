<?php
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
get_header();
global $post;
echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="">';

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">

    <div class="entry-content row">
        <h2 class="entry-title-2">PRESENTATION</h2> 
    </div>
    
    <div class="entry-content row">
        <section class="col-md-12">
            <h3>Fiche identitaire</h3>
            <div class="row">
                <div class="col-md-12">
                    <p class="entry-title-2">Type de formation : <?php echo get_post_custom($post->ID)['_ecole_type_formation'][0] ?></p>
                    <p class="entry-title-2">Statut : <?php echo get_post_custom($post->ID)['_ecole_statut'][0] ?></p>
                    <p class="entry-title-2">Type de structure : <?php echo get_post_custom($post->ID)['_ecole_type_structure'][0] ?></p>
                    <p class="entry-title-2">Année de création : <?php echo get_post_custom($post->ID)['_ecole_annee_creation'][0] ?></p>
                    <p class="entry-title-2">Habilitation à délivrer le doctorat : <?php echo get_post_custom($post->ID)['_ecole_habilitation_delivrer_doctorat'][0] ?></p>
                    <p class="entry-title-2">Prépa intégrée : <?php echo get_post_custom($post->ID)['_ecole_prepa_integree'][0] ?></p> 
                    <p class="entry-title-2">Type d'habilitation : <?php echo get_post_custom($post->ID)['_ecole_type_habilitation'][0] ?></p>
                </div>
            </div>
        </section>

        <br>

        <section class="col-md-12">
            <h3>Contacts</h3>
            <div class="row">
                <div class="col-md-12">
                    <p class="entry-title-2">Directeur général : <?php echo get_post_custom($post->ID)['_ecole_dg_civilite'][0] ?> <?php echo get_post_custom($post->ID)['_ecole_dg_nom'][0] ?></p>
                    <p class="entry-title-2">Responsable des formations : <?php echo get_post_custom($post->ID)['_ecole_resp_formation'][0] ?></p>
                    <p class="entry-title-2">Adresse : <?php echo get_post_custom($post->ID)['geolocation_formatted_address'][0] ?></p>
                </div>
            </div>
        </section>
        <br>
        <br>
        <section class="col-md-12">
            <h3><?php echo $post->post_title ?></h3>
            <div class="row"><?php echo get_post_custom($post->ID)['_ecole_nom'][0] ?></div>
        </section>
        <br><br>
        <section class="col-md-12">
            <h3>Contacts</h3>
            <div class="row">
                <div class="col-md-6">
                    <p class="entry-title-2">Directeur général : <?php echo get_post_custom($post->ID)['_ecole_dg_civilite'][0] ?> <?php echo get_post_custom($post->ID)['_ecole_dg_nom'][0] ?></p>
                    <p class="entry-title-2">Responsable des formations : <?php echo get_post_custom($post->ID)['_ecole_resp_formation'][0] ?></p>
                    <p class="entry-title-2">Adresse : <?php echo get_post_custom($post->ID)['geolocation_formatted_address'][0] ?></p>
                </div>
                <div class="col-md-6">
                    <div id="map" style="height: 400px; width: 100% !important;"></div>
                </div>
            </div>
        </section>
    </div>
    
</div>
<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script>
    let mapLat = <?php echo get_post_custom($post->ID)['geolocation_lat'][0]?>;
    let mapLng = <?php echo get_post_custom($post->ID)['geolocation_long'][0]?>;
    let pictoColor = 'red';
    let mapDefaultZoom = 15;
    var map = L.map('map').setView([mapLat, mapLng], mapDefaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
                    const contentString =`
                        <div class="col"  style="width:400px !important;">
                            <center>
                            <img style="width: 100% !important;height: 200px;" title="<?php echo $post->post_title;?>" alt="<?php echo $post->post_title;?>" src="<?php echo get_post_custom($post->ID)['_ecole_logo'][0];?>" >
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