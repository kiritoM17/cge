<div class="row col-md-12">
    <div class="widget-filtre widget-listingsearch layout1 ">
        <form class="form-inline search-form clearfix job_filters" style="display: flex;">
            <?php
            if (!is_tax('job_listing_region')) {
                $job_regions = get_terms(array('job_listing_region'), array('hierarchical' => 1));
                if (!is_wp_error($job_regions) && !empty($job_regions)) {

                    $selected_region = '';
                    //try to see if there is a search_categories (notice the plural form) GET param
                    $search_regions = isset($_REQUEST['job_region_select']) ? $_REQUEST['job_region_select'] : '';
                    if (!empty($search_regions) && is_array($search_regions)) {
                        $search_regions = $search_regions[0];
                    }
                    $search_regions = sanitize_text_field(stripslashes($search_regions));
                    if (!empty($search_regions)) {
                        if (is_numeric($search_regions)) {
                            $selected_region = intval($search_regions);
                        } else {
                            $term = get_term_by('slug', $search_regions, 'job_listing_region');
                            $selected_region = $term->term_id;
                        }
                    } elseif (!empty($regions) && isset($regions[0])) {
                        if (is_string($regions[0])) {
                            $term = get_term_by('slug', $regions[0], 'job_listing_region');
                            $selected_region = $term->term_id;
                        } else {
                            $selected_region = intval($regions[0]);
                        }
                    }
            ?>
                    <div class="form-group">
                        <select class="regions-select" data-placeholder="<?php esc_html_e('Filter by regions', 'louisiana'); ?>" id="job_region_select" name="job_region_select" style="width: 100%; max-width: 100%;">
                            <option value=""><?php esc_html_e('All regions', 'louisiana'); ?></option>
                            <?php foreach ($job_regions as $term) : ?>
                                <option value="<?php echo esc_attr($term->term_id); ?>" <?php echo ($term->term_id == $selected_region) ? 'selected="selected"' : ''; ?>><?php echo trim($term->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php if (!is_tax('job_listing_type')) {
                $job_regions = get_terms(array('job_listing_type'), array('hierarchical' => 1));
                if (!is_wp_error($job_regions) && !empty($job_regions)) {
                    $selected_region = '';
                    //try to see if there is a search_categories (notice the plural form) GET param
                    $search_regions = isset($_REQUEST['job_type_select']) ? $_REQUEST['job_type_select'] : '';
                    if (!empty($search_regions) && is_array($search_regions)) {
                        $search_regions = $search_regions[0];
                    }
                    $search_regions = sanitize_text_field(stripslashes($search_regions));
                    if (!empty($search_regions)) {
                        if (is_numeric($search_regions)) {
                            $selected_region = intval($search_regions);
                        } else {
                            $term = get_term_by('slug', $search_regions, 'job_listing_type');
                            $selected_region = $term->term_id;
                        }
                    } elseif (!empty($regions) && isset($regions[0])) {
                        if (is_string($regions[0])) {
                            $term = get_term_by('slug', $regions[0], 'job_listing_type');
                            $selected_region = $term->term_id;
                        } else {
                            $selected_region = intval($regions[0]);
                        }
                    }
            ?>
                    <div class="form-group form-group-lg">
                        <select class="type-select" data-placeholder="<?php esc_html_e('Filter by regions', 'louisiana'); ?>" id="job_type_select" name="job_type_select" style="width: 100%; max-width: 100%;">
                            <option value=""><?php esc_html_e('Types', 'louisiana'); ?></option>
                            <?php foreach ($job_regions as $term) : ?>
                                <option value="<?php echo esc_attr($term->term_id); ?>" <?php echo ($term->term_id == $selected_region) ? 'selected="selected"' : ''; ?>><?php echo trim($term->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php } ?>
            <?php } else {
                global $wp_query;
                $term =    $wp_query->queried_object;
            ?>
                <div class="form-group">
                    <input type="hidden" name="job_region_select" value="<?php echo esc_attr($term->term_id); ?>">
                </div>
            <?php } ?>

            <?php
            if (!is_tax('job_listing_amenity')) {
                $job_amenities = get_terms(array('job_listing_amenity'), array('hierarchical' => 1));
                if (!is_wp_error($job_amenities) && !empty($job_amenities)) {
                    $selected_region = '';
                    //try to see if there is a search_categories (notice the plural form) GET param
                    $search_regions = isset($_REQUEST['job_amenity_select']) ? $_REQUEST['job_amenity_select'] : '';
                    if (!empty($search_regions) && is_array($search_regions)) {
                        $search_regions = $search_regions[0];
                    }
                    $search_regions = sanitize_text_field(stripslashes($search_regions));
                    if (!empty($search_regions)) {
                        if (is_numeric($search_regions)) {
                            $selected_region = intval($search_regions);
                        } else {
                            $term = get_term_by('slug', $search_regions, 'job_listing_amenity');
                            $selected_region = $term->term_id;
                        }
                    } elseif (!empty($regions) && isset($regions[0])) {
                        if (is_string($regions[0])) {
                            $term = get_term_by('slug', $regions[0], 'job_listing_amenity');
                            $selected_region = $term->term_id;
                        } else {
                            $selected_region = intval($regions[0]);
                        }
                    }
            ?>
                    <div class="form-group">
                        <select class="type-select" data-placeholder="<?php esc_html_e('Filter by regions', 'louisiana'); ?>" id="job_amenity_select" name="job_amenity_select" style="width: 100%; max-width: 100%;">
                            <option value=""><?php esc_html_e('PAYS', 'louisiana'); ?></option>
                            <?php foreach ($job_amenities as $term) : ?>
                                <option value="<?php echo esc_attr($term->term_id); ?>" <?php echo ($term->term_id == $selected_region) ? 'selected="selected"' : ''; ?>><?php echo trim($term->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php } ?>
            <?php } else {
                global $wp_query;
                $term =    $wp_query->queried_object;
            ?>
                <div class="form-group">
                    <input type="hidden" name="job_amenities[]" value="<?php echo esc_attr($term->term_id); ?>">
                </div>
            <?php } ?>

            <div class="form-group">
                <input type="text" class="form-text search-field" name="job_search_keywords" id="job_search_keywords" placeholder="Mots clés" />
            </div>

            <div class="form-group">
                <label for="label4digital" style="display: flex;font-size: 13px;color: #fff;align-items: end;">
                    4DIGITAL
                    <input type="checkbox"  name="label4digital" id="label4digital" style="height: 25px;width: 25px; margin: 0 0 0 5px;"/>
                </label>
            </div>

            <?php do_action('job_manager_job_filters_search_jobs_end', $atts); ?>

        </form>
        <div class="row result-search">
            <span id="count_members_school"><?php echo count($wp_query->posts) ?> </span>&nbsp;écoles membres
        </div>
    </div>
</div>