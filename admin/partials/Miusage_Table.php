<?php
namespace Deepak_Miusage_API_Integration\Admin\Partials;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

use WP_List_Table;

class Miusage_Table extends WP_List_Table {

	/**
	 * Table data.
	 */
	private $items_data = [];

	public function __construct( $data ) {
		parent::__construct( [
			'singular' => 'miusage_row',
			'plural'   => 'miusage_rows',
			'ajax'     => false,
		] );

		$this->items_data = $data;
	}

	public function get_columns() {
		return [
			'id'         => __( 'ID', 'deepak-miusage-api-integration' ),
			'first_name' => __( 'First Name', 'deepak-miusage-api-integration' ),
			'last_name'  => __( 'Last Name', 'deepak-miusage-api-integration' ),
			'email'      => __( 'Email', 'deepak-miusage-api-integration' ),
			'date'       => __( 'Date', 'deepak-miusage-api-integration' ),
		];
	}

	public function prepare_items() {

		$columns  = $this->get_columns();

		$this->_column_headers = [ $columns ];

		$this->items = array_map( function( $row ) {
			return [
				'id'         => (int) ( $row['id'] ?? 0 ),
				'first_name' => sanitize_text_field( $row['fname'] ?? '' ),
				'last_name'  => sanitize_text_field( $row['lname'] ?? '' ),
				'email'      => sanitize_email( $row['email'] ?? '' ),
				'date'       => date_i18n( 'Y-m-d H:i:s', (int) ( $row['date'] ?? 0 ) ),
			];
		}, $this->items_data );
	}

	public function column_default( $item, $column_name ) {
		return esc_html( $item[ $column_name ] ?? '' );
	}
}
