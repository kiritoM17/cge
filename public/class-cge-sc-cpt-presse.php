<?php
class CGE_SC_Cpt_Presse {

    protected static $instance;

    public static function instance() {

        if (!self::$instance) {

            self::$instance = new self;
        }
        return self::$instance;

    }

    public function init(){
        add_shortcode('cge_presse', [$this,'cge_presse']);
    }

    public function cge_presse($atts) {

        $taxonomy_type_documents = get_terms( 'type_document_presse' );
        $taxonomy_format = get_terms( 'document_format_presse' );
        $taxonomy_annees = get_terms( 'annee_presse',array('order'    => 'desc') );

        ob_start();
        require('partials/presse/listing/index.php');
        return ob_get_clean();
    }

}