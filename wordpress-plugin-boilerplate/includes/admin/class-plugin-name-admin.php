<?php
/**
 * Plugin Name Admin.
 *
 * @author 		Your Name / Your Company Name
 * @category 	Admin
 * @package 	Plugin Name/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin' ) ) {

class Plugin_Name_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Actions
		add_action( 'init', array( &$this, 'includes' ) );
		add_action( 'admin_init', array( &$this, 'prevent_admin_access' ) );
		add_action( 'current_screen', array( &$this, 'tour' ) );
		add_action( 'current_screen', array( &$this, 'conditonal_includes' ) );
		add_action( 'admin_footer', 'plugin_name_print_js', 25 );

		// Filters
		add_filter( 'admin_footer_text', array( &$this, 'admin_footer_text' ) );
		add_filter( 'update_footer', array( &$this, 'update_footer' ), 15 );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		// Functions
		include( 'plugin-name-admin-functions.php' );

		// Use this action to register custom post types, user roles and anything else
		do_action( 'plugin_name_admin_include' );

		// Classes we only need if the ajax is not-ajax
		if ( ! is_ajax() ) {
			// Transifex Stats
			include( 'class-plugin-name-transifex-api.php' );
			include( 'class-plugin-name-transifex-stats.php' );

			// Main Plugin
			include( 'class-plugin-name-admin-menus.php' );
			include( 'class-plugin-name-admin-welcome.php' );
			include( 'class-plugin-name-admin-notices.php' );

			// Plugin Help
			if ( apply_filters( 'plugin_name_enable_admin_help_tab', true ) ) {
				include( 'class-plugin-name-admin-help.php' );
			}
		}
	}

	/**
	 * This includes the plugin tour.
	 */
	public function tour() {
		// Plugin Tour
		$ignore_tour = get_option('plugin_name_ignore_tour');

		if ( !isset( $ignore_tour ) || !$ignore_tour ) {
			//include( 'class-plugin-name-admin-pointers.php' );
		}
	}

	/**
	 * Include admin files conditionally
	 */
	public function conditonal_includes() {
		$screen = get_current_screen();

		switch ( $screen->id ) {
			case 'dashboard' :
				// Include a file to load only for the dashboard.
			break;
			case 'users' :
			case 'user' :
			case 'profile' :
			case 'user-edit' :
				// Include a file to load only for the user pages.
			break;
		}
	}

	/**
	 * Prevent any user who cannot 'edit_posts' (subscribers etc) from accessing admin
	 */
	public function prevent_admin_access() {
		$prevent_access = false;

		if ( 'yes' == get_option( 'plugin_name_lock_down_admin' ) && ! is_ajax() && ! ( current_user_can( 'edit_posts' ) || current_user_can( Plugin_Name()->manage_plugin ) ) && basename( $_SERVER["SCRIPT_FILENAME"] ) !== 'admin-post.php' ) {
			$prevent_access = true;
		}

		$prevent_access = apply_filters( 'plugin_name_prevent_admin_access', $prevent_access );

		if ( $prevent_access ) {
			wp_safe_redirect( get_permalink( plugin_name_get_page_id( 'page-slug' ) ) ); // Replace 'page-slug' with the page you want to redirect to.
			exit;
		}
	}

	/**
	 * Filters the admin footer text by placing links for the plugin.
	 *
	 * @access public
	 */
	function admin_footer_text($text) {
		$screen = get_current_screen();

		if ( in_array( $screen->id, plugin_name_get_screen_ids() ) ) {

			$links = apply_filters( 'plugin_name_admin_footer_text_links', array(
				Plugin_Name()->web_url . '?utm_source=wpadmin&utm_campaign=footer' => __( 'Website', PLUGIN_NAME_TEXT_DOMAIN ),
				Plugin_Name()->doc_url . '?utm_source=wpadmin&utm_campaign=footer' => __( 'Documentation', PLUGIN_NAME_TEXT_DOMAIN ),
			) );

			$text = '';
			$counter = '1';

			foreach( $links as $key => $value ) {
				$text .= '<a target="_blank" href="' . $key . '">' . $value . '</a>';

				if( count( $links ) > 1 && count( $links ) != $counter ) {
					$text .= ' | ';
					$counter++;
				}
			}

			return $text;
		}

		return $text;
	}

	/**
	 * Filters the update footer by placing details of the plugin and links.
	 *
	 * @access public
	 */
	function update_footer( $text ) {
		$screen = get_current_screen();

		if ( in_array( $screen->id, plugin_name_get_screen_ids() ) ) {
			$version_link = esc_attr( admin_url('index.php?page=' . PLUGIN_NAME_PAGE . '-about') );

			$text = '<span class="wrap">';

			$links = apply_filters( 'plugin_name_update_footer_links', array(
				GITHUB_REPO_URL . 'blob/master/CONTRIBUTING.md?utm_source=wpadmin&utm_campaign=footer' => __( 'Contribute', PLUGIN_NAME_TEXT_DOMAIN ),
				GITHUB_REPO_URL . 'issues?state=open&utm_source=wpadmin&utm_campaign=footer' => __( 'Report Bugs', PLUGIN_NAME_TEXT_DOMAIN ),
			) );

			foreach( $links as $key => $value ) {
				$text .= '<a target="_blank" class="add-new-h2" href="' . $key . '">' . $value . '</a>';
			}

			$text .= '</span>' . '</p>'.
			'<p class="alignright">'.
			sprintf( __('%s Version', PLUGIN_NAME_TEXT_DOMAIN), Plugin_Name()->name ).
			' : <a href="' . $version_link . '">'.
			esc_attr( Plugin_Name()->version ).
			'</a>';

			return $text;
		}

		return $text;
	}

}

} // end if class exists

return new Plugin_Name_Admin();
?>