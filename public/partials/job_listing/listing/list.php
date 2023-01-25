<div class="row col-md-12" style="max-height: 670px;overflow-y: scroll;">
    <?php
        foreach($wp_query->posts as $post)
        {
            $terms = get_the_terms($post->ID, 'job_listing_category');
            $termString = '';
            $data_output = '';
            if (!is_wp_error($terms) && (is_array($terms) || is_object($terms))) {
                $firstTerm = $terms[0];
                if (!$firstTerm == null) {
                    $term_id = $firstTerm->term_id;
                    $data_output .= ' data-icon="' . apustheme_get_term_icon_url($term_id) . '"';
                    $count = 1;
                    foreach ($terms as $term) {
                        $termString .= $term->name;
                        if ($count != count($terms)) {
                            $termString .= ', ';
                        }
                        $count++;
                    }
                }
            }
            $ecole_type_formation = get_post_meta($post->ID, '_ecole_type_formation', true);
            $ecole_annee_creation = get_post_meta($post->ID, '_ecole_annee_creation', true);
            $ecole_statut = get_post_meta($post->ID, '_ecole_statut', true);
            //$total_rating = apustheme_get_total_rating($post->ID);?>

            <div class="row-content">
                <div class="logo-ecole">
                    <div class="grid-style1" itemscope itemtype="http://schema.org/LocalBusiness" data-longitude="<?php echo isset(get_post_meta($post->ID, "geolocation_long")[0])? get_post_meta($post->ID, "geolocation_long")[0] : ""; ?>" data-latitude="<?php echo isset(get_post_meta($post->ID, "geolocation_lat")[0])?get_post_meta($post->ID, "geolocation_lat")[0]:""; ?>" data-img="<?php echo isset(get_post_meta($post->ID, "_ecole_logo")[0])? get_post_meta($post->ID, "_ecole_logo")[0]: ""; ?>" data-permalink="<?php esc_attr(get_permalink($post->ID)); ?>" data-categories="<?php echo esc_attr($termString); ?>" <?php echo trim($data_output); ?>>

                        <div class="listing-image">
                            <div class="image-wrapper">
                                <a href="<?php get_permalink($post->ID); ?>">
                                    <img src="<?php echo isset(get_post_meta($post->ID, "_ecole_logo")[0])? get_post_meta($post->ID, "_ecole_logo")[0]: ""; ?>" data-src="<?php echo isset(get_post_meta($post->ID, "_ecole_logo")[0])? get_post_meta($post->ID, "_ecole_logo")[0]: ""; ?>" alt="" class="unveil-image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-ecole">
                    <div class="listing-title-wrapper">
                        <h3 class="listing-title">
                            <a href="<?php get_permalink($post->ID); ?>"><?= $post->post_title ?></a>
                        </h3>
                        <?php echo substr(strip_tags($post->post_content), 0, 100); ?>

                        <ul>
                            <?php echo "<li>" . $ecole_annee_creation . "</li>", "<li>" . $ecole_statut . "</li>", "<li>" . $ecole_type_formation . "</li>"; ?>
                        </ul>


                    </div>
                </div>
            </div>

        <?php }?>

</div>