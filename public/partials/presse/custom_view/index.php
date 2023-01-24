<?php
global $post;
get_header();

?>
<div class="container">
    <div class="entry-content row">
        <h4 class="entry-title-2"><?php echo $post->post_title ?></h4>
    </div>
    <div class="entry-content row">
        <iframe src="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0] ?>" title="description" width="1200" height="700"></iframe>
    </div>
    <div class="entry-content row">
        <a href="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0] ?>" target="_blank">
            <i class="fa fa-download"></i>
            Télécharger le document
        </a>
    </div>
</div>

<?php get_footer(); ?>