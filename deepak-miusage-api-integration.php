<?php
/**
 * Instantiates the Deepak Miusage API Integration plugin
 *
 * @package Deepak_Miusage_API_Integration
 */

namespace Deepak_Miusage_API_Integration;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/WPBoilerplate/deepak-miusage-api-integration
 * @since             1.0.0
 * @package           Deepak_Miusage_API_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Deepak Miusage API Integration
 * Plugin URI:        https://github.com/WPBoilerplate/deepak-miusage-api-integration
 * Description:       Deepak Miusage API Integration by WPBoilerplate
 * Version:           1.0.0
 * Author:            WPBoilerplate
 * Author URI:        https://github.com/WPBoilerplate/deepak-miusage-api-integration
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       deepak-miusage-api-integration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEEPAK_MIUSAGE_API_INTEGRATION_FILES', __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/activator.php
 */
function deepak_miusage_api_integration_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';
	Includes\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/deactivator.php
 */
function deepak_miusage_api_integration_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
	Includes\Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'Deepak_Miusage_API_Integration\deepak_miusage_api_integration_activate' );
register_deactivation_hook( __FILE__, 'Deepak_Miusage_API_Integration\deepak_miusage_api_integration_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/main.php';

use Deepak_Miusage_API_Integration\Includes\Main;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function deepak_miusage_api_integration_run() {

	$plugin = Main::instance();

	/**
	 * Run this plugin on the plugins_loaded functions
	 */
	add_action( 'plugins_loaded', array( $plugin, 'run' ), 0 );

}
deepak_miusage_api_integration_run();