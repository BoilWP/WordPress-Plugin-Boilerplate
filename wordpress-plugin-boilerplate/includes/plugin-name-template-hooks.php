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

?>