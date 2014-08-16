<?php
/**
 * Plugin Name Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include core functions
include( 'plugin-name-conditional-functions.php' );
include( 'plugin-name-formatting-functions.php' );

/**
 * Retrieve page ids. returns -1 if no page is found
 *
 * @access public
 * @param string $page
 * @return int
 */
function plugin_name_get_page_id( $page ) {

	$page = apply_filters( 'plugin_name_get_' . $page . '_page_id', get_option('plugin_name_' . $page . '_page_id' ) );

	return $page ? $page : -1;
}

/**
 * Get template part.
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function plugin_name_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/plugin-name/slug-name.php
	if ( $name ) {
		$template = locate_template( array ( "{$slug}-{$name}.php", Plugin_Name()->template_path() . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( !$template && $name && file_exists( Plugin_Name()->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = Plugin_Name()->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/plugin-name/slug.php
	if ( !$template )
		$template = locate_template( array ( "{$slug}.php", Plugin_Name()->template_path() . "{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}

/**
 * Get other templates, passing attributes and including the file.
 *
 * @access public
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function plugin_name_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array($args) )
		extract( $args );

	$located = plugin_name_locate_template( $template_name, $template_path, $default_path );

	do_action( 'plugin_name_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'plugin_name_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
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
}

/**
 * Get Base Currency Code.
 * @return string
 */
function get_plugin_name_currency() {
	return apply_filters( 'plugin_name_currency', get_option('plugin_name_currency') );
}

/**
 * Get full list of currency codes.
 * @return array
 */
function get_plugin_name_currencies() {
	return array_unique(
		apply_filters( 'plugin_name_currencies',
			array(
				'AUD' => __( 'Australian Dollars', 'local_plugin_name' ),
				'BRL' => __( 'Brazilian Real', 'local_plugin_name' ),
				'BGN' => __( 'Bulgarian Lev', 'local_plugin_name' ),
				'CAD' => __( 'Canadian Dollars', 'local_plugin_name' ),
				'CNY' => __( 'Chinese Yuan', 'local_plugin_name' ),
				'CZK' => __( 'Czech Koruna', 'local_plugin_name' ),
				'DKK' => __( 'Danish Krone', 'local_plugin_name' ),
				'EUR' => __( 'Euros', 'local_plugin_name' ),
				'HKD' => __( 'Hong Kong Dollar', 'local_plugin_name' ),
				'HUF' => __( 'Hungarian Forint', 'local_plugin_name' ),
				'ISK' => __( 'Icelandic krona', 'local_plugin_name' ),
				'IDR' => __( 'Indonesia Rupiah', 'local_plugin_name' ),
				'INR' => __( 'Indian Rupee', 'local_plugin_name' ),
				'ILS' => __( 'Israeli Shekel', 'local_plugin_name' ),
				'JPY' => __( 'Japanese Yen', 'local_plugin_name' ),
				'KRW' => __( 'South Korean Won', 'local_plugin_name' ),
				'MYR' => __( 'Malaysian Ringgits', 'local_plugin_name' ),
				'MXN' => __( 'Mexican Peso', 'local_plugin_name' ),
				'NOK' => __( 'Norwegian Krone', 'local_plugin_name' ),
				'NZD' => __( 'New Zealand Dollar', 'local_plugin_name' ),
				'PHP' => __( 'Philippine Pesos', 'local_plugin_name' ),
				'PLN' => __( 'Polish Zloty', 'local_plugin_name' ),
				'GBP' => __( 'Pounds Sterling', 'local_plugin_name' ),
				'RON' => __( 'Romanian Leu', 'local_plugin_name' ),
				'RUB' => __( 'Russian Ruble', 'local_plugin_name' ),
				'SGD' => __( 'Singapore Dollar', 'local_plugin_name' ),
				'ZAR' => __( 'South African rand', 'local_plugin_name' ),
				'SEK' => __( 'Swedish Krona', 'local_plugin_name' ),
				'CHF' => __( 'Swiss Franc', 'local_plugin_name' ),
				'TWD' => __( 'Taiwan New Dollars', 'local_plugin_name' ),
				'THB' => __( 'Thai Baht', 'local_plugin_name' ),
				'TRY' => __( 'Turkish Lira', 'local_plugin_name' ),
				'USD' => __( 'US Dollars', 'local_plugin_name' ),
				'VND' => __( 'Vietnamese Dong', 'local_plugin_name' ),
			)
		)
	);
}

/**
 * Get Currency symbol.
 * @param string $currency (default: '')
 * @return string
 */
function get_plugin_name_currency_symbol( $currency = '' ) {
	if ( ! $currency )
		$currency = get_plugin_name_currency();

	switch ( $currency ) {
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'AUD' :
		case 'CAD' :
		case 'MXN' :
		case 'NZD' :
		case 'HKD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'CNY' :
		case 'RMB' :
		case 'JPY' :
			$currency_symbol = '&yen;';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'KRW' : $currency_symbol = '&#8361;'; break;
		case 'TRY' : $currency_symbol = '&#84;&#76;'; break;
		case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
		case 'ZAR' : $currency_symbol = '&#82;'; break;
		case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
		case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
		case 'DKK' : $currency_symbol = '&#107;&#114;'; break;
		case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
		case 'IDR' : $currency_symbol = 'Rp'; break;
		case 'INR' : $currency_symbol = 'Rs.'; break;
		case 'ISK' : $currency_symbol = 'Kr.'; break;
		case 'ILS' : $currency_symbol = '&#8362;'; break;
		case 'PHP' : $currency_symbol = '&#8369;'; break;
		case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
		case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
		case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
		case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
		case 'THB' : $currency_symbol = '&#3647;'; break;
		case 'GBP' : $currency_symbol = '&pound;'; break;
		case 'RON' : $currency_symbol = 'lei'; break;
		case 'VND' : $currency_symbol = '&#8363;'; break;
		default    : $currency_symbol = ''; break;
	}

	return apply_filters( 'plugin_name_currency_symbol', $currency_symbol, $currency );
}

/**
 * Queue some JavaScript code to be output in the footer.
 *
 * @param string $code
 */
function plugin_name_enqueue_js( $code ) {
	global $plugin_name_queued_js;

	if ( empty( $plugin_name_queued_js ) )
		$plugin_name_queued_js = "";

	$plugin_name_queued_js .= "\n" . $code . "\n";
}

/**
 * Output any queued javascript code in the footer.
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
}

/**
 * Set a cookie - wrapper for setcookie using WP constants
 *
 * @param  string  $name   Name of the cookie being set
 * @param  string  $value  Value of the cookie
 * @param  integer $expire Expiry of the cookie
 */
function plugin_name_setcookie( $name, $value, $expire = 0 ) {
	if ( ! headers_sent() ) {
		setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, false );
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		trigger_error( "Cookie cannot be set - headers already sent", E_USER_NOTICE );
	}
}

?>