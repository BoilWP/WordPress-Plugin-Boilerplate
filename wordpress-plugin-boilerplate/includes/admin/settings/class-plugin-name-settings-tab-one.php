<?php
/**
 * Plugin Name First Tab Settings
 *
 * @author 		Your Name / Your Company Name
 * @category 	Admin
 * @package 	Plugin Name/Admin
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Settings_First_Tab' ) ) {

/**
 * Plugin_Name_Admin_Settings_First_Tab
 */
class Plugin_Name_Settings_First_Tab extends Plugin_Name_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id 		= 'tab_one';
		$this->label 	= __( 'First Tab', PLUGIN_NAME_TEXT_DOMAIN );

		add_filter( 'plugin_name_settings_submenu_array', array( &$this, 'add_menu_page' ), 20 );
		add_filter( 'plugin_name_settings_tabs_array', array( &$this, 'add_settings_page' ), 20 );
		add_action( 'plugin_name_settings_' . $this->id, array( &$this, 'output' ) );
		add_action( 'plugin_name_settings_save_' . $this->id, array( &$this, 'save' ) );
	}

	/**
	 * Save settings
	 */
	public function save() {
		global $current_tab;

		$settings = $this->get_settings();

		Plugin_Name_Admin_Settings::save_fields( $settings, $current_tab );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		return apply_filters( 'plugin_name_' . $this->id . '_settings', array(

			array(
				'title' 	=> __( 'Settings Title', PLUGIN_NAME_TEXT_DOMAIN ), 
				'type' 		=> 'title', 
				'desc' 		=> '', 
				'id' 		=> $this->id . '_options'
			),

			array(
				'title' 	=> __( 'Subscriber Access', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> __( 'Prevent users from accessing WordPress admin.', PLUGIN_NAME_TEXT_DOMAIN ),
				'id' 		=> 'plugin_name_lock_down_admin',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),

			array(
				'title' 	=> __( 'Secure Content', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> __( 'Keep your site secure by forcing SSL (HTTPS) on site (an SSL Certificate is required).', PLUGIN_NAME_TEXT_DOMAIN ),
				'id' 		=> 'plugin_name_force_ssl',
				'default'	=> 'no',
				'type' 		=> 'checkbox'
			),

			array(
				'title' 	=> __( 'Select Country', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> __( 'This gives you a list of countries. ', PLUGIN_NAME_TEXT_DOMAIN ),
				'id' 		=> 'plugin_name_country_list',
				'css' 		=> 'min-width:350px;',
				'default'	=> 'GB',
				'type' 		=> 'single_select_country',
				'desc_tip'	=> true,
			),

			array(
				'title' 	=> __( 'Multi Select Countries', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> '',
				'id' 		=> 'plugin_name_multi_countries',
				'css' 		=> 'min-width: 350px;',
				'default'	=> '',
				'type' 		=> 'multi_select_countries'
			),

			array(
				'title' 	=> __( 'Example Page', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> __( 'You can set pages that the plugin requires by having them installed and selected automatically when the plugin is installed.', PLUGIN_NAME_TEXT_DOMAIN ),
				'id' 		=> 'plugin_name_example_page_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'class'		=> 'chosen_select_nostd',
				'css' 		=> 'min-width:300px;',
				'desc_tip'	=> true,
			),

			array(
				'title' 	=> __( 'Shortcode Example Page', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> __( 'This page has a shortcode applied when created by the plugin.', PLUGIN_NAME_TEXT_DOMAIN ),
				'id' 		=> 'plugin_name_shortcode_page_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'class'		=> 'chosen_select_nostd',
				'css' 		=> 'min-width:300px;',
				'desc_tip'	=> true,
			),

			array(
				'title' 	=> __( 'Single Checkbox', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> __( 'Can come in handy to display more options.', PLUGIN_NAME_TEXT_DOMAIN ),
				'id' 		=> 'plugin_name_checkbox',
				'default'	=> 'no',
				'type' 		=> 'checkbox'
			),

			array(
				'title' 	=> __( 'Single Input (Text) ', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> '',
				'id' 		=> 'plugin_name_input_text',
				'default'	=> __( 'This admin setting can be hidden via the checkbox above.', PLUGIN_NAME_TEXT_DOMAIN ),
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'autoload' 	=> false
			),

			array(
				'title' 	=> __( 'Single Textarea ', PLUGIN_NAME_TEXT_DOMAIN ),
				'desc' 		=> '',
				'id' 		=> 'plugin_name_input_textarea',
				'default'	=> __( 'You can allow the user to use this field to enter their own CSS or HTML code.', PLUGIN_NAME_TEXT_DOMAIN ),
				'type' 		=> 'textarea',
				'css' 		=> 'min-width:300px;',
				'autoload' 	=> false
			),

			array( 'type' => 'sectionend', 'id' => $this->id . '_options'),

		)); // End general settings
	}

}

} // end if class exists

return new Plugin_Name_Settings_First_Tab();

?>