<?php
global $post;
//var_dump(get_post_custom($post->ID));die;
get_header();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
    <div class="entry-content row">
        <h2 class="entry-title-2"><?php echo $post->post_title ?></h2>
    </div>
    <div class="entry-content row">
        <h4 class="entry-title-2">Demandeur <?php echo get_post_custom($post->ID)['demandeur_emplois'][0] ?></h4>
    </div>
    <div class="entry-content row">
        <h4 class="entry-title-2">Poste proposé <?php echo get_post_custom($post->ID)['poste_propose_emplois'][0] ?></h4>
    </div>
    <div class="entry-content row">
        <h4 class="entry-title-2">Lieu <?php echo get_post_custom($post->ID)['lieu_emplois'][0] ?></h4>
    </div>
    <div class="entry-content row">
        <h4 class="entry-title-2">Date de prise de poste : <?php echo date("d-m-Y", strtotime(get_post_custom($post->ID)['date_debut_emplois'][0]));  ?></h4>
    </div>
    <div class="entry-content row">
        <h6 class="entry-title-2"> Date de dépôt de l’offre : <?php echo date("d-m-Y", strtotime(get_post_custom($post->ID)['date_depot_emplois'][0])); ?></h6>
    </div>
    <div class="entry-content row">
        <h2 class="entry-title-2"><?php echo $post->post_content ?></h2>
    </div>
    <div class="entry-content row">
        <iframe src="<?php echo get_post_custom($post->ID)['document_emplois'][0] ?>" title="description" width="1200" height="700"></iframe>
    </div>
    <div class="entry-content row">
        <a href="<?php echo get_post_custom($post->ID)['document_emplois'][0] ?>" target="_blank">
            <i class="fa fa-download"></i>
            Télécharger le document
        </a>
    </div>
</div>

<?php get_footer(); ?>