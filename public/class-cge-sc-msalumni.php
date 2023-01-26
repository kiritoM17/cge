
<?php

class CGE_SC_Msalumni
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
        add_shortcode('cge_student', [$this, 'cge_msalumni']);
    }

    public function cge_msalumni($atts)
    {
        $taxonomy_ecoles = $this->getMetaValues('ecole');
        $taxonomy_annees = $this->getMetaValues('annee_obtention');

        ob_start();
        require('partials/msalumni/listing/index.php');
        return ob_get_clean();
    }


    function getMetaValues($meta_key = '', $post_type = 'msalumni', $post_status = 'publish')
    {

        global $wpdb;

        if (empty($meta_key))
            return;
        $meta_values = $wpdb->get_col($wpdb->prepare("
                SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
                LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE pm.meta_key = %s 
                AND p.post_type = %s 
                AND p.post_status = %s 
            ", $meta_key, $post_type, $post_status));
        return $meta_values;
    }
}
