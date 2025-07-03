<?php
namespace Deepak_Miusage_API_Integration\Admin\Partials;

/**
 * Deepak_Miusage_API_Integration_Main_Menu Main Menu Class.
 *
 * @since Deepak_Miusage_API_Integration_Main_Menu 1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Fired during plugin licences.
 *
 * This class defines all code necessary to run during the plugin's licences and update.
 *
 * @since      1.0.0
 * @package    Deepak_Miusage_API_Integration\Admin\Partials\Menu
 * @subpackage Deepak_Miusage_API_Integration\Admin\Partials
 */
class Menu {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Adds the plugin license page to the admin menu.
	 *
	 * @return void
	 */
	public function main_menu() {
		add_menu_page(
			__( 'Deepak Miusage API Integration', 'deepak-miusage-api-integration' ),
			__( 'Deepak Miusage API Integration', 'deepak-miusage-api-integration' ),
			'manage_options',
			'deepak-miusage-api-integration',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Reader the setting page for the plugins
	 */
	public function render_page() {
		// Handle refresh
		if ( isset( $_POST['deepak_miusage_refresh'] ) && check_admin_referer( 'deepak_miusage_refresh_action', 'deepak_miusage_refresh_nonce' ) ) {
			\Deepak_Miusage_API_Integration\Includes\API_Handler::force_refresh();
			add_settings_error( 'deepak_miusage_messages', 'refresh_success', __( 'Data refreshed successfully.', 'deepak-miusage-api-integration' ), 'updated' );
		}

		$data = \Deepak_Miusage_API_Integration\Includes\API_Handler::get_data();
		settings_errors( 'deepak_miusage_messages' );

		echo '<div class="wrap">';

			echo '<h1>' . esc_html__( 'Miusage API Data', 'deepak-miusage-api-integration' ) . '</h1>';

			// Refresh form
			echo '<form method="post">';
				wp_nonce_field( 'deepak_miusage_refresh_action', 'deepak_miusage_refresh_nonce' );
				submit_button( __( 'Refresh Data', 'deepak-miusage-api-integration' ), 'primary', 'deepak_miusage_refresh' );
			echo '</form><br>';

			if ( is_wp_error( $data ) ) {
				echo '<div class="notice notice-error"><p>' . esc_html( $data->get_error_message() ) . '</p></div>';
				echo '</div>';
				return;
			}

			$rows = $data['data']['rows'] ?? [];

			$table = new Miusage_Table( $rows );
			$table->prepare_items();
			$table->display();

		echo '</div>';
}

	/**
	 * Add Settings link to plugins area.
	 *
	 * @since    1.0.0
	 *
	 * @param array  $links Links array in which we would prepend our link.
	 * @param string $file  Current plugin basename.
	 * @return array Processed links.
	 */
	public function plugin_action_links( $links, $file ) {

		// Return normal links if not BuddyPress.
		if ( DEEPAK_MIUSAGE_API_INTEGRATION_PLUGIN_BASENAME !== $file ) {
			return $links;
		}

		// Add a few links to the existing links array.
		return array_merge(
			$links,
			array(
				'settings'	=> sprintf( '<a href="%sadmin.php?page=%s">%s</a>', admin_url(), 'deepak-miusage-api-integration', esc_html__( 'Settings', 'deepak-miusage-api-integration' ) ),
			)
		);
	}
}