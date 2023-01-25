<?php
global $post;
var_dump(get_post_custom($post->ID),$post);die;
get_header();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">

    <div class="entry-content row">
        <h2 class="entry-title-2">PRESENTATION</h2>  
    </div>
    
    <div class="entry-content row">
        <div class="entry-content col-7">
            <div class="entry-content row">
                <h2 class="entry-title-2"><?php echo $post->post_title ?></h2>
            </div>
            <div class="entry-content row">
                <h4 class="entry-title-2">Demandeur <?php echo get_post_custom($post->ID)['demandeur_emplois'][0] ?></h4>
            </div>
        </div>

        <div class="entry-content col-3">
            <!-- map -->
        </div>
    </div>
    
</div>
<?php get_footer(); ?>