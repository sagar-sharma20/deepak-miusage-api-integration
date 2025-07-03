<?php
namespace Deepak_Miusage_API_Integration\Includes;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Define the internationalization functionality
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/includes
 */
class I18n {

	/**
	 * Actually load the plugin textdomain on `init`
	 */
	public function do_load_textdomain() {
		load_plugin_textdomain(
			'deepak-miusage-api-integration',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
