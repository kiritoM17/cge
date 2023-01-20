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
    add_shortcode('presse', [$this,'gce_presse']);
}

public function gce_presse($atts) {
    global $post;

    $tags = get_tags(array('post_type' => 'cpt_presse'));

    $taxonomy_type_documents = get_terms( 'type_document_presse' );
    $taxonomy_format = get_terms( 'document_format_presse' );
    $taxonomy_annees = get_terms( 'annee_presse',array('order'    => 'desc') );


    $args = array(
        'post_type'=>  array('cpt_presse','revue_de_presse'),
        'order'    => 'DESC',
        'posts_per_page' => -1
    ); 

    if (isset($atts['id']) && !empty($atts['id'])) {
        $args['ID'] = (int)$atts['id'];
    } else {
        ob_start();
        require('partials/presse/listing/index.php');
        return ob_get_clean();
    }
}

}