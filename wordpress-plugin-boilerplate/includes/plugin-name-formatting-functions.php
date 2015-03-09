<?php
/**
 * Plugin Name Formatting
 *
 * @todo     Place your formatting functions here.
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  Plugin Name/Functions
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Sanitize taxonomy names. Slug format (no spaces, lowercase).
 *
 * Doesn't use sanitize_title as this destroys utf chars.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed $taxonomy
 * @return string
 */
function plugin_name_sanitize_taxonomy_name( $taxonomy ) {
	$filtered = strtolower( remove_accents( stripslashes( strip_tags( $taxonomy ) ) ) );
	$filtered = preg_replace( '/&.+?;/', '', $filtered ); // Kill entities
	$filtered = str_replace( array( '.', '\'', '"' ), '', $filtered ); // Kill quotes and full stops.
	$filtered = str_replace( array( ' ', '_' ), '-', $filtered ); // Replace spaces and underscores.

	return apply_filters( 'sanitize_taxonomy_name', $filtered, $taxonomy );
} // END plugin_name_sanitize_taxonomy_name()

/**
 * Gets the filename part of a download URI
 *
 * @since  1.0.0
 * @access public
 * @param  string $file_url
 * @return string
 */
function plugin_name_get_filename_from_url( $file_url ) {
	$parts = parse_url( $file_url );
	if ( isset( $parts['path'] ) ) {
		return basename( $parts['path'] );
	}
} // END plugin_name_get_filename_from_url()

/**
 * Normalise dimensions, unify to cm then convert to wanted unit value
 *
 * Usage: plugin_name_get_dimension(55, 'in');
 *
 * @since  1.0.0
 * @access public
 * @param  mixed $dim
 * @param  mixed $to_unit 'in', 'm', 'cm', 'm'
 * @return float
 */
function plugin_name_get_dimension( $dim, $to_unit ) {
	$from_unit = strtolower( get_option( 'plugin_name_dimension_unit' ) );
	$to_unit   = strtolower( $to_unit );

	// Unify all units to cm first
	if ( $from_unit !== $to_unit ) {
		switch ( $from_unit ) {
			case 'in':
				$dim *= 2.54;
			break;
			case 'm':
				$dim *= 100;
			break;
			case 'mm':
				$dim *= 0.1;
			break;
			case 'yd':
				$dim *= 91.44;
			break;
		}

		// Output desired unit
		switch ( $to_unit ) {
			case 'in':
				$dim *= 0.3937;
			break;
			case 'm':
				$dim *= 0.01;
			break;
			case 'mm':
				$dim *= 10;
			break;
			case 'yd':
				$dim *= 0.010936133;
			break;
		}
	}

	return ( $dim < 0 ) ? 0 : $dim;
} // END plugin_name_get_dimension()

/**
 * Normalise weights, unify to cm then convert to wanted unit value
 *
 * Usage: plugin_name_get_weight(55, 'kg');
 *
 * @since  1.0.0
 * @access public
 * @param  mixed $weight
 * @param  mixed $to_unit 'g', 'kg', 'lbs'
 * @return float
 */
function plugin_name_get_weight( $weight, $to_unit ) {
	$from_unit = strtolower( get_option('plugin_name_weight_unit') );
	$to_unit   = strtolower( $to_unit );

	// Unify all units to kg first
	if ( $from_unit !== $to_unit ) {
		switch ( $from_unit ) {
			case 'g':
				$weight *= 0.001;
			break;
			case 'lbs':
				$weight *= 0.4536;
			break;
			case 'oz':
				$weight *= 0.0283;
			break;
		}

		// Output desired unit
		switch ( $to_unit ) {
			case 'g':
				$weight *= 1000;
			break;
			case 'lbs':
				$weight *= 2.2046;
			break;
			case 'oz':
				$weight *= 35.274;
			break;
		}
	}

	return ( $weight < 0 ) ? 0 : $weight;
} // END plugin_name_get_weight()

/**
 * Trim trailing zeros off prices.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed $price
 * @return string
 */
function plugin_name_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( get_option( 'plugin_name_price_decimal_sep' ), '/' ) . '0++$/', '', $price );
} // END plugin_name_trim_zeros()

/**
 * Format decimal numbers ready for DB storage
 *
 * Sanitize, remove locale formatting, and optionally round + trim off zeros
 *
 * @since  1.0.0
 * @param  float|string $number Expects either a float or a string with a decimal separator only (no thousands)
 * @param  mixed $dp number of decimal points to use, blank to use plugin_name_price_num_decimals, or false to avoid all rounding.
 * @param  boolean $trim_zeros from end of string
 * @return string
 */
function plugin_name_format_decimal( $number, $dp = false, $trim_zeros = false ) {
	// Remove locale from string
	if ( ! is_float( $number ) ) {
		$locale   = localeconv();
		$decimals = array( get_option( 'plugin_name_price_decimal_sep' ), $locale['decimal_point'], $locale['mon_decimal_point'] );
		$number   = plugin_name_clean( str_replace( $decimals, '.', $number ) );
	}

	// DP is false - don't use number format, just return a string in our format
	if ( $dp !== false ) {
		$dp     = intval( $dp == "" ? get_option( 'plugin_name_price_num_decimals' ) : $dp );
		$number = number_format( floatval( $number ), $dp, '.', '' );
	}

	if ( $trim_zeros && strstr( $number, '.' ) ) {
		$number = rtrim( rtrim( $number, '0' ), '.' );
	}

	return $number;
} // END plugin_name_format_decimal()

/**
 * Convert a float to a string without locale formatting which PHP adds when changing floats to strings
 *
 * @since  1.0.0
 * @access public
 * @param  float $float
 * @return string
 */
function plugin_name_float_to_string( $float ) {
	if ( ! is_float( $float ) ) {
		return $float;
	}

	$locale = localeconv();
	$string = strval( $float );
	$string = str_replace( $locale['decimal_point'], '.', $string );

	return $string;
} // END plugin_name_float_to_string()

/**
 * Clean variables
 *
 * @since  1.0.0
 * @access public
 * @param  string $var
 * @return string
 */
function plugin_name_clean( $var ) {
	return sanitize_text_field( $var );
} // END plugin_name_clean()

/**
 * Merge two arrays
 *
 * @since  1.0.0
 * @access public
 * @param  array $a1
 * @param  array $a2
 * @return array
 */
function plugin_name_array_overlay( $a1, $a2 ) {
  foreach( $a1 as $k => $v ) {
    if ( ! array_key_exists( $k, $a2 ) ) {
      continue;
    }
    if ( is_array( $v ) && is_array( $a2[ $k ] ) ) {
        $a1[ $k ] = plugin_name_array_overlay( $v, $a2[ $k ] );
    } else {
        $a1[ $k ] = $a2[ $k ];
    }
  }

  return $a1;
} // END plugin_name_array_overlay()

/**
 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
 *
 * @since  1.0.0
 * @access public
 * @param  $size
 * @return int
 */
function plugin_name_let_to_num( $size ) {
  $l   = substr( $size, -1 );
  $ret = substr( $size, 0, -1 );

  switch( strtoupper( $l ) ) {
    case 'P':
      $ret *= 1024;
			break;
    case 'T':
      $ret *= 1024;
			break;
    case 'G':
      $ret *= 1024;
			break;
    case 'M':
      $ret *= 1024;
			break;
    case 'K':
      $ret *= 1024;
			break;
  }

  return $ret;
} // END plugin_name_let_to_num()

?>
