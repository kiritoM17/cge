<?php

?>
<div class="row">
    <?php foreach ($myposts as $post) { ?>
        <?php
        $type = get_the_terms($post->ID, 'formation_type');
        $logo = "";
        if ($type[0]->name == "MS") {
            $logo = "logo-ms.png";
        } else if ($type[0]->name == "MSc") {
            $logo = "logo-msc.png";
        } else if ($type[0]->name == "BADGE") {
            $logo = "logo-badge.png";
        } else if ($type[0]->name == "CQC") {
            $logo = "logo-cqc.png";
        }
        //die(var_dump(get_post_meta($post->ID, "_formation_website")[0]));
        ?>

        <div class="col-md-12 col-msalumni">
            <article class="post post-grid type-post format-standard format-msalumni">
                <div class="entry-content row">
                    <a href="<?php echo get_post_meta($post->ID, "_formation_website")[0]; ?>" target="_blanc">
                        <div class="col-md-4">
                            <?php if (!empty($logo)) : ?>
                                <div class="vc_logo-wrapper"><img src="<?php echo CGE_PUBLIC_IMG . 'formation_type/' . $logo ?>" /></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <h4 class="entry-title-2">
                                <?php $post->title; ?>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <span class="date"><?php if (get_post_meta($post->ID, "_formation_ecole_nom")[0] != "") {
                                                    echo get_post_meta($post->ID, "_formation_ecole_nom")[0];
                                                } ?></span>
                            <span class="date"><?php if (get_post_meta($post->ID, "_formation_co_accrediteurs")[0] && sizeof(get_post_meta($post->ID, "_formation_co_accrediteurs")[0]) > 0) {
                                                    echo "Co-accréditation : <br />";
                                                    foreach (get_post_meta($post->ID, "_formation_co_accrediteurs")[0] as $c) {
                                                        echo $c . '<br />';
                                                    }
                                                } ?></span>
                        </div>
                    </a>

                </div>
            </article>
        </div>
    <?php } ?>
</div>