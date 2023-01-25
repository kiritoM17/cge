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
        $type = isset($atts['id']) ? $atts['id'] : '';
        $args = array(
            'post_type' => 'job_listing',
            'posts_per_page' => -1,
            'ignore_sticky_posts' => true,
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
            $post_type_information_array = [];
            foreach ($wp_query->posts as $post) {
                $data = get_post_custom($post->ID);
                //die(var_dump($data['geolocation_long'][0], $data['geolocation_lat'][0]));
                $post_type_information_array[] = [
                    $post->post_title,
                    (float) $data['geolocation_lat'][0],
                    (float)$data['geolocation_long'][0],
                    $data['_ecole_logo'][0],
                    wp_trim_words($post->post_content, 20, '...'),
                    $post->ID,
                    $post->guid,
                    'red',
                    '',
                    '#000',
                    '#000',
                    '#fff'
                ];
            }
            ob_start();
            require('partials/job_listing/listing/index.php');
            return ob_get_clean();
        }
    }
}
