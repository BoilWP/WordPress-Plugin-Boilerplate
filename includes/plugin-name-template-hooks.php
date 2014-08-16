<?php
/**
 * Plugin Name Template Hooks
 *
 * Action/filter hooks used for Plugin Name functions/templates
 *
 * @author 		Your Name / Your Company Name
 * @package 	Plugin Name/Templates
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Adds a generator tag in the header.
add_action( 'wp_head', 'generator' );

// Inject HTML into the various date/time functions.
add_filter( 'get_the_date', 'plugin_name_give_visitors_date_time', 1, 2 );
add_filter( 'get_post_time', 'plugin_name_give_visitors_date_time', 1, 2 );
add_filter( 'get_comment_date', 'plugin_name_give_visitors_date_time', 1, 2 );
add_filter( 'get_comment_time', 'plugin_name_give_visitors_date_time', 1, 2 );

?>