
<?php

class CGE_sc_msalumni{

    protected static $instance;

    public static function instance() {

        if (!self::$instance) {

            self::$instance = new self;
        }
        return self::$instance;

    }

    public function init(){
        add_shortcode('gce_msalumni', [$this,'gce_msalumni']);
    }

    public function gce_msalumni($atts) {
        $args = array(
            'post_type' => 'msalumni',
            'orderby' => 'title',
            'order' => 'DESC',
            'posts_per_page' => -1
        );
        //var_dump($taxonomy_documents,get_posts($args));die;
        if (isset($atts['id']) && !empty($atts['id'])) {
            $args['ID'] = (int)$atts['id'];
        } else {
            $categories = get_categories(array('post_type' => 'msalumni'));
            ob_start();
            require('partials/msalumni/listing/index.php');
            return ob_get_clean();
        }
    }
    
}