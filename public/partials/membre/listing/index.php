<div style=" margin: 0; padding: 0; width: 100%;max-width: 100%;" class="container">
    <section>
        <h2 class="title">Les membres <?php echo $type == 'organisme' ? ' Organisations' : ($type == 'entreprise' ? ' Entreprises' : '') ?></h2>
        <div class="row">
            <?php foreach ($myposts as $post) { ?>
                <div class="col-md-4 col-sm-6 col-xs-12" style="margin: 5px 0 10px 0;">
                    <a href="#" style="display: flex;flex-direction: column;align-items: center;justify-content: center; text-decoration: none !important;" class="member-block">
                        <img src="<?php echo get_post_custom($post->ID)['_cge_membre_image'][0] ?>" class="member-img" style="height: 200px;width: auto;object-fit: contain;" />
                        <p><span href="<?php echo get_post_custom($post->ID)['_cge_membre_url'][0] ?>" target="_blank" class="member-title" style="text-decoration:none;"><?php echo $post->post_title ?></span></p>
                        <?php if ($type == 'organisme') { ?>
                            <p><strong><?php
                                        switch (get_post_custom($post->ID)['_cge_membre_organisme'][0]) {
                                            case 'association_professeur':
                                                echo 'association de professeurs';
                                                break;
                                            case 'association_alumni':
                                                echo 'Association d\'Alumni';
                                                break;
                                            case 'association_autre':
                                                echo 'Autres organismes membres';
                                                break;
                                            default:
                                                break;
                                        }
                                        ?></p>
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
</div>