<?php
namespace Deepak_Miusage_API_Integration\Includes;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Register all reset API endpoint
 *
 * @link       https://github.com/WPBoilerplate/deepak-miusage-api-integration
 * @since      1.0.0
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/includes
 * @author     WPBoilerplate <contact@wpboilerplate.com>
 */
class API_Handler {

	/**
	 * Cache key used for transient storage.
	 *
	 * @var string
	 */
	const CACHE_KEY = 'deepak_miusage_api_cache';

	/**
	 * URL of the Data.
	 *
	 * @var string
	 */
	const REMOTE_URL = 'https://miusage.com/v1/challenge/1/';

	/**
	 * Retrive the data from the DB or from the Endpoints.
	 */
	public static function get_data() {

		$data = self::get_transient_data();

		// Check if cache is available
		if ( false !== $data ) {
			return $data;
		}

		$response = wp_remote_get( self::REMOTE_URL );

		if ( is_wp_error( $response ) ) {
			return new \WP_Error( 'api_error', __( 'Failed to fetch data from remote API.', 'deepak-miusage-api-integration' ) );
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( empty( $data ) || ! is_array( $data ) ) {
			return new \WP_Error( 'invalid_data', __( 'Invalid data received from API.', 'deepak-miusage-api-integration' ) );
		}

		set_transient( self::CACHE_KEY, $data, HOUR_IN_SECONDS );

		return $data;
	}

	/**
	 * Force refresh of data from the remote API.
	 *
	 * @return bool True if refreshed, false otherwise.
	 */
	public static function force_refresh( $fetch = true ) {

		delete_transient( self::CACHE_KEY );

		if ( $fetch ) {
			$result = self::get_data();
			return ! is_wp_error( $result );
		}

		return true;
	}

	/**
	 * Get the data from transient.
	 */
	public static function get_transient_data() {
		return get_transient( self::CACHE_KEY );
	}
}
