<?php
/**
 * Setup menus in the WordPress admin.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Menus' ) ) {

/**
 * Class - Plugin_Name_Admin_Menus
 *
 * @since 1.0.0
 */
class Plugin_Name_Admin_Menus {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		// Add admin menus
		add_action( 'admin_menu',        array( $this, 'admin_menu' ), 9 );
		// Add menu seperator
		add_action( 'admin_init',        array( $this, 'add_admin_menu_separator' ) );
		// Add menu order and highlighter
		add_action( 'admin_head',        array( $this, 'menu_highlight' ) );
		add_filter( 'menu_order',        array( $this, 'menu_order' ) );
		//add_filter( 'parent_file',     array( $this, 'menu_parent_file' ) );
		add_filter( 'custom_menu_order', array( $this, 'custom_menu_order' ) );
	} // END __construct()

	/**
	 * Add menu seperator
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $position
	 * @global $menu
	 */
	public function add_admin_menu_separator( $position ) {
		global $menu;

		if ( current_user_can( Plugin_Name()->manage_plugin ) ) {
			$menu[ $position ] = array(
				0	=> '',
				1	=> 'read',
				2	=> 'separator' . $position,
				3	=> '',
				4	=> 'wp-menu-separator plugin-name'
			);
		}
	} // END add_admin_menu_separator()

	/**
	 * Add menu items.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $menu
	 * @global $plugin_name
	 * @global $wp_version
	 */
	public function admin_menu() {
		global $menu, $plugin_name, $wp_version;

		if ( current_user_can( Plugin_Name()->manage_plugin ) ) {
			$menu[] = array( '', 'read', 'separator-plugin-name', '', 'wp-menu-separator plugin-name' );
		}

		add_menu_page( Plugin_Name()->title_name, Plugin_Name()->menu_name, Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE, array( $this, 'plugin_name_page' ), null, '25.5' );

		$settings_menu = isset( Plugin_Name()->full_settings_menu ) ? Plugin_Name()->full_settings_menu : '';

		if ( $settings_menu == '' || $settings_menu == 'no' ) {
			$settings_page = add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Settings', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), __( 'Settings', PLUGIN_NAME_TEXT_DOMAIN ) , Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-settings', array( $this, 'settings_page' ) );
		}
		else{
			// Load the main settings page.
			$settings_page = add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Settings', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), __( 'Settings', PLUGIN_NAME_TEXT_DOMAIN ) , Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-settings', array( $this, 'settings_page' ) );

			// List the menu name and slug for each tab to have it's own settings shortcut.
			$settings_submenus = apply_filters( 'plugin_name_settings_submenu_array', array(
				array(
					'menu_name' => __( 'First Tab', PLUGIN_NAME_TEXT_DOMAIN ),
					'menu_slug' => 'tab_one',
				),
				array(
					'menu_name' => __( 'Second Tab', PLUGIN_NAME_TEXT_DOMAIN ),
					'menu_slug' => 'tab_two',
				)
			) );

			// Each settings tab will create a submenu under the plugin menu.
			foreach ( $settings_submenus as $tab ) {
				$settings_page .= add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Settings', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), $tab['menu_name'], Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-settings&tab=' . $tab['menu_slug'], array( $this, 'settings_page' ) );
			}
		}

		add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Status', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), __( 'System Status', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-status', array( $this, 'status_page' ) );

		add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Tools', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), __( 'Tools', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-status&tab=tools', array( $this, 'status_page' ) );

		//add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Import', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), __( 'Import', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-status&tab=import', array( &$this, 'port_page' ) );

		//add_submenu_page( PLUGIN_NAME_PAGE, sprintf( __( '%s Export', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->title_name ), __( 'Export', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->manage_plugin, PLUGIN_NAME_PAGE . '-status&tab=export', array( &$this, 'port_page' ) );

		register_setting( 'plugin_name_status_settings_fields', 'plugin_name_status_options' );
	} // END admin_menu()

	/**
	 * Highlights the correct top level admin menu item.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $submenu
	 * @global $parent_file
	 * @global $submenu_file
	 * @global $self
	 * @return void
	 */
	public function menu_highlight() {
		global $submenu, $parent_file, $submenu_file, $self;

		$to_highlight_types = array( 'tools', 'import', 'export' );

		if ( isset( $_GET['tab'] ) ) {
			if ( in_array( $_GET['tab'], $to_highlight_types ) ) {
				$submenu_file = 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings&tab=' . esc_attr( $_GET['tab'] );
				$parent_file  = PLUGIN_NAME_PAGE;
			}
		}

		/*if ( isset( $submenu['plugin-name'] ) && isset( $submenu['plugin-name'][1] ) ) {
			$submenu['plugin-name'][0] = $submenu['plugin-name'][1];
			unset( $submenu['plugin-name'][1] );
		}*/
	} // END menu_highlight()

	/**
	 * Reorder the plugin menu items in admin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $menu_order
	 * @return array
	 */
	public function menu_order( $menu_order ) {
		// Initialize our custom order array
		$plugin_name_menu_order = array();

		// Get the index of our custom separator
		$plugin_name_separator = array_search( 'separator-plugin-name', $menu_order );

		// Loop through menu order and do some rearranging
		foreach ( $menu_order as $index => $item ) {

			if ( ( ( str_replace( '_', '-', PLUGIN_NAME_SLUG ) ) == $item ) ) {
				$plugin_name_menu_order[] = 'separator-' . str_replace( '_', '-', PLUGIN_NAME_SLUG );
				$plugin_name_menu_order[] = $item;
				$plugin_name_menu_order[] = 'admin.php?page=' . PLUGIN_NAME_PAGE;
				unset( $menu_order[$plugin_name_separator] );
			}
			elseif ( !in_array( $item, array( 'separator-' . str_replace( '_', '-', PLUGIN_NAME_SLUG ) ) ) ) {
				$plugin_name_menu_order[] = $item;
			}

		}

		// Return menu order
		return $plugin_name_menu_order;
	} // END menu_order()

	/**
	 *
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $parent_file
	 * @global $current_screen
	 * @global $pagenow
	 * @global $submenu_file
	 */
	public function menu_parent_file( $parent_file ) {
		global $current_screen, $pagenow, $submenu_file;

		switch( $pagenow ) {
			case 'admin.php':
				if( isset( $_GET['tab'] ) ) {
					if( $_GET['tab'] == 'tools' ) {
						$parent_file = 'admin.php?page=' . PLUGIN_NAME_SLUG . '&tab=tools';
					}
				}
				break;
			default:
				$parent_file = $parent_file;
				break;
		}

		return $parent_file;
	} // END menu_parent_file()

	/**
	 * Sets the menu order depending on user access.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function custom_menu_order() {
		if ( ! current_user_can( Plugin_Name()->manage_plugin ) ) {
			return false;
		}
		return true;
	} // END custom_menu_order()

	/**
	 * Initialize the Plugin Name main page.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function plugin_name_page() {
		include_once( 'class-plugin-name-admin-page.php' );
		Plugin_Name_Admin_Page::output();
	} // END plugin_name_page()

	/**
	 * Initialize the Plugin Name settings page.
	 * @since  1.0.0
	 * @access public
	 */
	public function settings_page() {
		include_once( 'class-plugin-name-admin-settings.php' );
		Plugin_Name_Admin_Settings::output();
	}

	/**
	 * Initialize the Plugin Name status page.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function status_page() {
		include_once( 'class-plugin-name-admin-status.php' );
		Plugin_Name_Admin_Status::output();
	} // END status_page()

	/**
	 * Initialize the Plugin Name import and export page.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function port_page() {
		include_once( 'class-plugin-name-admin-import-export.php' );
		Plugin_Name_Admin_Import_Export::output();
	} // END port_page()

} // END Plugin_Name_Admin_Menus class.

} // END if class exists.

return new Plugin_Name_Admin_Menus();

?>
