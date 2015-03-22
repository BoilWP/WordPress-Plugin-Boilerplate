<?php
/**
 * Plugin Name Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include core functions
include( 'plugin-name-conditional-functions.php' );
include( 'plugin-name-formatting-functions.php' );

/**
 * Retrieve page ids. returns -1 if no page is found
 *
 * @since  1.0.0
 * @access public
 * @param  string $page
 * @return int
 */
function plugin_name_get_page_id( $page ) {
	$page = apply_filters( 'plugin_name_get_' . $page . '_page_id', get_option('plugin_name_' . $page . '_page_id' ) );

	return $page ? $page : -1;
} // END plugin_name_get_page_id()

/**
 * Get template part.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $slug
 * @param  string $name (default: '')
 * @return void
 */
function plugin_name_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/plugin-name/slug-name.php
	if ( $name ) {
		$template = locate_template( array ( "{$slug}-{$name}.php", Plugin_Name()->template_path() . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( Plugin_Name()->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = Plugin_Name()->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/plugin-name/slug.php
	if ( ! $template )
		$template = locate_template( array ( "{$slug}.php", Plugin_Name()->template_path() . "{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
} // END plugin_name_get_template_part()

/**
 * Get other templates, passing attributes and including the file.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $template_name
 * @param  array  $args (default: array())
 * @param  string $template_path (default: '')
 * @param  string $default_path (default: '')
 * @return void
 */
function plugin_name_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array($args) )
		extract( $args );

	$located = plugin_name_locate_template( $template_name, $template_path, $default_path );

	do_action( 'plugin_name_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'plugin_name_after_template_part', $template_name, $template_path, $located, $args );
} // END plugin_name_get_template()

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme     / $template_path / $template_name
 *		yourtheme     / $template_name
 *		$default_path / $template_name
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $template_name
 * @param  string $template_path (default: '')
 * @param  string $default_path (default: '')
 * @return string
 */
function plugin_name_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) $template_path = Plugin_Name()->template_path();
	if ( ! $default_path ) $default_path = Plugin_Name()->plugin_path() . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters('plugin_name_locate_template', $template, $template_name, $template_path);
} // END plugin_name_locate_template()

/**
 * Get an image size.
 *
 * Variable is filtered by plugin_name_get_image_size_{image_size}
 *
 * @since  1.0.0
 * @access public
 * @param  string $image_size
 * @return array
 */
function plugin_name_get_image_size( $image_size ) {
	if ( in_array( $image_size, array( '_thumbnail', '_single' ) ) ) {
		$size           = get_option( $image_size . '_image_size', array() );
		$size['width']  = isset( $size['width'] ) ? $size['width'] : '300';
		$size['height'] = isset( $size['height'] ) ? $size['height'] : '300';
		$size['crop']   = isset( $size['crop'] ) ? $size['crop'] : 1;
	}
	else {
		$size = array(
			'width'  => '300',
			'height' => '300',
			'crop'   => 1
		);
	}
	return apply_filters( 'plugin_name_get_image_size_' . $image_size, $size );
} // END plugin_name_get_image_size()

/**
 * Queue some JavaScript code to be output in the footer.
 *
 * @since  1.0.0
 * @access public
 * @param  string $code
 * @global $plugin_name_queued_js
 */
function plugin_name_enqueue_js( $code ) {
	global $plugin_name_queued_js;

	if ( empty( $plugin_name_queued_js ) )
		$plugin_name_queued_js = "";

	$plugin_name_queued_js .= "\n" . $code . "\n";
} // END plugin_name_enqueue_js()

/**
 * Output any queued javascript code in the footer.
 *
 * @since  1.0.0
 * @access public
 * @global $plugin_name_queued_js
 * @return $plugin_name_queued_js
 */
function plugin_name_print_js() {
	global $plugin_name_queued_js;

	if ( ! empty( $plugin_name_queued_js ) ) {

		echo "<!-- Plugin Name JavaScript-->\n<script type=\"text/javascript\">\njQuery(document).ready(function($) {";

		// Sanitize
		$plugin_name_queued_js = wp_check_invalid_utf8( $plugin_name_queued_js );
		$plugin_name_queued_js = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', "'", $plugin_name_queued_js );
		$plugin_name_queued_js = str_replace( "\r", '', $plugin_name_queued_js );

		echo $plugin_name_queued_js . "});\n</script>\n";

		unset( $plugin_name_queued_js );
	}
} // END plugin_name_print_js()

/**
 * Set a cookie - wrapper for setcookie using WP constants
 *
 * @since 1.0.0
 * @param string  $name   Name of the cookie being set
 * @param string  $value  Value of the cookie
 * @param integer $expire Expiry of the cookie
 * @return void
 */
function plugin_name_setcookie( $name, $value, $expire = 0 ) {
	if ( ! headers_sent() ) {
		setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, false );
	} else if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		trigger_error( "Cookie cannot be set - headers already sent", E_USER_NOTICE );
	}
} // END plugin_name_setcookie()

?>
