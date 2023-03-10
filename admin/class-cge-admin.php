<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://http://gdt-core.com
 * @since      1.0.0
 *
 * @package    Cge
 * @subpackage Cge/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cge
 * @subpackage Cge/admin
 * @author     cge <contact@gdt-core.com>
 */

//API_CGE
require plugin_dir_path(dirname(__FILE__)) . 'includes/class-cge-api.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-cpt-formation.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-msalumni.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-job-listing.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-cpt-recrutement.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-cpt-presse.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-cpt-publication.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-cpt-actualite.php';
require plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-post-cpt-membre.php';
class Cge_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function init()
	{
		CGE_Cpt_Formation::instance()->init();
		CGE_Msalumni::instance()->init();
		CGE_Job_Listing::instance()->init();
		CGE_CPT_MEMBRE::instance()->init();
		CGE_Cpt_Recrutement::instance()->init();
		CGE_Cpt_Publication::instance()->init();
		CGE_Cpt_Presse::instance()->init();
	}

	public function add_meta_boxes()
	{
		CGE_Cpt_Formation::instance()->add_meta_boxes();
		CGE_Msalumni::instance()->add_meta_boxes();
		CGE_Job_Listing::instance()->add_meta_boxes();
		CGE_CPT_MEMBRE::instance()->add_meta_boxes();
		CGE_Cpt_Recrutement::instance()->add_meta_boxes();
		CGE_Cpt_Publication::instance()->add_meta_boxes();
		CGE_Cpt_Presse::instance()->add_meta_boxes();
	}

	public function save_post($post_id)
	{
		CGE_CPT_MEMBRE::instance()->save_meta($post_id);
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cge-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cge-admin.js', array('jquery'), $this->version, false);
		wp_enqueue_script('js-job-listing', plugin_dir_url(__FILE__) . 'js/cge-admin-job-listing.js', array('jquery'), $this->version, false);
	}


	public function cge_admin_menu()
	{

		add_menu_page('CGE', 'CGE MANAGER', 'manage_options', 'cge-admin-menu', [$this, 'cge_admin_init'], 'dashicons-tickets', 5);

	}

	public function cge_admin_init()
	{
		include_once('partials/cge-admin-display.php');
	}

	public function et_register_options()
	{
		if (isset($_POST['cge-password']) && isset($_POST['cge-username'])) {
			$api = new API_CGE(2);
			$username = $_POST['cge-username'];
			$password = $_POST['cge-password'];
			$request_response = $api->getAccessToken($username, $password);
			if ($request_response) {
				if (get_option("_CGE_CLIENT_USERNAME"))
					update_option("_CGE_CLIENT_USERNAME", $username);
				else
					add_option("_CGE_CLIENT_USERNAME", $username);

				if (get_option("_CGE_CLIENT_PWD"))
					update_option("_CGE_CLIENT_PWD", $password);
				else
					add_option("_CGE_CLIENT_PWD", $password);
				$request_response = "";
			} else {
				$request_response = "userename or password are not valid";
			}

			wp_safe_redirect(
				// Sanitize.
				esc_url(
					// Retrieves the site url for the current site.
					site_url("wp-admin/?page=cge-admin-menu&cge_menu=settings")
				)
			);
		}
	}
}
