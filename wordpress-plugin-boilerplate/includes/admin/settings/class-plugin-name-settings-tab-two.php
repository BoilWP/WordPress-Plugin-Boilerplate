<?php
/**
 * Plugin Name Second Tab Settings
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Settings_Second_Tab' ) ) {

/**
 * Plugin_Name_Settings_Second_Tab
 */
class Plugin_Name_Settings_Second_Tab extends Plugin_Name_Settings_Page {

	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->id    = 'tab_two';
		$this->label = __( 'Second Tab', PLUGIN_NAME_TEXT_DOMAIN );

		add_filter( 'plugin_name_settings_submenu_array',           array( $this, 'add_menu_page' ),     20 );
		add_filter( 'plugin_name_settings_tabs_array',              array( $this, 'add_settings_page' ), 20 );
		add_action( 'plugin_name_settings_' . $this->id,            array( $this, 'output' ) );
		add_action( 'plugin_name_settings_save_' . $this->id,       array( $this, 'save' ) );
		add_action( 'plugin_name_sections_' . $this->id,            array( $this, 'output_sections' ) );
		add_action( 'plugin_name_settings_start',                   array( $this, 'settings_top' ) );
		add_action( 'plugin_name_settings_start_tab_' . $this->id,  array( $this, 'settings_top_this_tab_only' ) );
		add_action( 'plugin_name_settings_finish',                  array( $this, 'settings_bottom' ) );
		add_action( 'plugin_name_settings_finish_tab_' . $this->id, array( $this, 'settings_bottom_this_tab_only' ) );
	} // END __construct()

	/**
	 * Get sections
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_sections() {
		$sections = array(
			''    => __( 'Section One', PLUGIN_NAME_TEXT_DOMAIN ),
			'two' => __( 'Section Two', PLUGIN_NAME_TEXT_DOMAIN )
		);

		return $sections;
	}

	/**
	 * Output the settings
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $current_section
	 */
	public function output() {
		global $current_section;

		$settings = $this->get_settings( $current_section );

 		Plugin_Name_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $current_tab
	 * @global $current_section
	 */
	public function save() {
		global $current_tab, $current_section;

		$settings = $this->get_settings( $current_section );

		Plugin_Name_Admin_Settings::save_fields( $settings, $current_tab, $current_section );
	}

	/**
	 * Get settings array
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $current_section
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {

		if ( $current_section == 'two' ) {

			return apply_filters( 'plugin_name_second_tab_settings_section_' . $current_section, array(

				array(
					'title' => __( 'Section Two Options', PLUGIN_NAME_TEXT_DOMAIN ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'section_two_options'
				),

				array(
					'title'    => __( 'Select Page', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => '<br/>' . sprintf( __( 'You can set a description here also.', PLUGIN_NAME_TEXT_DOMAIN ), admin_url( 'options-permalink.php' ) ),
					'id'       => 'plugin_name_select_single_page_id',
					'type'     => 'single_select_page',
					'default'  => '',
					'class'    => 'chosen_select_nostd',
					'css'      => 'min-width:300px;',
					'desc_tip' => __( 'You can select or search for a page.', PLUGIN_NAME_TEXT_DOMAIN ),
				),

				array(
					'title'    => __( 'Select', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'This example shows you options from an array().', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'       => 'plugin_name_select_array',
					'class'    => 'chosen_select',
					'css'      => 'min-width:300px;',
					'default'  => '',
					'type'     => 'select',
					'options'  => array(
						'yes'    => __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ),
						'no'     => __( 'No', PLUGIN_NAME_TEXT_DOMAIN ),
					),
					'desc_tip' =>  true,
				),

				array(
					'title'    => __( 'MultiSelect', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'This example shows you the ability to select multi options from an array().', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'       => 'plugin_name_multiselect_array',
					'class'    => 'chosen_select',
					'css'      => 'min-width:300px;',
					'default'  => '',
					'type'     => 'multiselect',
					'options'  => array(
						'yes'    => __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ),
						'no'     => __( 'No', PLUGIN_NAME_TEXT_DOMAIN ),
					),
					'desc_tip' =>  true,
				),

				array(
					'title'   => __( 'Checkbox', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'    => __( 'Checkbox option', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'      => 'plugin_name_checkbox',
					'default' => 'no',
					'type'    => 'checkbox'
				),

				array(
					'title'    => __( 'Radio', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'Radio option', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc_tip' => true,
					'id'       => 'plugin_name_radio',
					'default'  => '',
					'type'     => 'radio',
					'options'  => array(
 						'yes'    => __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ),
						'no'     => __( 'No', PLUGIN_NAME_TEXT_DOMAIN ),
					),
				),

				array(
					'title'             => __( 'Number', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'              => __( 'Use this field for numbered options.', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'                => 'plugin_name_number_option',
					'type'              => 'number',
					'custom_attributes' => array(
						'min'             => 0,
						'step'            => 1
					),
					'css'               => 'width:50px;',
					'default'           => '05',
					'autoload'          => false
				),

				array(
					'title'    => __( 'Color', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'Use this field for color picking.', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'       => 'plugin_name_color_option',
					'type'     => 'color',
					'css'      => 'width:70px;',
					'default'  => '#ffffff',
					'autoload' => false
				),

				array(
					'title'         => __( 'Group Checkboxes', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'          => __( 'Checkbox One', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'            => 'plugin_name_group_checkbox_option_one',
					'default'       => 'yes',
					'type'          => 'checkbox',
					'checkboxgroup' => 'start',
					'autoload'      => false
				),

				array(
					'desc'          => __( 'Checkbox Two', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'            => 'plugin_name_group_checkbox_option_two',
					'default'       => 'yes',
					'type'          => 'checkbox',
					'checkboxgroup' => 'end',
					'autoload'      => false
				),

				array(
					'title'    => __( 'Email', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => 'Use this field option to be used for entering an email address only. (HTML 5 Field)',
					'id'       => 'plugin_name_email_option',
					'type'     => 'email',
					'default'  => get_option( 'admin_email' ),
					'autoload' => false
				),

				array(
					'title'    => __( 'Password', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => 'Use this field option to be used for entering a password.',
					'id'       => 'plugin_name_password_option',
					'type'     => 'password',
					'default'  => '',
					'autoload' => false
				),

				array(
					'title'    => __( 'Image Size', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'Use this field option to save multiple settings for an image size', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'       => 'plugin_name_image_size_option',
					'css'      => '',
					'type'     => 'image_width',
					'default'  => array(
						'width'  => '150',
						'height' => '150',
						'crop'   => false
					),
					'desc_tip' => true,
				),

				array( 'type' => 'sectionend', 'id' => 'section_two_options'),

			));

		} else {

			return apply_filters( 'plugin_name_second_tab_settings', array(

				array(
					'title' => __( 'Section One Options', PLUGIN_NAME_TEXT_DOMAIN ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'section_one_options'
				),

				array(
					'title'    => __( 'Select Page', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => '<br/>' . sprintf( __( 'You can set a description here also.', PLUGIN_NAME_TEXT_DOMAIN ), admin_url( 'options-permalink.php' ) ),
					'id'       => 'plugin_name_select_single_page_id',
					'type'     => 'single_select_page',
					'default'  => '',
					'class'    => 'chosen_select_nostd',
					'css'      => 'min-width:300px;',
					'desc_tip' => __( 'You can select or search for a page.', PLUGIN_NAME_TEXT_DOMAIN ),
				),

				array(
					'title'    => __( 'Select', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'This example shows you options from an array().', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'       => 'plugin_name_select_array',
					'class'    => 'chosen_select',
					'css'      => 'min-width:300px;',
					'default'  => '',
					'type'     => 'select',
					'options'  => array(
						'yes'    => __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ),
						'no'     => __( 'No', PLUGIN_NAME_TEXT_DOMAIN ),
					),
					'desc_tip' =>  true,
				),

				array(
					'title'    => __( 'MultiSelect', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'     => __( 'This example shows you the ability to select multi options from an array().', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'       => 'plugin_name_multiselect_array',
					'class'    => 'chosen_select',
					'css'      => 'min-width:300px;',
					'default'  => '',
					'type'     => 'multiselect',
					'options'  => array(
						'yes'    => __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ),
						'no'     => __( 'No', PLUGIN_NAME_TEXT_DOMAIN ),
					),
					'desc_tip' =>  true,
				),

				array(
					'title'   => __( 'Checkbox', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc'    => __( 'Checkbox option', PLUGIN_NAME_TEXT_DOMAIN ),
					'id'      => 'plugin_name_checkbox',
					'default' => 'no',
					'type'    => 'checkbox'
				),

				array(
					'title' 	=> __( 'Radio', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 		=> __( 'Radio option', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc_tip' 	=> true,
					'id' 		=> 'plugin_name_radio',
					'default'	=> '',
					'type' 		=> 'radio',
					'options' => array(
									'yes' => __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ),
									'no' => __( 'No', PLUGIN_NAME_TEXT_DOMAIN ),
					),
				),

				array(
					'title' 	=> __( 'Number', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 		=> __( 'Use this field for numbered options.', PLUGIN_NAME_TEXT_DOMAIN ),
					'id' 		=> 'plugin_name_number_option',
					'type' 		=> 'number',
					'custom_attributes' => array(
						'min' 	=> 0,
						'step' 	=> 1
					),
					'css' 		=> 'width:50px;',
					'default'	=> '05',
					'autoload' 	=> false
				),

				array(
					'title' 	=> __( 'Color', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 		=> __( 'Use this field for color picking.', PLUGIN_NAME_TEXT_DOMAIN ),
					'id' 		=> 'plugin_name_color_option',
					'type' 		=> 'color',
					'css' 		=> 'width:70px;',
					'default'	=> '#ffffff',
					'autoload' 	=> false
				),

				array(
					'title' 		=> __( 'Group Checkboxes', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 			=> __( 'Checkbox One', PLUGIN_NAME_TEXT_DOMAIN ),
					'id' 			=> 'plugin_name_group_checkbox_option_one',
					'default'		=> 'yes',
					'type' 			=> 'checkbox',
					'checkboxgroup' => 'start',
					'autoload' 		=> false
				),

				array(
					'desc' 			=> __( 'Checkbox Two', PLUGIN_NAME_TEXT_DOMAIN ),
					'id' 			=> 'plugin_name_group_checkbox_option_two',
					'default'		=> 'yes',
					'type' 			=> 'checkbox',
					'checkboxgroup' => 'end',
					'autoload' 		=> false
				),

				array(
					'title' 		=> __( 'Email', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 			=> 'Use this field option to be used for entering an email address only. (HTML 5 Field)',
					'id' 			=> 'plugin_name_email_option',
					'type' 			=> 'email',
					'default'		=> get_option( 'admin_email' ),
					'autoload' 		=> false
				),

				array(
					'title' 		=> __( 'Password', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 			=> 'Use this field option to be used for entering a password.',
					'id' 			=> 'plugin_name_password_option',
					'type' 			=> 'password',
					'default'		=> '',
					'autoload' 		=> false
				),

				array(
					'title' 		=> __( 'Image Size', PLUGIN_NAME_TEXT_DOMAIN ),
					'desc' 			=> __( 'Use this field option to save multiple settings for an image size', PLUGIN_NAME_TEXT_DOMAIN ),
					'id' 			=> 'plugin_name_image_size_option',
					'css' 			=> '',
					'type' 			=> 'image_width',
					'default'		=> array(
						'width' 		=> '150',
						'height'		=> '150',
						'crop'			=> false
					),
					'desc_tip' 		=> true,
				),

				array( 'type' => 'sectionend', 'id' => 'section_one_options'),

			));
		}
	}
}

} // end if class exists

return new Plugin_Name_Settings_Second_Tab();

?>
