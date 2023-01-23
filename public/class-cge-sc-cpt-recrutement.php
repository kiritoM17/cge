<?php

class CGE_sc_recrutement{

    protected static $instance;

    public static function instance() {

        if (!self::$instance) {

            self::$instance = new self;
        }
        return self::$instance;

    }

    public function init(){
        add_shortcode('cge_recrutement', [$this,'cge_recrutement']);
    }

    public function cge_recrutement($atts) {
        function get_meta_values($meta_key = '', $post_type = 'cpt_recrutement', $post_status = 'publish') {
    
            global $wpdb;
            
            if( empty( $meta_key ) )
                return;
            
            $meta_values = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
                LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE pm.meta_key = %s 
                AND p.post_type = %s 
                AND p.post_status = %s 
            ", $meta_key, $post_type, $post_status ) );
            
            return $meta_values;
        }

        
        $taxonomy_lieu_emplois = get_meta_values('lieu_emplois');
        $taxonomy_demandeur_emplois = get_meta_values('demandeur_emplois');

        ob_start();
        require('partials/recrutement/listing/index.php');
        return ob_get_clean();
    }
    
}