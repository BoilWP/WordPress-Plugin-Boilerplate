<?php
/**
 * Help is provided for this plugin on the plugin pages.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Help' ) ) {

/**
 * Class - Plugin_Name_Admin_Help
 *
 * @since 1.0.0
 */
class Plugin_Name_Admin_Help {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'current_screen', array( $this, 'add_help_tabs' ), 50 );
	} // END __construct()

	/**
	 * Adds help tabs to the plugin pages.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function add_help_tabs() {
		$screen = get_current_screen();

		if ( ! in_array( $screen->id, plugin_name_get_screen_ids() ) )
			return;

		$screen->add_help_tab( array(
			'id'      => 'plugin_name_docs_tab',
			'title'   => __( 'Documentation', PLUGIN_NAME_TEXT_DOMAIN ),
			'content' =>
				'<p>' . sprintf( __( 'Thank you for using <strong>%s</strong> :) Should you need help using or extending %s please read the documentation.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name, Plugin_Name()->name ) . '</p>' .

				'<p><a href="' . Plugin_Name()->doc_url . '" class="button button-primary">' . sprintf( __( '%s Documentation', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ) . '</a> <!--a href="#" class="button">' . __( 'Restart Tour', PLUGIN_NAME_TEXT_DOMAIN ) . '</a--></p>'
		) );

		$screen->add_help_tab( array(
			'id'      => 'plugin_name_support_tab',
			'title'   => __( 'Support', PLUGIN_NAME_TEXT_DOMAIN ),
			'content' =>
				'<p>' . sprintf( __( 'After <a href="%s">reading the documentation</a>, for further assistance you can use the <a href="%s">community forum</a>.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->doc_url, Plugin_Name()->wp_plugin_support_url, __( 'Company Name' , PLUGIN_NAME_TEXT_DOMAIN ) ) . '</p>' .

				'<p>' . __( 'Before asking for help we recommend checking the status page to identify any problems with your configuration.', PLUGIN_NAME_TEXT_DOMAIN ) . '</p>' .

				'<p><a href="' . admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-status' ) . '" class="button button-primary">' . __( 'System Status', PLUGIN_NAME_TEXT_DOMAIN ) . '</a> <a href="' . Plugin_Name()->wp_plugin_support_url . '" class="button">' . __( 'Community Support', PLUGIN_NAME_TEXT_DOMAIN ) . '</a>'
		) );

		$screen->add_help_tab( array(
			'id'      => 'plugin_name_bugs_tab',
			'title'   => __( 'Found a bug?', PLUGIN_NAME_TEXT_DOMAIN ),
			'content' =>
				'<p>' . sprintf( __( 'If you find a bug within <strong>%s</strong> you can create a ticket via <a href="%s">Github issues</a>. Ensure you read the <a href="%s">contribution guide</a> prior to submitting your report. Be as descriptive as possible and please include your <a href="%s">system status report</a>.', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name, PLUGIN_NAME_GITHUB_REPO_URI . 'issues?state=open', PLUGIN_NAME_GITHUB_REPO_URI . 'blob/master/CONTRIBUTING.md', admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-status' ) ) . '</p>' .

				'<p><a href="' . PLUGIN_NAME_GITHUB_REPO_URI . 'issues?state=open" class="button button-primary">' . __( 'Report a bug', PLUGIN_NAME_TEXT_DOMAIN ) . '</a> <a href="' . admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-status' ) . '" class="button">' . __( 'System Status', PLUGIN_NAME_TEXT_DOMAIN ) . '</a></p>'
		) );

		if ( !empty( Plugin_Name()->web_url ) || !empty( Plugin_Name()->wp_plugin_url ) || defined( PLUGIN_NAME_GITHUB_REPO_URI ) ) {
			$screen->set_help_sidebar(
				'<p><strong>' . __( 'For more information:', PLUGIN_NAME_TEXT_DOMAIN ) . '</strong></p>' .
				'<p><a href="' . Plugin_Name()->web_url . '" target="_blank">' . sprintf( __( 'About %s', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ) . '</a></p>' .
				'<p><a href="' . Plugin_Name()->wp_plugin_url . '" target="_blank">' . __( 'Project on WordPress.org', PLUGIN_NAME_TEXT_DOMAIN ) . '</a></p>' .
				'<p><a href="' . PLUGIN_NAME_GITHUB_REPO_URI . '" target="_blank">' . __( 'Project on Github', PLUGIN_NAME_TEXT_DOMAIN ) . '</a></p>'
			);
		}

	} // END add_help_tabs()

} // END Plugin_Name_Admin_Help class.

} // END if class exists.

return new Plugin_Name_Admin_Help();

?>
