<?php
class CGE_SC_Cpt_Publication{

    protected static $instance;

    public static function instance() {

        if (!self::$instance) {

            self::$instance = new self;
        }
        return self::$instance;

    }

    public function init(){
        add_shortcode('cge_publication', [$this,'gce_cpt_publication']);
    }

    public function gce_cpt_publication($atts) {
        $taxonomy_documents = get_terms( 'document_type' );
        $taxonomy_annees = get_terms( 'document_annee_publication',array('order'    => 'desc') );
        $taxonomy_sources = get_terms( 'sources' );
        $taxonomy_type_spe = get_terms( 'type_document_spe' );
        function post_type_tags( $post_type = '' ) {
            global $wpdb;
        
            if ( empty( $post_type ) ) {
                $post_type = get_post_type();
            }
        
            return $wpdb->get_results( $wpdb->prepare( "
                SELECT COUNT( DISTINCT tr.object_id ) 
                    AS count, tt.taxonomy, tt.description, tt.term_taxonomy_id, t.name, t.slug, t.term_id 
                FROM {$wpdb->posts} p 
                INNER JOIN {$wpdb->term_relationships} tr 
                    ON p.ID=tr.object_id 
                INNER JOIN {$wpdb->term_taxonomy} tt 
                    ON tt.term_taxonomy_id=tr.term_taxonomy_id 
                INNER JOIN {$wpdb->terms} t 
                    ON t.term_id=tt.term_taxonomy_id 
                WHERE p.post_type=%s 
                    AND tt.taxonomy='post_tag' 
                GROUP BY tt.term_taxonomy_id 
                ORDER BY count DESC
            ", $post_type ) );
        }
        
        $archive_tags = post_type_tags( 'cpt_publication' );

        $args = array(
            'post_type' => 'cpt_publication',
            'order'    => 'DESC',
            'posts_per_page' => -1
        );

        if (isset($atts['id']) && !empty($atts['id'])) {
            $args['ID'] = (int)$atts['id'];
        } else {
            $categories = get_categories(array('post_type' => 'cpt_publication'));
            ob_start();
            require('partials/publication/listing/index.php');
            return ob_get_clean();
        }
    }

}