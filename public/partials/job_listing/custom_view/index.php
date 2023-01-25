<?php
global $post;
//var_dump(get_post_custom($post->ID),$post);die;
get_header();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">

    <div class="entry-content row">
        <h2 class="entry-title-2">PRESENTATION</h2> 
    </div>
    
    <div class="entry-content row">
        <div class="col-md-7">
            <div class="entry-content row">
               <h3> <b> Fiche identitaire </b> </h3>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Type de formation : <?php echo get_post_custom($post->ID)['_ecole_type_formation'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Statut : <?php echo get_post_custom($post->ID)['_ecole_statut'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Type de structure : <?php echo get_post_custom($post->ID)['_ecole_type_structure'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Année de création : <?php echo get_post_custom($post->ID)['_ecole_annee_creation'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Habilitation à délivrer le doctorat : <?php echo get_post_custom($post->ID)['_ecole_habilitation_delivrer_doctorat'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Prépa intégrée : <?php echo get_post_custom($post->ID)['_ecole_prepa_integree'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Type d'habilitation : <?php echo get_post_custom($post->ID)['_ecole_type_habilitation'][0] ?></h4>
            </div>

            <br>

            <div class="entry-content row">
               <h3><b> Contacts </b></h3>
            </div>
             <div class="entry-content row">
                <h4 class="entry-title-2">Directeur général : <?php echo get_post_custom($post->ID)['_ecole_dg_civilite'][0] ?> <?php echo get_post_custom($post->ID)['_ecole_dg_nom'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Responsable des formations : <?php echo get_post_custom($post->ID)['_ecole_resp_formation'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Adresse : <?php echo get_post_custom($post->ID)['geolocation_formatted_address'][0] ?></h4>
            </div>

            <br>
            <br>
            <br>
            
            <div class="entry-content row">
               <h3> <b>  <?php echo $post->post_title ?> </b> </h3>
            </div>
            <div class="entry-content row">
               <h5> <?php echo get_post_custom($post->ID)['_ecole_nom'][0] ?> </h5>
            </div>

            <br>

            <div class="entry-content row">
               <h3><b> Contacts </b></h3>
            </div>
             <div class="entry-content row">
                <h4 class="entry-title-2">Directeur général : <?php echo get_post_custom($post->ID)['_ecole_dg_civilite'][0] ?> <?php echo get_post_custom($post->ID)['_ecole_dg_nom'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Responsable des formations : <?php echo get_post_custom($post->ID)['_ecole_resp_formation'][0] ?></h4>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Adresse : <?php echo get_post_custom($post->ID)['geolocation_formatted_address'][0] ?></h4>
            </div>
        </div>

        <div class="col-md-3">
            <!-- map -->
        </div>
    </div>
    
</div>
<?php get_footer(); ?>