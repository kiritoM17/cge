<div style=" margin: 0; padding: 0; width: 100%;max-width: 100%;" class="container">
    <div class="entry-content row">
        <h2 class="entry-title-2">Les <?php echo $type?></h2> 
    </div>
    <div class="row">
        <?php foreach ($myposts as $post) {
             ?>
            <div class="col-sm-3">
                <div class="row">
                    <a href="<?php echo get_post_custom($post->ID)['_cge_membre_url'][0] ?>" target="_blank">
                        <img width="200" height="93" src="<?php echo get_the_post_thumbnail_url($post->ID) ?>"/>
                    </a>
                </div>
                <div class="row" style="text-align: center;">
                    <p style="text-align: center;">
                        <a href="<?php echo get_post_custom($post->ID)['_cge_membre_url'][0] ?>" target="_blank"><?php echo $post->post_title ?></a>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>