<?php

class CGE_SC_Cpt_Membre
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
        add_shortcode('cge_membre', [$this, 'cge_membre']);
    }

    public function cge_membre($atts)
    {
        $args = array(
            'post_type' => 'cge_membre',
            'posts_per_page' => -1,
            'ignore_sticky_posts' => true,
        );

        if (isset($atts['type']) && !empty($atts['type'])) {
            switch ((string)$atts['type']) {
                case 'entreprise':
                    $tax_query[] = array(
                        'key' => '_cge_membre_type',
                        'value' => 'entreprise',
                        'compare' => '=',
                    );
                    break;
                case 'organisme':
                    $tax_query[] = array(
                        'key' => '_cge_membre_type',
                        'value' => 'organisme',
                        'compare' => '=',
                    );
                    break;
                default:
                    break;
            }
            if (in_array((string)$atts['type'], ['entreprise', 'organisme']))
                $args['meta_query'] = $tax_query;
        }
        $myposts = get_posts($args);
        $type = get_post_custom($myposts[0]->ID)["_cge_membre_type"][0];
        ob_start();
        require('partials/membre/listing/index.php');
        return ob_get_clean();
    }
}
