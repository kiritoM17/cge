<?php
global $post;
get_header();

?>
<div style="margin: 0; padding: 0; width: 100%;max-width: 100%;" class = "container" >
    <article class="post post-grid type-post format-standard format-msalumni">
        <div class="entry-content row">
            <div class="col-md-3">
                <h4 class="entry-title-2"><?php echo $post->post_title ?></h4> 
            </div>
        </div>
        <div class="entry-content row">
            <div class="col-md-3">
                <iframe src="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0]?>" title="description" style="width: 800px; height: 450px;"></iframe>
            </div>
        </div>
        <div class="entry-content row">
            <div class="col-md-3">
                <div class="single-info info-bottom info-padding">
                    <a href="<?php echo get_post_custom($post->ID)['_cge_presse_url'][0]?>" target="_blank">
                        <i class="fa fa-download"></i>
                        Télécharger le document
                    </a>
                </div>
            </div>
        </div>
    </article>
</div>

<?php get_footer(); ?>

