<?php
/**
 * Plugin Name Template Hooks
 *
 * Action/filter hooks used for Plugin Name functions/templates
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Adds a generator tag in the header.
add_action( 'wp_head', 'generator' );

?>
