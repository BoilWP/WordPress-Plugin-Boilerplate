<?php
/**
 * Plugin Name Admin.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin' ) ) {

class Plugin_Name_Admin {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		// Actions
		add_action( 'init',              array( $this, 'includes' ) );
		add_action( 'admin_init',        array( $this, 'prevent_admin_access' ) );
		add_action( 'current_screen',    array( $this, 'tour' ) );
		add_action( 'current_screen',    array( $this, 'conditional_includes' ) );
		add_action( 'admin_footer', 'plugin_name_print_js', 25 );
		// Filters
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
		add_filter( 'update_footer',     array( $this, 'update_footer' ), 15 );
	} // END __construct()

	/**
	 * Include any classes we need within admin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @filter plugin_name_enable_admin_help_tab
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
	} // END includes()

	/**
	 * This includes the plugin tour.
	 *
	 * @since  1.0.*
	 * @access public
	 */
	public function tour() {
		// Plugin Tour
		$ignore_tour = get_option( 'plugin_name_ignore_tour' );

		if ( !isset( $ignore_tour ) || !$ignore_tour ) {
			//include( 'class-plugin-name-admin-pointers.php' );
		}
	} // END tour()

	/**
	 * Include admin files conditionally.
	 *
	 * @todo   Use this function to include content
	 *         specifically for other WordPress pages.
	 * @since  1.0.0
	 * @access public
	 */
	public function conditional_includes() {
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
	} // END conditional_includes()

	/**
	 * Prevent any user who cannot 'edit_posts'
	 * (subscribers etc) from accessing admin.
	 *
	 * @todo   Replace the page id slug 'page-slug' with the
	 *         page you want to redirect the user to.
	 * @since  1.0.0
	 * @access public
	 * @filter plugin_name_prevent_admin_access
	 */
	public function prevent_admin_access() {
		$prevent_access = false;

		if ( 'yes' == get_option( 'plugin_name_lock_down_admin' ) && ! is_ajax() && ! ( current_user_can( 'edit_posts' ) || current_user_can( Plugin_Name()->manage_plugin ) ) && basename( $_SERVER["SCRIPT_FILENAME"] ) !== 'admin-post.php' ) {
			$prevent_access = true;
		}

		$prevent_access = apply_filters( 'plugin_name_prevent_admin_access', $prevent_access );

		if ( $prevent_access ) {
			wp_safe_redirect( get_permalink( plugin_name_get_page_id( 'page-slug' ) ) );
			exit;
		}
	} // END prevent_admin_access()

	/**
	 * Filters the admin footer text by placing links
	 * for the plugin including a simply thank you to
	 * review the plugin on WordPress.org.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $text
	 * @filter plugin_name_admin_footer_review_text
	 * @return string
	 */
	public function admin_footer_text( $text ) {
		$screen = get_current_screen();

		if ( in_array( $screen->id, plugin_name_get_screen_ids() ) ) {

			$links = apply_filters( 'plugin_name_admin_footer_text_links', array(
				Plugin_Name()->web_url . '?utm_source=wpadmin&utm_campaign=footer' => __( 'Website', PLUGIN_NAME_TEXT_DOMAIN ),
				Plugin_Name()->doc_url . '?utm_source=wpadmin&utm_campaign=footer' => __( 'Documentation', PLUGIN_NAME_TEXT_DOMAIN ),
			) );

			$text    = '';
			$counter = 0;

			foreach ( $links as $key => $value ) {
				$text .= '<a target="_blank" href="' . $key . '">' . $value . '</a>';

				if( count( $links ) > 1 && count( $links ) != $counter ) {
					$text .= ' | ';
					$counter++;
				}
			}

			// Rating and Review added since 1.0.2
			if ( apply_filters( 'plugin_name_admin_footer_review_text', true ) ) {
				$text .= sprintf( __( 'If you like <strong>%1$s</strong> please leave a <a href="%2$s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating on <a href="%2$s" target="_blank">WordPress.org</a>. A huge thank you in advance!', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name, Plugin_Name()->wp_plugin_review_url );
			}

			return $text;
		}

		return $text;
	} // END admin_footer_text()

	/**
	 * Filters the update footer by placing details
	 * of the plugin and links to contribute or
	 * report issues with the plugin when viewing any
	 * of the plugin pages.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $text
	 * @filter plugin_name_update_footer_links
	 * @return string $text
	 */
	public function update_footer( $text ) {
		$screen = get_current_screen();

		if ( in_array( $screen->id, plugin_name_get_screen_ids() ) ) {
			$version_link = esc_attr( admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-about' ) );

			$text = '<span class="wrap">';

			$links = apply_filters( 'plugin_name_update_footer_links', array(
				PLUGIN_NAME_GITHUB_REPO_URI . 'blob/master/CONTRIBUTING.md?utm_source=wpadmin&utm_campaign=footer' => __( 'Contribute', PLUGIN_NAME_TEXT_DOMAIN ),
				PLUGIN_NAME_GITHUB_REPO_URI . 'issues?state=open&utm_source=wpadmin&utm_campaign=footer' => __( 'Report Bugs', PLUGIN_NAME_TEXT_DOMAIN ),
				PLUGIN_NAME_TRANSIFEX_PROJECT_URI . '?utm_source=wpadmin&utm_campaign=footer' => __( 'Translate', PLUGIN_NAME_TEXT_DOMAIN ),
			) );

			foreach( $links as $key => $value ) {
				$text .= '<a target="_blank" class="add-new-h2" href="' . $key . '">' . $value . '</a>';
			}

			$text .= '</span>' . '</p>'.
			'<p class="alignright">'.
			sprintf( __( '%s Version', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ).
			' : <a href="' . $version_link . '">'.
			esc_attr( Plugin_Name()->version ).
			'</a>';

			return $text;
		}

		return $text;
	} // END update_footer()

} // END class

} // END if class exists

return new Plugin_Name_Admin();
?>
