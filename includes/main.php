<?php
namespace Deepak_Miusage_API_Integration\Includes;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/WPBoilerplate/deepak-miusage-api-integration
 * @since      1.0.0
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/includes
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
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/includes
 * @author     WPBoilerplate <contact@wpboilerplate.com>
 */
final class Main {
	
	/**
	 * The single instance of the class.
	 *
	 * @var Deepak_Miusage_API_Integration
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $rest_controller;

	/**
	 * The rest controller that's responsible for maintaining and registering all rest api endpoints.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Rest_Controller    $loader    Maintains and registers all hooks for the plugin.
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
	 * The plugin dir path
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_path    The string for plugin dir path
	 */
	protected $plugin_path;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Plugin directory path.
	 *
	 * @var string
	 */
	protected $plugin_dir;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'deepak-miusage-api-integration';

		$this->define_constants();

		if ( defined( 'DEEPAK_MIUSAGE_API_INTEGRATION_VERSION' ) ) {
			$this->version = DEEPAK_MIUSAGE_API_INTEGRATION_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->load_composer_dependencies();

		$this->load_dependencies();

		$this->set_locale();

		$this->load_hooks();

	}

	/**
	 * Main Deepak_Miusage_API_Integration Instance.
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Deepak_Miusage_API_Integration()
	 * @return Deepak_Miusage_API_Integration - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Define WCE Constants
	 */
	private function define_constants() {

		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_FILE', DEEPAK_MIUSAGE_API_INTEGRATION_FILES );
		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_BASENAME', plugin_basename( DEEPAK_MIUSAGE_API_INTEGRATION_FILES ) );
		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_PATH', plugin_dir_path( DEEPAK_MIUSAGE_API_INTEGRATION_FILES ) );
		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_URL', plugin_dir_url( DEEPAK_MIUSAGE_API_INTEGRATION_FILES ) );
		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_NAME_SLUG', $this->plugin_name );
		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_NAME', 'Deepak Miusage API Integration' );

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$plugin_data = get_plugin_data( DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_FILE );
		$version = $plugin_data['Version'];
		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_VERSION', $version );

		$this->define( 'DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_URL', $version );

		$this->plugin_dir = DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_PATH;
	}

	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Register all the hook once all the active plugins are loaded
	 *
	 * Uses the plugins_loaded to load all the hooks and filters
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function load_hooks() {

		/**
		 * Check if plugin can be loaded safely or not
		 * 
		 * @since    1.0.0
		 */
		if ( apply_filters( 'deepak-miusage-api-integration-load', true ) ) {
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}

	}

	/**
	 * Load the required composer dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_composer_dependencies() {

		/**
		 * Add composer file
		 */
		if ( file_exists( DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
			require_once( DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_PATH . 'vendor/autoload.php' );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Deepak_Miusage_API_Integration\Admin\Loader. Orchestrates the hooks of the plugin.
	 * - Deepak_Miusage_API_Integration\Admin\I18n. Defines internationalization functionality.
	 * - Deepak_Miusage_API_Integration\Admin\Main. Defines all hooks for the admin area.
	 * - Deepak_Miusage_API_Integration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = Loader::instance();

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			\WP_CLI::add_command( 'miusage', 'Deepak_Miusage_API_Integration\\Includes\\CLI_Command' );
		}

		/**
		 * Check if class exists or not
		 */
		if ( class_exists( '\WPBoilerplate_Register_Blocks' ) ) {
			new \WPBoilerplate_Register_Blocks( $this->plugin_dir );
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Deepak_Miusage_API_Integration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$i18n = new I18n();

		// Now attach it to `init`, not `plugins_loaded`
		$this->loader->add_action( 'init', $i18n, 'do_load_textdomain' );
	}


	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		
		$plugin_admin = new \Deepak_Miusage_API_Integration\Admin\Main( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		/**
		 * Add the Plugin Main Menu
		 */
		$main_menu = new \Deepak_Miusage_API_Integration\Admin\Partials\Menu( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $main_menu, 'main_menu' );
		$this->loader->add_action( 'plugin_action_links', $main_menu, 'plugin_action_links', 1000, 2 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new \Deepak_Miusage_API_Integration\Public\Main( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$rest_controller = new Rest_Controller();
		$this->loader->add_action( 'rest_api_init', $rest_controller, 'register_routes' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Deepak_Miusage_API_Integration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
