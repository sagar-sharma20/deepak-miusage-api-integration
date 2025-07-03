<?php
namespace Deepak_Miusage_API_Integration\Includes;

use WP_CLI;

defined( 'ABSPATH' ) || exit;

/**
 * Handles CLI commands for Miusage API integration.
 */
class CLI_Command {

	/**
	 * Clears the Miusage data transient.
	 *
	 * ## EXAMPLES
	 *
	 * wp miusage refresh --fetch=true
	 *
	 * @when after_wp_load
	 */
	public function refresh( $args, $assoc_args ) {

		if ( ! isset( $assoc_args['fetch'] ) || true !== $assoc_args['fetch'] ) {
			API_Handler::force_refresh( false );

			\WP_CLI::success( __( 'Miusage API data cache cleared. It will be refreshed on the next request.', 'deepak-miusage-api-integration' ) );
		} else {
			API_Handler::force_refresh();

			\WP_CLI::success( __( 'Miusage API data cache cleared. It has been updated.', 'deepak-miusage-api-integration' ) );
		}
	}

	/**
	 * Display Miusage API data as a table in WP-CLI.
	 *
	 * ## EXAMPLES
	 *
	 *     wp miusage show
	 *
	 * @when after_wp_load
	 */
	public function show() {
		$data = API_Handler::get_data();

		if ( is_wp_error( $data ) ) {
			WP_CLI::error( $data->get_error_message() );
		}

		$rows_data = $data['data']['rows'] ?? [];

		if ( empty( $rows_data ) ) {
			WP_CLI::warning( __( 'No data found.', 'deepak-miusage-api-integration' ) );
			return;
		}

		$rows = [];
		foreach ( $rows_data as $row ) {
			$rows[] = [
				'ID'         => (int) ( $row['id'] ?? 0 ),
				'First Name' => sanitize_text_field( $row['fname'] ?? '' ),
				'Last Name'  => sanitize_text_field( $row['lname'] ?? '' ),
				'Email'      => sanitize_email( $row['email'] ?? '' ),
				'Date'       => date_i18n( 'Y-m-d H:i:s', (int) ( $row['date'] ?? 0 ) ),
			];
		}

		// Desired column headers (exact order)
		$columns = [ 'ID', 'First Name', 'Last Name', 'Email', 'Date' ];

		WP_CLI\Utils\format_items( 'table', $rows, $columns );
	}
}
