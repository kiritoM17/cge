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

        ob_start();
        require('partials/publication/listing/index.php');
        return ob_get_clean();
    }

}