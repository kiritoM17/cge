<div style=" margin: 0; padding: 0; width: 100%;max-width: 100%;" class="container">
    <section>
        <h2 class="title">Les membres <?php echo $type == 'organisme' ? ' Organisations' : ($type == 'entreprise' ? ' Entreprises' : '') ?></h2>
        <div class="row">
            <?php foreach ($myposts as $post) { ?>
                <div class="col-md-4 col-sm-6 col-xs-12" style="margin: 5px 0 10px 0;">
                    <a href="#" style="display: flex;flex-direction: column;align-items: center;justify-content: center;" class="member-block">
                        <img src="<?php echo get_post_custom($post->ID)['_cge_membre_image'][0] ?>" class="member-img" style="height: 200px;width: auto;object-fit: contain;" />
                        <span href="<?php echo get_post_custom($post->ID)['_cge_membre_url'][0] ?>" target="_blank" class="member-title" style="text-decoration:none;"><?php echo $post->post_title ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
</div>