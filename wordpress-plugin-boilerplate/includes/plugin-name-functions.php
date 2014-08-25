<?php
/**
 * Plugin Name Page Functions
 *
 * Functions related to pages and menus.
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Functions
 * @version 	1.0.0
 */

/**
 * Output generator to aid debugging.
 *
 * @since 1.0.0
 * @return void
 */
function generator() {
	echo "\n\n" . '<!-- ' . Plugin_Name()->name . ' Version -->' . "\n" . '<meta name="generator" content="' . esc_attr( Plugin_Name()->name ) .' ' . esc_attr( Plugin_Name()->version ) . '" />' . "\n\n";
}

?>