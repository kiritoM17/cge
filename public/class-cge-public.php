<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://http://gdt-core.com
 * @since      1.0.0
 *
 * @package    Cge
 * @subpackage Cge/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cge
 * @subpackage Cge/public
 * @author     cge <contact@gdt-core.com>
 */
require plugin_dir_path(dirname(__FILE__)) . 'public/class-cge-sc-job-listing.php';
require plugin_dir_path(dirname(__FILE__)) . 'public/class-cge-sc-cpt-formation.php';
require plugin_dir_path(dirname(__FILE__)) . 'public/class-cge-sc-msalumni.php';
class Cge_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function init()
	{
		CGE_SC_Job_Listing::instance()->init();
		CGE_SC_Cpt_Formation::instance()->init();
		CGE_sc_msalumni::instance()->init();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style('cge-bootstrapp', plugin_dir_url(__FILE__) . 'css/bootstrap.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cge-public.css', array('cge-bootstrapp'), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cge-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script('sc-formation', plugin_dir_url(__FILE__) . 'js/cge-sc-formation.js', array('jquery', $this->plugin_name), $this->version, false);
		wp_enqueue_script('sc-msalumni', plugin_dir_url(__FILE__) . 'js/cge-sc-msalumni.js', array('jquery', $this->plugin_name), $this->version, false);

		wp_localize_script($this->plugin_name, 'CGE_PUBLIC_IMG', CGE_PUBLIC_IMG);
	}
}
