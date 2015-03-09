<?php
/**
 * Plugin Name Settings Page
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Settings_Page' ) ) {

/**
 * Plugin_Name_Settings_Page
 */
class Plugin_Name_Settings_Page {

	protected $id    = '';
	protected $label = '';

	/**
	 * Add this page to settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $pages
	 * @return array $pages
	 */
	public function add_settings_page( $pages ) {
		$pages[ $this->id ] = $this->label;

		return $pages;
	} // END add_settings_page()

	/**
	 * Add this settings page to plugin menu.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $pages
	 * @return array $pages
	 */
	public function add_menu_page( $pages ) {
		$pages[ $this->id ] = $this->label;

		return $pages;
	} // END add_menu_page()

	/**
	 * Get settings array
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_settings() {
		return array();
	} // END get_settings()

	/**
	 * Get sections
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_sections() {
		return array();
	} // END get_section()

	/**
	 * Output sections
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $current_section
	 */
	public function output_sections() {
		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) )
			return;

		$output = '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			$output .= '<li><a href="';

			$section_link = admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) );

			// If this section is default then remove the variable from this link.
			if( $id == '' ) {
				$section_link = remove_query_arg( 'section', $section_link );
			}

			$output .= $section_link;

			$output .= '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		$output .= '</ul><br class="clear" />';
		echo $output;
	} // END output_sections()

	/**
	 * Output the settings.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function output() {
		$settings = $this->get_settings();

		Plugin_Name_Admin_Settings::output_fields( $settings );
	} // END output()

	/**
	 * Save settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $current_tab
	 * @global $current_section
	 */
	public function save() {
		global $current_tab, $current_section;

		$settings = $this->get_settings();

		Plugin_Name_Admin_Settings::save_fields( $settings, $current_tab, $current_section );

		if ( $current_section ) {
			do_action( 'plugin_name_update_options_' . $this->id . '_' . $current_section );
		}
	} // END save()

} // END class

} // END if class exists.

?>
