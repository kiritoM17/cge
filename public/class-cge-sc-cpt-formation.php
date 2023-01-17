<?php

class CGE_SC_Cpt_Formation
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
        add_shortcode('formation', [$this, 'formation']);
    }

    public function formation($atts)
    {
        global $post;
        $taxonomy_documents = get_terms('formation_type');
        $taxonomy_ecoles = get_terms('formation_ecole');
        $formations_domaines = get_terms('formations_domaines');
        $formations_themes = get_terms('formations_themes');
        $args = array(
            'post_type' => 'cpt_formation',
            'order' => 'DESC',
            'posts_per_page' => -1
        );
        if (isset($atts['id']) && !empty($atts['id'])) {
            $args['ID'] = (int)$atts['id'];
        } else {
            $myposts = get_posts($args);
            $categories = get_categories(array('post_type' => 'cpt_formation'));
            ob_start();
            require('partials/formation/listing/index.php');
            return ob_get_clean();
        }
    }
}
