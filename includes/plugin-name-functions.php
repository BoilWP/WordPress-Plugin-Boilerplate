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
 * Hide menu items conditionally
 *
 * @param array $items
 * @param mixed $args
 * @return array
 */
function plugin_name_nav_menu_items( $items, $args ) {
	if ( ! is_user_logged_in() ) {

		$hide_pages 	= array();
		$hide_pages[] 	= (int) plugin_name_get_page_id( 'sample-page' );
		$hide_pages 	= apply_filters( 'plugin_name_logged_out_hidden_page_ids', $hide_pages );

		foreach ( $items as $key => $item ) {
			if ( strstr( $item->url, 'logout' ) )
				unset( $items[ $key ] );
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'plugin_name_nav_menu_items', 10, 2 );

?>