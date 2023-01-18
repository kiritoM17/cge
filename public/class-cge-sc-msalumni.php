
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
       // add_action( 'wp_enqueue_scripts',[$this, 'enqueue_styles'] );
		//add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
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
            $myposts = get_posts($args);
            $categories = get_categories(array('post_type' => 'msalumni'));
            ob_start();
            require('partials/msalumni/listing/index.php');
            return ob_get_clean();
        }
    }
    
    public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Baba_crypto_sc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Baba_crypto_sc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'public-css', plugin_dir_url( __FILE__ ) . 'css/public.css', array(), 1, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Baba_crypto_sc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Baba_crypto_sc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'public-js', plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), 1.0, false );

	}
}