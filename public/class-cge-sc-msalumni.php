
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
        add_shortcode('cge_msalumni', [$this,'cge_msalumni']);
    }

    public function cge_msalumni($atts) {
        ob_start();
        require('partials/msalumni/listing/index.php');
        return ob_get_clean();
    }
    
}