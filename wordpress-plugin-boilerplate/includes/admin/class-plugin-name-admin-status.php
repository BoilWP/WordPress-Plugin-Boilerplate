<?php
/**
 * Debug Plugin Name / Status page
 *
 * @author 		Your Name / Your Company Name
 * @category 	Admin
 * @package 	Plugin Name/Admin/System Status
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Status' ) ) {

/**
 * Plugin_Name_Admin_Status Class
 */
class Plugin_Name_Admin_Status {

	/**
	 * Handles output of the reports page in admin.
	 */
	public function output() {
		$current_tab = ! empty( $_REQUEST['tab'] ) ? sanitize_title( $_REQUEST['tab'] ) : 'status';

		include_once( 'views/html-admin-page-status.php' );
	}

	/**
	 * Handles output of report
	 */
	public function status_report() {
		global $plugin_name, $wpdb;

		include_once( 'views/html-admin-page-status-report.php' );
	}

	/**
	 * Handles output of import / export
	 */
	public function status_port( $port ) {
		global $plugin_name, $wpdb;

		include_once( 'views/html-admin-page-status-import-export.php' );
	}

	/**
	 * Handles output of tools
	 */
	public function status_tools() {
		global $plugin_name, $wpdb;

		$tools = $this->get_tools();

		if ( ! empty( $_GET['action'] ) && ! empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'debug_action' ) ) {

			include( Plugin_Name()->plugin_path() . '/includes/admin/class-plugin-name-install.php' );
			$installer = new Plugin_Name_Install();

			switch ( $_GET['action'] ) {

				case "install_pages" :
					$installer->create_pages();
					echo '<div class="updated plugin-name-message"><p>' . sprintf( __( 'All missing %s pages was installed successfully.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ) . '</p></div>';
				break;

				case "reset_roles" :
					// Remove then re-add caps and roles
					$installer->remove_roles();
					$installer->create_roles();

					echo '<div class="updated plugin-name-message"><p>' . __( 'Roles successfully reset', PLUGIN_NAME_TEXT_DOMAIN ) . '</p></div>';
				break;

				case "restart" :
					$installer->remove_roles();
					$installer->delete_options();

					/** TODO: Place your own functions here. */

					$installer->create_options();
					$installer->create_roles();

					echo '<div class="updated plugin-name-message"><p>' . __( 'All previous data has been removed and re-installed the defaults.', PLUGIN_NAME_TEXT_DOMAIN ) . '</p></div>';

				break;

				default:
					$action = esc_attr( $_GET['action'] );
					if( isset( $tools[ $action ]['callback'] ) ) {
						$callback = $tools[ $action ]['callback'];
						$return = call_user_func( $callback );
						if( $return === false ) {
							if( is_array( $callback ) ) {
								echo '<div class="error"><p>' . sprintf( __( 'There was an error calling %s::%s', PLUGIN_NAME_TEXT_DOMAIN ), get_class( $callback[0] ), $callback[1] ) . '</p></div>';

							} else {
								echo '<div class="error"><p>' . sprintf( __( 'There was an error calling %s', PLUGIN_NAME_TEXT_DOMAIN ), $callback ) . '</p></div>';
							}
						}
					}
				break;
			}
		}
		
		// Display message if settings settings have been saved
		if ( isset( $_REQUEST['settings-updated'] ) ) {
			echo '<div class="updated"><p>' . __( 'Your changes have been saved.', PLUGIN_NAME_TEXT_DOMAIN ) . '</p></div>';
		}

		include_once( 'views/html-admin-page-status-tools.php' );
	}

	/**
	 * Get tools
	 *
	 * @return array of tools
	 */
	public function get_tools() {
		return apply_filters( 'plugin_name_debug_tools', array(

			'install_pages' => array(
				'name'		=> sprintf( __( 'Install %s Pages', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
				'button' 	=> __( 'Install pages', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> sprintf( __( '<strong class="red">Note:</strong> This tool will install all the missing %s pages. Pages already defined and set up will not be replaced.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
			),

			'reset_roles' => array(
				'name'		=> __( 'Capabilities', PLUGIN_NAME_TEXT_DOMAIN ),
				'button'	=> __( 'Reset capabilities', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc'		=> sprintf( __( 'This tool will reset the admin roles to default. Use this if your users cannot access all of the %s admin pages.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
			),

			'restart' => array(
				'name'		=> __( 'Start Over', PLUGIN_NAME_TEXT_DOMAIN ),
				'button'	=> __( 'Restart', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc'		=> sprintf( __( 'This tool will erase all settings, database tables (if any) and re-install "<em>%s</em>". Use this if you are really sure. All current data will be lost and will not be recoverable.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
			),

		) );
	}

}

}

return new Plugin_Name_Admin_Status();

?>