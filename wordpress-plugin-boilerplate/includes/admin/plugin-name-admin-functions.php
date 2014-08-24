<?php
/**
 * Plugin Name Admin Functions
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Admin/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get all Plugin Name screen ids
 *
 * @since 1.0.0
 * @return array
 */
function plugin_name_get_screen_ids() {
	$menu_name = strtolower( str_replace ( ' ', '-', Plugin_Name()->menu_name ) );

	$plugin_name_screen_id = PLUGIN_NAME_SCREEN_ID;

	return apply_filters( 'plugin_name_screen_ids', array(
		'plugins',
		'toplevel_page_' . $plugin_name_screen_id,
		'dashboard_page_' . $plugin_name_screen_id . '-about',
		'dashboard_page_' . $plugin_name_screen_id . '-changelog',
		'dashboard_page_' . $plugin_name_screen_id . '-credits',
		'dashboard_page_' . $plugin_name_screen_id . '-translations',
		'dashboard_page_' . $plugin_name_screen_id . '-freedoms',
		$plugin_name_screen_id . '_page_' . $plugin_name_screen_id . '_settings',
		$plugin_name_screen_id . '_page_' . $plugin_name_screen_id . '-settings',
		$plugin_name_screen_id . '_page_' . $plugin_name_screen_id . '-status',
		$menu_name . '_page_' . $plugin_name_screen_id . '_settings',
		$menu_name . '_page_' . $plugin_name_screen_id . '-settings',
		$menu_name . '_page_' . $plugin_name_screen_id . '-status',
	) );
}

/**
 * Create a page and store the ID in an option.
 *
 * @access public
 * @since 1.0.0
 * @param mixed $slug Slug for the new page
 * @param mixed $option Option name to store the page's ID
 * @param string $page_title (default: '') Title for the new page
 * @param string $page_content (default: '') Content for the new page
 * @param int $post_parent (default: 0) Parent for the new page
 * @return int page ID
 */
function plugin_name_create_page( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ) {
	global $wpdb;

	$option_value = get_option( $option );

	if ( $option_value > 0 && get_post( $option_value ) )
		return -1;

	$page_found = null;

	if ( strlen( $page_content ) > 0 ) {
		// Search for an existing page with the specified page content (typically a shortcode)
		$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
	}
	else {
		// Search for an existing page with the specified page slug
		$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_name = %s LIMIT 1;", $slug ) );
	}

	if ( $page_found ) {
		if ( ! $option_value ) {
			update_option( $option, $page_found );
		}

		return $page_found;
	}

	$page_data = array(
		'post_status'       => 'publish',
		'post_type'         => 'page',
		'post_author'       => 1,
		'post_name'         => $slug,
		'post_title'        => $page_title,
		'post_content'      => $page_content,
		'post_parent'       => $post_parent,
		'comment_status'    => 'closed'
	);

	$page_id = wp_insert_post( $page_data );

	if ( $option ) {
		update_option( $option, $page_id );
	}

	return $page_id;
}

/**
 * Output admin fields.
 *
 * Loops though the plugin name options array and outputs each field.
 *
 * @since 1.0.0
 * @param array $options Opens array to output
 */
function plugin_name_admin_fields( $options ) {
	if ( ! class_exists( 'Plugin_Name_Admin_Settings' ) ) {
		include 'class-plugin-name-admin-settings.php';
	}

	Plugin_Name_Admin_Settings::output_fields( $options );
}

/**
 * Update all settings which are passed.
 *
 * @access public
 * @since 1.0.0
 * @param array $options
 * @return void
 */
function plugin_name_update_options( $options ) {
	if ( ! class_exists( 'Plugin_Name_Admin_Settings' ) ) {
		include 'class-plugin-name-admin-settings.php';
	}

	Plugin_Name_Admin_Settings::save_fields( $options );
}

/**
 * Get a setting from the settings API.
 *
 * @since 1.0.0
 * @param mixed $option
 * @return string
 */
function plugin_name_settings_get_option( $option_name, $default = '' ) {
	if ( ! class_exists( 'Plugin_Name_Admin_Settings' ) ) {
		include 'class-plugin-name-admin-settings.php';
	}

	return Plugin_Name_Admin_Settings::get_option( $option_name, $default );
}

/**
 * Display Translation progress from Transifex
 *
 * @since 1.0.0
 * @param string $slug Transifex slug
 */
function transifex_display_translation_progress() {
	$stats = new Plugin_Name_Transifex_Stats();
	$resource = Plugin_Name()->transifex_resources_slug;
	$data_resource = $resource ? " data-resource-slug='{$resource}'" : ''; ?>
	<div class='transifex-stats' data-project-slug='<?php echo Plugin_Name()->transifex_project_slug; ?>'<?php echo $data_resource; ?>/>
		<?php $stats->display_translations_progress(); ?>
	</div>
	<?php
}

/**
 * Display Translation Stats from Transifex
 *
 * @since 1.0.0
 * @param string $slug Transifex slug
 */
function transifex_display_translators() {
	$stats = new Plugin_Name_Transifex_Stats();
	?>
	<div class='transifex-stats-contributors' data-project-slug='<?php echo Plugin_Name()->transifex_project_slug; ?>'/>
		<?php $stats->display_contributors(); ?>
	</div>
	<?php
}

/**
 * Hooks Plugin Name actions, when present in the $_REQUEST superglobal. 
 * Every plugin_name_action present in $_REQUEST is called using 
 * WordPress's do_action function. These functions are called on init.
 *
 * @since 1.0.0
 * @return void
 */
function plugin_name_do_actions() {
	if ( isset( $_REQUEST['plugin_name_action'] ) ) {
		do_action( 'plugin_name_' . $_REQUEST['plugin_name_action'], $_REQUEST );
	}
}
add_action( 'admin_init', 'plugin_name_do_actions' );

?>