<?php
namespace Deepak_Miusage_API_Integration\Public;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/WPBoilerplate/deepak-miusage-api-integration
 * @since      1.0.0
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/public
 * @author     WPBoilerplate <contact@wpboilerplate.com>
 */
class Main {

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
	 * The js_asset_file of the frontend
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $js_asset_file;

	/**
	 * The css_asset_file of the frontend
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $css_asset_file;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->js_asset_file	= include( DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_PATH . 'build/js/frontend.asset.php' );
		$this->css_asset_file	= include( DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_PATH . 'build/css/frontend.asset.php' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Deepak_Miusage_API_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Deepak_Miusage_API_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_URL . 'build/css/frontend.css', $this->css_asset_file['dependencies'], $this->css_asset_file['version'], 'all' );

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
		 * defined in Deepak_Miusage_API_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Deepak_Miusage_API_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_URL . 'build/js/frontend.js', $this->js_asset_file['dependencies'], $this->js_asset_file['version'], false );

	}

}
