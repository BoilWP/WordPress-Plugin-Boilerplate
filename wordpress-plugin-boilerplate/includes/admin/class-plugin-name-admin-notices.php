<?php
/**
 * Display notices in the WordPress admin.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Notices' ) ) {

/**
 * Plugin_Name_Admin_Notices Class
 */
class Plugin_Name_Admin_Notices {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_print_styles', array( $this, 'add_notices' ) );
	} // END __construct()

	/**
	 * Add admin notices and styles when needed.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function add_notices() {
		if ( get_option( '_plugin_name_needs_update' ) == 1 || get_option( '_plugin_name_needs_pages' ) == 1 ) {
			wp_enqueue_style( 'plugin-name-activation', Plugin_Name()->plugin_url() . '/assets/css/admin/activation.css' );
			add_action( 'admin_notices', array( $this, 'install_notice' ) );
		}

		$template = get_option( 'template' );

		include( 'plugin-name-theme-support.php' );

		if ( ! current_theme_supports( 'plugin_name' ) && ! in_array( $template, $themes_supported ) ) {

			if ( ! empty( $_GET['hide_plugin_name_theme_support_check'] ) ) {
				update_option( 'plugin_name_theme_support_check', $template );
				return;
			}

			if ( get_option( 'plugin_name_theme_support_check' ) !== $template ) {
				wp_enqueue_style( 'plugin-name-activation', Plugin_Name()->plugin_url() . '/assets/css/admin/activation.css' );
				add_action( 'admin_notices', array( $this, 'theme_check_notice' ) );
			}
		}
	} // END add_notices()

	/**
	 * Show the install notices.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function install_notice() {
		// If we need to update, include a message with the update button.
		if ( get_option( '_plugin_name_needs_update' ) == 1 ) {
			include( 'views/html-notice-update.php' );
		}

		/**
		 * If we have just installed the plugin for the first time,
		 * include a message with an action button to install the plugins pages.
		 */
		else if ( get_option( '_plugin_name_needs_pages' ) == 1 ) {
			include( 'views/html-notice-install.php' );
		}
	} // END install_notice()

	/**
	 * Show the Theme Check notice.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function theme_check_notice() {
		include( 'views/html-notice-theme-support.php' );
	} // END theme_check_notice()

} // END Plugin_Name_Admin_Notices class.

} // END if class exists.

return new Plugin_Name_Admin_Notices();

?>
