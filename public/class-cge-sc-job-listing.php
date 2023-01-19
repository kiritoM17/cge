<?php

class CGE_SC_Job_Listing
{
    protected static $instance;
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function init()
    {
        add_shortcode('cge_job_listing', [$this, 'job_listing']);
    }

    public function job_listing($atts)
    {
        $prefix = '_lp_';
        $args = array(
            'post_type' => 'job_listing',
            //'posts_per_page' => $post_per_page,
            'ignore_sticky_posts' => true,
            //'paged' => $paged
        );

        if ($type == 'popular') {
            $args['meta_key'] = '_listing_views_count';
            $args['order'] = 'DESC';
        } elseif ($type == 'featured') {
            $args['meta_query'] =  array(
                array(
                    'key' => '_featured',
                    'value' => '1',
                    'compare' => '=',
                )
            );
        }
        if (isset($atts['id']) && !empty($atts['id'])) {
        } else {
            $wp_query = new WP_Query($args);
            ob_start();
            require('partials/job_listing/listing/index.php');
            return ob_get_clean();
        }
    }
}
