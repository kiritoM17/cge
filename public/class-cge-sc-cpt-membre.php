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
            'order' => 'DESC',
            'posts_per_page' => -1
        );
        if (isset($atts['id']) && !empty($atts['id'])) {
            $args['ID'] = (int)$atts['id'];
        } else {
            $myposts = get_posts($args);
            ob_start();
            require('partials/membre/listing/index.php');
            return ob_get_clean();
        }
    }
}
