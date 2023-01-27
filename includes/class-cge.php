<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://http://gdt-core.com
 * @since      1.0.0
 *
 * @package    Cge
 * @subpackage Cge/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cge
 * @subpackage Cge/includes
 * @author     cge <contact@gdt-core.com>
 */
class Cge
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cge_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('CGE_VERSION')) {
			$this->version = CGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		if (!defined('CGE_ADMIN_VIEWS')) {
			define('CGE_ADMIN_VIEWS', dirname(__FILE__, 2) . '/admin/views/');
		}

		if (!defined('CGE_ADMIN_CRONS')) {
			define('CGE_ADMIN_CRONS', dirname(__FILE__, 2) . '/admin/crons/');
		}

		if (!defined('CGE_ADMIN_CRONS_URL')) {
			define('CGE_ADMIN_CRONS_URL', plugins_url('cge/admin/crons/', dirname(__FILE__, 2)));
		}

		if (!defined('CGE_ADMIN_METABOX')) {
			define('CGE_ADMIN_METABOX', dirname(__FILE__, 2) . '/admin/partials/metabox/');
		}

		if (!defined('CGE_PUBLIC_PARTIALS')) {
			define('CGE_PUBLIC_PARTIALS', dirname(__FILE__, 2) . '/public/partials/');
		}

		if (!defined('CGE_ADMIN_IMG')) {
			define('CGE_ADMIN_IMG', plugins_url('admin/img/', dirname(__FILE__, 2)));
		}

		if (!defined('CGE_PUBLIC_IMG')) {
			define('CGE_PUBLIC_IMG', plugins_url('cge/public/img/', dirname(__FILE__, 2)));
		}

		if (!defined('CGE_ADMIN_JS')) {
			define('CGE_ADMIN_JS', plugins_url('cge/admin/js/', dirname(__FILE__, 2)));
		}

		if (!defined('CGE_ADMIN_CSS')) {
			define('CGE_ADMIN_CSS', plugins_url('cge/admin/js/', dirname(__FILE__, 2)));
		}

		$this->plugin_name = 'cge';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cge_Loader. Orchestrates the hooks of the plugin.
	 * - Cge_i18n. Defines internationalization functionality.
	 * - Cge_Admin. Defines all hooks for the admin area.
	 * - Cge_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cge-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cge-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cge-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-cge-public.php';

		$this->loader = new Cge_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Cge_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Cge_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Cge_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('init', $plugin_admin, 'init', 0);
		$this->loader->add_action('admin_init', $plugin_admin, 'et_register_options');
		$this->loader->add_action('admin_menu', $plugin_admin, 'cge_admin_menu');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'add_meta_boxes');
		$this->loader->add_action('save_post', $plugin_admin, 'save_post');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_filter('manage_edit-' . CGE_Job_Listing::POSTTYPE . '_columns', CGE_Job_Listing::instance(), 'add_form_custom_column');
		$this->loader->add_filter('manage_' . CGE_Job_Listing::POSTTYPE . '_posts_custom_column', CGE_Job_Listing::instance(), 'manage_form_custom_column', 10, 2);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Cge_Public($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('init', $plugin_public, 'init', 0);
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		$this->loader->add_filter('single_template', $plugin_public, 'get_product_sheet_template');

		$this->loader->add_action('wp_ajax_find_formation', CGE_Cpt_Formation::instance(), 'find_formation');
		$this->loader->add_action('wp_ajax_nopriv_find_formation', CGE_Cpt_Formation::instance(), 'find_formation');
		$this->loader->add_action('wp_ajax_find_publication', CGE_Cpt_Publication::instance(), 'find_publication');
		$this->loader->add_action('wp_ajax_nopriv_find_publication', CGE_Cpt_Publication::instance(), 'find_publication');
		$this->loader->add_action('wp_ajax_find_msalumini', CGE_Msalumni::instance(), 'find_msalumini');
		$this->loader->add_action('wp_ajax_nopriv_find_msalumini', CGE_Msalumni::instance(), 'find_msalumini');
		$this->loader->add_action('wp_ajax_find_presse', CGE_Cpt_Presse::instance(), 'find_presse');
		$this->loader->add_action('wp_ajax_nopriv_find_presse', CGE_Cpt_Presse::instance(), 'find_presse');
		$this->loader->add_action('wp_ajax_find_recrutement', CGE_Cpt_Recrutement::instance(), 'find_recrutement');
		$this->loader->add_action('wp_ajax_nopriv_find_recrutement', CGE_Cpt_Recrutement::instance(), 'find_recrutement');
		$this->loader->add_action('wp_ajax_find_job_listing', CGE_Job_Listing::instance(), 'find_job_listing');
		$this->loader->add_action('wp_ajax_nopriv_find_job_listing', CGE_Job_Listing::instance(), 'find_job_listing');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cge_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
