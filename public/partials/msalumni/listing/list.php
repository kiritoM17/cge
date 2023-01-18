
<div class="row" id="cge_entry_msalumni" >
    <?php foreach ($myposts as $post) { ?>
        
       <!-- <div class="col-md-12 col-msalumni">
            <article class="post post-grid type-post format-standard format-msalumni">
                <div class="entry-content row">
                    <div class="col-md-3">
                       <h4 class="entry-title-2">
                            <?php echo $post->post_title; ?>
                        </h4>
                    </div>
                    <div class="col-md-3">
                        <span class="date"><?php if (get_post_meta($post->ID, "ecole")[0] != "") {
                                                        echo get_post_meta($post->ID, "ecole")[0];
                                                    } ?></span>
                    </div>
                    <div class="col-md-3">
                        <span class="date"><?php if (get_post_meta($post->ID, "annee_obtention")[0] != "") {
                                                        echo get_post_meta($post->ID, "annee_obtention")[0];
                                                    } ?></span>
                    </div>
                    <div class="col-md-3">
                        <span class="date"><?php if (get_post_meta($post->ID, "formation")[0] != "") {
                                                        echo get_post_meta($post->ID, "formation")[0];
                                                    } ?></span>
                    </div>
                </div>
            </article>
        </div> -->
        
    <?php } ?>