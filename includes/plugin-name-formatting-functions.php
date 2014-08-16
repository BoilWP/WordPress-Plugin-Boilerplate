<?php
/**
 * Plugin Name Formatting
 *
 * Functions for formatting data.
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Functions
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Sanitize taxonomy names. Slug format (no spaces, lowercase).
 *
 * Doesn't use sanitize_title as this destroys utf chars.
 *
 * @access public
 * @param mixed $taxonomy
 * @return string
 */
function plugin_name_sanitize_taxonomy_name( $taxonomy ) {
	$filtered = strtolower( remove_accents( stripslashes( strip_tags( $taxonomy ) ) ) );
	$filtered = preg_replace( '/&.+?;/', '', $filtered ); // Kill entities
	$filtered = str_replace( array( '.', '\'', '"' ), '', $filtered ); // Kill quotes and full stops.
	$filtered = str_replace( array( ' ', '_' ), '-', $filtered ); // Replace spaces and underscores.

	return apply_filters( 'sanitize_taxonomy_name', $filtered, $taxonomy );
}

/**
 * Clean variables
 *
 * @access public
 * @param string $var
 * @return string
 */
function plugin_name_clean( $var ) {
	return sanitize_text_field( $var );
}

/**
 * Merge two arrays
 *
 * @access public
 * @param array $a1
 * @param array $a2
 * @return array
 */
function plugin_name_array_overlay( $a1, $a2 ) {
	foreach( $a1 as $k => $v ) {
		if ( ! array_key_exists( $k, $a2 ) ) {
			continue;
		}
		if ( is_array( $v ) && is_array( $a2[ $k ] ) ) {
			$a1[ $k ] = plugin_name_array_overlay( $v, $a2[ $k ] );
		}
		else {
			$a1[ $k ] = $a2[ $k ];
		}
	}
	return $a1;
}

/**
 * let_to_num function.
 *
 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
 *
 * @access public
 * @param $size
 * @return int
 */
function plugin_name_let_to_num( $size ) {
	$l 		= substr( $size, -1 );
	$ret 	= substr( $size, 0, -1 );
	switch( strtoupper( $l ) ) {
		case 'P':
			$ret *= 1024;
		case 'T':
			$ret *= 1024;
		case 'G':
			$ret *= 1024;
		case 'M':
			$ret *= 1024;
		case 'K':
			$ret *= 1024;
	}
	return $ret;
}

/**
 * Plugin Name Date Format - Allows to change date format for everything Plugin Name
 *
 * @access public
 * @return string
 */
function plugin_name_date_format() {
	return apply_filters( 'plugin_name_date_format', get_option( 'date_format' ) );
}

/**
 * Plugin Name Time Format - Allows to change time format for everything Plugin Name
 *
 * @access public
 * @return string
 */
function plugin_name_time_format() {
	return apply_filters( 'plugin_name_time_format', get_option( 'time_format' ) );
}

/**
 * format_phone function.
 *
 * @access public
 * @param mixed $tel
 * @return string
 */
function plugin_name_format_phone_number( $tel ) {
	$tel = str_replace( '.', '-', $tel );
	return $tel;
}

/**
 * Wraps the output of the passed string provided 
 * by a date or time function in a <span> 
 * containing extra information for the Javascript 
 * to make use of.
 *
 * @access public
 * @return string
 */
function plugin_name_give_visitors_date_time( $string, $format ) {
	// If a Unix timestamp was requested, then don't modify it as it's most likely being used for PHP and not display
	// Also don't do anything for feeds
	if ( 'U' === $format || is_feed() ) {
		return $string;
	}

	// Populate the format if missing
	if ( empty( $format ) ) {
		switch ( current_filter() ) {
			case 'get_the_date':
			case 'get_comment_date':
				$format = get_option( 'date_format' );
				break;

			case 'get_post_time':
			case 'get_comment_time':
				$format = get_option( 'time_format' );
				break;

			default;
				return $string;
		}
	}

	// Get the GMT unfiltered value
	remove_filter( current_filter(), array( &$this, 'plugin_name_give_visitors_date_time' ), 1, 2 );
	switch ( current_filter() ) {
		case 'get_the_date':
		case 'get_post_time':
			$gmttime = get_post_time( 'c', true );
			break;

		case 'get_comment_date':
		case 'get_comment_time':
			$gmttime = get_comment_time( 'c', true );
			break;

		default;
			$gmttime = false; // Gotta add the filter back
	}
	add_filter( current_filter(), array( &$this, 'plugin_name_give_visitors_date_time' ), 1, 2 );

	if ( ! $gmttime ) {
		return $string;
	}

	return '<span class="localtime" data-ltformat="' . esc_attr( $format ) . '" data-lttime="' . esc_attr( $gmttime ) . '">' . $string . '</span>';
}

?>