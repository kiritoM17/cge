<?php
global $post;
get_header();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
    <div class="entry-content row">
        <h2 class="entry-title-2" style="padding: 0 0 5px 5px;border-left: #000 3px solid;"><?php echo $post->post_title ?></h2>
    </div>
    <div class="entry-content row">
        <a href="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0] ?>"><h- class="entry-title-2">Mode plein écran</h6></a>
    </div>
    <div class="entry-content row">
        <iframe src="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0] ?>" title="description" width="1500" height="900"></iframe>
    </div>
    <div class="entry-content row">
        <a href="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0] ?>" target="_blank">
            <i class="fa fa-download"></i>
            Télécharger le document
        </a>
    </div>
</div>

<?php get_footer(); ?>