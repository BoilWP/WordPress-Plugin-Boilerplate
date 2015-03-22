<?php
/**
 * Plugin Name Page Functions
 *
 * @todo     Add functions that are related to pages and menus for example.
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  Plugin Name/Functions
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Output generator to aid debugging.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function generator() {
	echo "\n\n" . '<!-- ' . Plugin_Name()->name . ' Version -->' . "\n" . '<meta name="generator" content="' . esc_attr( Plugin_Name()->name ) .' ' . esc_attr( Plugin_Name()->version ) . '" />' . "\n\n";
} // END generator()

?>
