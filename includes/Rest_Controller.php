<?php
namespace Deepak_Miusage_API_Integration\Includes;

use WP_REST_Request;
use WP_REST_Server;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Registers all custom REST API endpoints for the plugin.
 *
 * @package    Deepak_Miusage_API_Integration
 * @subpackage Deepak_Miusage_API_Integration/includes
 */
class Rest_Controller {

	/**
	 * Register custom REST API routes.
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			'deepak-miusage/v1',
			'/data',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( self::class, 'get_data' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Handle the /data endpoint and return cached or live data.
	 *
	 * @param WP_REST_Request $request The incoming REST request.
	 * @return \WP_REST_Response
	 */
	public static function get_data( WP_REST_Request $request ) {

		$data = API_Handler::get_data();

		/**
		 * Return if there is any error
		 */
		if ( is_wp_error( $data ) ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => $data->get_error_message(),
			) );
		}

		/**
		 * Return if there is some data
		 */
		return rest_ensure_response( array(
			'success' => true,
			'data'    => $data,
		) );
	}
}
