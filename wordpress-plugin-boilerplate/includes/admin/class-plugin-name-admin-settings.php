<?php
/**
 * Plugin Name Admin Settings Class.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Settings' ) ) {

/**
 * Plugin_Name_Admin_Settings
 *
 * @since 1.0.0
 */
class Plugin_Name_Admin_Settings {

	private static $settings = array();
	private static $errors   = array();
	private static $messages = array();

	/**
	 * Constructor
	 *
	 * @since  1.0.2
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'plugin_name_settings_start',  array( $this, 'settings_top' ),    10, 2 );
		add_action( 'plugin_name_settings_finish', array( $this, 'settings_bottom' ), 10, 2 );
	} // END __construct()

	/**
	 * Include the settings page classes
	 *
	 * @since  1.0.0
	 * @access public static
	 * @filter plugin_name_get_settings_pages
	 * @return $settings
	 */
	public static function get_settings_pages() {
		if ( empty( self::$settings ) ) {
			$settings = array();

			include_once( 'settings/class-plugin-name-settings-page.php' );

			$settings[] = include( 'settings/class-plugin-name-settings-tab-one.php' );
			$settings[] = include( 'settings/class-plugin-name-settings-tab-two.php' );

			self::$settings = apply_filters( 'plugin_name_get_settings_pages', $settings );
		}
		return self::$settings;
	} // END get_settings_page()

	/**
	 * Save the settings
	 *
	 * @since  1.0.0
	 * @access public static
	 * @global $current_section
	 * @global $current_tab
	 */
	public static function save() {
		global $current_section, $current_tab;

		if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'plugin-name-settings' ) ) {
			die( __( 'Action failed. Please refresh the page and retry.', PLUGIN_NAME_TEXT_DOMAIN ) );
		}

		// Trigger actions
		do_action( 'plugin_name_settings_save_' . $current_tab );
		do_action( 'plugin_name_update_options_' . $current_tab );
		do_action( 'plugin_name_update_options' );

		self::add_message( __( 'Your settings have been saved.', PLUGIN_NAME_TEXT_DOMAIN ) );

		do_action( 'plugin_name_settings_saved' );
	} // END save()

	/**
	 * Add a message
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param  string $text
	 */
	public static function add_message( $text ) {
		self::$messages[] = $text;
	} // END add_message()

	/**
	 * Add an error
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param  string $text
	 */
	public static function add_error( $text ) {
		self::$errors[] = $text;
	} // END add_error()

	/**
	 * Output messages and errors.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @return string
	 */
	public static function show_messages() {
		if ( sizeof( self::$errors ) > 0 ) {
			foreach ( self::$errors as $error ) {
				echo '<div id="message" class="error plugin-name fade"><p><strong>' . esc_html( $error ) . '</strong></p></div>';
			}
		}
		elseif ( sizeof( self::$messages ) > 0 ) {
			foreach ( self::$messages as $message ) {
				echo '<div id="message" class="updated plugin-name fade"><p><strong>' . esc_html( $message ) . '</strong></p></div>';
			}
		}
	} // END show_messages()

	/**
	 * Settings Top.
	 *
	 * Display what you would like at the
	 * top of the settings page.
	 *
	 * @since  1.0.2
	 * @access public
	 * @param  string $current_tab
	 * @param  string $current_section
	 */
	public function settings_top( $current_tab, $current_section ) {
		// Use this action for displaying on a single tab.
		do_action( 'plugin_name_settings_top_' . $current_tab );
		// Use this action for displaying on a single section, under a single tab.
		do_action( 'plugin_name_settings_top_' . $current_tab . '_' . $current_section );
	}

	/**
	 * Settings Bottom.
	 *
	 * Display what you would like at the
	 * bottom of the settings page.
	 *
	 * @since  1.0.2
	 * @access public
	 * @param  string $current_tab
	 * @param  string $current_section
	 */
	public function settings_bottom( $current_tab, $current_section ) {
		// Use this action for displaying on a single tab.
		do_action( 'plugin_name_settings_bottom_' . $current_tab );
		// Use this action for displaying on a single section, under a single tab.
		do_action( 'plugin_name_settings_bottom_' . $current_tab . '_' . $current_section );
	}

	/**
	 * Settings Page.
	 *
	 * Handles the display of the main settings page in admin.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @filter plugin_name_settings_params
	 * @filter plugin_name_settings_tabs_array
	 * @global $current_section
	 * @global $current_tab
	 * @return void
	 */
	public static function output() {
		global $current_section, $current_tab;

		// Get current tab or section
		$current_tab     = empty( $_GET['tab'] ) ? PLUGIN_NAME_DEFAULT_SETTINGS_TAB : sanitize_text_field( urldecode( $_GET['tab'] ) );
		$current_section = empty( $_REQUEST['section'] ) ? '' : sanitize_text_field( urldecode( $_REQUEST['section'] ) );

		do_action( 'plugin_name_settings_start', $current_tab, $current_section );

		wp_enqueue_script( 'plugin_name_settings', Plugin_Name()->plugin_url() . '/assets/js/admin/settings' . PLUGIN_NAME_SCRIPT_MODE . '.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable', 'iris' ), Plugin_Name()->version, true );

		wp_localize_script( 'plugin_name_settings', 'plugin_name_settings_params', apply_filters( 'plugin_name_settings_params', array(
			'i18n_nav_warning' => __( 'The changes you made will be lost if you navigate away from this page.', PLUGIN_NAME_TEXT_DOMAIN ),
		) ) );

		// Include settings pages
		self::get_settings_pages();

		// Save settings if data has been posted
		if ( ! empty( $_POST ) ) {
			self::save();
		}

		// Add any posted messages
		if ( ! empty( $_GET['plugin_name_error'] ) ) {
			self::add_error( urldecode( stripslashes( $_GET['plugin_name_error'] ) ) );
		}

		if ( ! empty( $_GET['plugin_name_message'] ) ) {
			self::add_message( urldecode( stripslashes( $_GET['plugin_name_message'] ) ) );
		}

		self::show_messages();

		// Get tabs for the settings page
		$tabs = apply_filters( 'plugin_name_settings_tabs_array', array() );

		include( 'views/html-admin-settings.php' );

		// This action hook was added in version 1.0.2
		do_action( 'plugin_name_settings_finish', $current_tab, $current_section );
	} // END output()

	/**
	 * Get a setting from the settings API.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param  mixed $option
	 * @return string
	 */
	public static function get_option( $option_name, $default = '' ) {
		// Array value
		if ( strstr( $option_name, '[' ) ) {

			parse_str( $option_name, $option_array );

			// Option name is first key
			$option_name = current( array_keys( $option_array ) );

			// Get value
			$option_values = get_option( $option_name, '' );

			$key = key( $option_array[ $option_name ] );

			if ( isset( $option_values[ $key ] ) ) {
				$option_value = $option_values[ $key ];
			}
			else {
				$option_value = null;
			}

		// Single value
		} else {
			$option_value = get_option( $option_name, null );
		}

		if ( is_array( $option_value ) ) {
			$option_value = array_map( 'stripslashes', $option_value );
		}
		elseif ( ! is_null( $option_value ) ) {
			$option_value = stripslashes( $option_value );
		}

		return $option_value === null ? $default : $option_value;
	} // END get_option()

	/**
	 * Output admin fields.
	 *
	 * Loops though the plugin name options array and outputs each field.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param  array $options Opens array to output
	 */
	public static function output_fields( $options ) {
		foreach ( $options as $value ) {
			if ( ! isset( $value['type'] ) ) continue;
			if ( ! isset( $value['id'] ) ) $value['id'] = '';
			if ( ! isset( $value['title'] ) ) $value['title'] = isset( $value['name'] ) ? $value['name'] : '';
			if ( ! isset( $value['class'] ) ) $value['class'] = '';
			if ( ! isset( $value['css'] ) ) $value['css'] = '';
			if ( ! isset( $value['default'] ) ) $value['default'] = '';
			if ( ! isset( $value['desc'] ) ) $value['desc'] = '';
			if ( ! isset( $value['desc_tip'] ) ) $value['desc_tip'] = false;

			// Custom attribute handling
			$custom_attributes = array();

			if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
				foreach ( $value['custom_attributes'] as $attribute => $attribute_value ) {
					$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
				}
			}

			// Description handling
			if ( $value['desc_tip'] === true ) {
				$description = '';
				$tip = $value['desc'];
			}
			else if ( ! empty( $value['desc_tip'] ) ) {
				$description = $value['desc'];
				$tip = $value['desc_tip'];
			}
			else if ( ! empty( $value['desc'] ) ) {
				$description = $value['desc'];
				$tip = '';
			}
			else {
				$description = $tip = '';
			}

			if ( $description && in_array( $value['type'], array( 'textarea', 'radio' ) ) ) {
				$description = '<p style="margin-top:0">' . wp_kses_post( $description ) . '</p>';
			}
			else if ( $description ) {
				$description = '<span class="description">' . wp_kses_post( $description ) . '</span>';
			}

			if ( $tip && in_array( $value['type'], array( 'checkbox' ) ) ) {
				$tip = '<p class="description">' . $tip . '</p>';
			}
			else if ( $tip ) {
				$tip = '<img class="help_tip" data-tip="' . esc_attr( $tip ) . '" src="' . Plugin_Name()->plugin_url() . '/assets/images/help.png" height="16" width="16" />';
			}

			// Switch based on type
			switch( $value['type'] ) {
				// Section Titles
				case 'title':
					if ( ! empty( $value['title'] ) ) {
						echo '<h3>' . esc_html( $value['title'] ) . '</h3>';
					}

					if ( ! empty( $value['desc'] ) ) {
						echo wpautop( wptexturize( wp_kses_post( $value['desc'] ) ) );
					}

					echo '<table class="form-table">'. "\n\n";

					if ( ! empty( $value['id'] ) ) {
						do_action( 'plugin_name_settings_' . sanitize_title( $value['id'] ) );
					}
					break;

				// Section Ends
				case 'sectionend':
					if ( ! empty( $value['id'] ) ) {
						do_action( 'plugin_name_settings_' . sanitize_title( $value['id'] ) . '_end' );
					}
					echo '</table>';
					if ( ! empty( $value['id'] ) ) {
						do_action( 'plugin_name_settings_' . sanitize_title( $value['id'] ) . '_after' );
					}
					break;

				// Standard text inputs and subtypes like 'number'
				case 'text':
				case 'email':
				case 'number':
				case 'color':
				case 'password':
					$type         = $value['type'];
					$class        = '';
					$option_value = self::get_option( $value['id'], $value['default'] );

					if ( $value['type'] == 'color' ) {
						$type = 'text';
						$value['class'] .= 'colorpick';
						$description .= '<div id="colorPickerDiv_' . esc_attr( $value['id'] ) . '" class="colorpickdiv" style="z-index:100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>';
					}

					?><tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
							<?php echo $tip; ?>
						</th>
						<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ); ?>">
							<input
								name="<?php echo esc_attr( $value['id'] ); ?>"
								id="<?php echo esc_attr( $value['id'] ); ?>"
								type="<?php echo esc_attr( $type ); ?>"
								style="<?php echo esc_attr( $value['css'] ); ?>"
								value="<?php echo esc_attr( $option_value ); ?>"
								class="<?php echo esc_attr( $value['class'] ); ?>"
								<?php echo implode( ' ', $custom_attributes ); ?>
							/> <?php echo $description; ?>
						</td>
					</tr><?php
					break;

				// Textarea
				case 'textarea':
					$option_value = self::get_option( $value['id'], $value['default'] );
					?><tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
							<?php echo $tip; ?>
						</th>
						<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ); ?>">
						<?php echo $description; ?>

						<textarea
								name="<?php echo esc_attr( $value['id'] ); ?>"
								id="<?php echo esc_attr( $value['id'] ); ?>"
								style="<?php echo esc_attr( $value['css'] ); ?>"
								class="<?php echo esc_attr( $value['class'] ); ?>"
								<?php echo implode( ' ', $custom_attributes ); ?>
								><?php echo esc_textarea( $option_value );  ?></textarea>
						</td>
					</tr><?php
					break;

				// Select boxes
				case 'select':
				case 'multiselect':
					$option_value = self::get_option( $value['id'], $value['default'] );
					?><tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
							<?php echo $tip; ?>
						</th>
						<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ); ?>">
						<select
								name="<?php echo esc_attr( $value['id'] ); ?><?php if ( $value['type'] == 'multiselect' ) echo '[]'; ?>"
								id="<?php echo esc_attr( $value['id'] ); ?>"
								style="<?php echo esc_attr( $value['css'] ); ?>"
								class="<?php echo esc_attr( $value['class'] ); ?>"
								<?php echo implode( ' ', $custom_attributes ); ?>
								<?php if ( $value['type'] == 'multiselect' ) echo 'multiple="multiple"'; ?>>

								<?php foreach ( $value['options'] as $key => $val ) { ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php
											if ( is_array( $option_value ) ) {
												selected( in_array( $key, $option_value ), true );
											}
											else {
												selected( $option_value, $key );
											}

										?>><?php echo $val ?></option>
										<?php
									}
								?>
							</select> <?php echo $description; ?>
						</td>
						</tr><?php
						break;

				// Radio inputs
				case 'radio':
					$option_value = self::get_option( $value['id'], $value['default'] );
					?><tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
							<?php echo $tip; ?>
						</th>
						<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ); ?>">
							<fieldset>
								<?php echo $description; ?>
							<ul>
							<?php foreach ( $value['options'] as $key => $val ) { ?>
								<li>
									<label><input
												name="<?php echo esc_attr( $value['id'] ); ?>"
												value="<?php echo $key; ?>"
												type="radio"
												style="<?php echo esc_attr( $value['css'] ); ?>"
												class="<?php echo esc_attr( $value['class'] ); ?>"
												<?php echo implode( ' ', $custom_attributes ); ?>
												<?php checked( $key, $option_value ); ?>
												/> <?php echo $val ?></label>
								</li>
							<?php } ?>
							</ul>
							</fieldset>
						</td>
					</tr><?php
					break;

				// Checkbox input
				case 'checkbox':
					$option_value = self::get_option( $value['id'], $value['default'] );

					if ( ! isset( $value['hide_if_checked'] ) ) $value['hide_if_checked'] = false;
					if ( ! isset( $value['show_if_checked'] ) ) $value['show_if_checked'] = false;

					if ( ! isset( $value['checkboxgroup'] ) || ( isset( $value['checkboxgroup'] ) && $value['checkboxgroup'] == 'start' ) ) {
					?>
						<tr valign="top" class="<?php
							if ( $value['hide_if_checked'] == 'yes' || $value['show_if_checked']=='yes') echo 'hidden_option';
							if ( $value['hide_if_checked'] == 'option' ) echo 'hide_options_if_checked';
							if ( $value['show_if_checked'] == 'option' ) echo 'show_options_if_checked';
						?>">
						<th scope="row" class="titledesc"><?php echo esc_html( $value['title'] ); ?></th>
						<td class="forminp forminp-checkbox">
							<fieldset>
						<?php
					}
					else {
						?>
						<fieldset class="<?php
							if ( $value['hide_if_checked'] == 'yes' || $value['show_if_checked'] == 'yes') echo 'hidden_option';
							if ( $value['hide_if_checked'] == 'option') echo 'hide_options_if_checked';
							if ( $value['show_if_checked'] == 'option') echo 'show_options_if_checked';
						?>">
					<?php
					}

					?>
						<legend class="screen-reader-text"><span><?php echo esc_html( $value['title'] ); ?></span></legend>

						<label for="<?php echo $value['id'] ?>">
						<input
							name="<?php echo esc_attr( $value['id'] ); ?>"
							id="<?php echo esc_attr( $value['id'] ); ?>"
							type="checkbox"
							value="1"
							<?php checked( $option_value, 'yes'); ?>
							<?php echo implode( ' ', $custom_attributes ); ?>
						/> <?php echo wp_kses_post( $value['desc'] ) ?></label> <?php echo $tip; ?>
					<?php
					if ( ! isset( $value['checkboxgroup'] ) || ( isset( $value['checkboxgroup'] ) && $value['checkboxgroup'] == 'end' ) ) {
						?>
							</fieldset>
						</td>
						</tr>
						<?php
					}
					else {
						?>
						</fieldset>
						<?php
					}
					break;

				// Image width settings
				case 'image_width':
					$width  = self::get_option( $value['id']['width'], $value['default']['width'] );
					$height = self::get_option( $value['id']['height'], $value['default']['height'] );
					$crop   = checked( 1, self::get_option( $value['id']['crop'], $value['default']['crop'] ), false );
					?><tr valign="top">
						<th scope="row" class="titledesc"><?php echo esc_html( $value['title'] ); ?> <?php echo $tip; ?></th>
						<td class="forminp image_width_settings">
							<input name="<?php echo esc_attr( $value['id'] ); ?>[width]" id="<?php echo esc_attr( $value['id'] ); ?>-width" type="text" size="3" value="<?php echo $width; ?>" /> &times; <input name="<?php echo esc_attr( $value['id'] ); ?>[height]" id="<?php echo esc_attr( $value['id'] ); ?>-height" type="text" size="3" value="<?php echo $height; ?>" />px
							<label><input name="<?php echo esc_attr( $value['id'] ); ?>[crop]" id="<?php echo esc_attr( $value['id'] ); ?>-crop" type="checkbox" <?php echo $crop; ?> /> <?php _e( 'Hard Crop?', PLUGIN_NAME_TEXT_DOMAIN ); ?></label>
						</td>
					</tr><?php
					break;

				// Single page selects
				case 'single_select_page':
					$args = array(
						'name'             => $value['id'],
						'id'               => $value['id'],
						'sort_column'      => 'menu_order',
						'sort_order'       => 'ASC',
						'show_option_none' => ' ',
						'class'            => $value['class'],
						'echo'             => false,
						'selected'         => absint( self::get_option( $value['id'] ) )
					);

					if ( isset( $value['args'] ) )
						$args = wp_parse_args( $value['args'], $args );
					?><tr valign="top" class="single_select_page">
						<th scope="row" class="titledesc"><?php echo esc_html( $value['title'] ); ?> <?php echo $tip; ?></th>
						<td class="forminp">
							<?php echo str_replace(' id=', " data-placeholder='" . __( 'Select a page&hellip;', PLUGIN_NAME_TEXT_DOMAIN ) .  "' style='" . $value['css'] . "' class='" . $value['class'] . "' id=", wp_dropdown_pages( $args ) ); ?> <?php echo $description; ?>
						</td>
					</tr><?php
					break;

				// Single country selects
				/*case 'single_select_country':
					$country_setting = (string) self::get_option( $value['id'] );
					$countries 		 = Plugin_Name()->countries->countries;

					if ( strstr( $country_setting, ':' ) ) {
						$country_setting 	= explode( ':', $country_setting );
						$country 			= current( $country_setting );
						$state 				= end( $country_setting );
					}
					else {
						$country 	= $country_setting;
						$state 		= '*';
					}
					?><tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
							<?php echo $tip; ?>
						</th>
						<td class="forminp"><select name="<?php echo esc_attr( $value['id'] ); ?>" style="<?php echo esc_attr( $value['css'] ); ?>" data-placeholder="<?php _e( 'Choose a country&hellip;', PLUGIN_NAME_TEXT_DOMAIN ); ?>" title="Country" class="chosen_select">
							<?php Plugin_Name()->countries->country_dropdown_options( $country, $state ); ?>
						</select> <?php echo $description; ?>
						</td>
					</tr><?php
					break;*/

				// Country multiselects
				/*case 'multi_select_countries':
					$selections = (array) self::get_option( $value['id'] );

					if ( ! empty( $value['options'] ) ) {
						$countries = $value['options'];
					}
					else {
						$countries = Plugin_Name()->countries->countries;
					}

					asort( $countries );
					?><tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
							<?php echo $tip; ?>
						</th>
						<td class="forminp">
							<select multiple="multiple" name="<?php echo esc_attr( $value['id'] ); ?>[]" style="width:350px" data-placeholder="<?php _e( 'Choose countries&hellip;', PLUGIN_NAME_TEXT_DOMAIN ); ?>" title="Country" class="chosen_select">
								<?php
								if ( $countries ) {
									foreach ( $countries as $key => $val ) {
										echo '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $selections ), true, false ).'>' . $val . '</option>';
									}
								}
								?>
							</select> <?php if ( $description ) { echo $description; } ?> </br><a class="select_all button" href="#"><?php _e( 'Select all', PLUGIN_NAME_TEXT_DOMAIN ); ?></a> <a class="select_none button" href="#"><?php _e( 'Select none', PLUGIN_NAME_TEXT_DOMAIN ); ?></a>
						</td>
					</tr><?php
					break;*/

				// Default: run an action
				default:
					do_action( 'plugin_name_admin_field_' . $value['type'], $value );
					break;
			} // end switch
		}
	} // END output_fields()

	/**
	 * Save admin fields.
	 *
	 * Loops though the plugin name options array and outputs each field.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param  array $options Opens array to output
	 * @return bool
	 */
	public static function save_fields( $options, $current_tab, $current_section = '' ) {
		if ( empty( $_POST ) )
			return false;

		// Options to update will be stored here
		$update_options = array();

		// Loop options and get values to save
		foreach ( $options as $value ) {

			if ( ! isset( $value['id'] ) )
				continue;

			$type = isset( $value['type'] ) ? sanitize_title( $value['type'] ) : '';

			// Get the option name
			$option_value = null;

			switch ( $type ) {

				// Standard types
				case "checkbox" :
					if ( isset( $_POST[ $value['id'] ] ) ) {
						$option_value = 'yes';
					}
					else {
						$option_value = 'no';
					}
				break;

				case "textarea" :
					if ( isset( $_POST[$value['id']] ) ) {
						$option_value = wp_kses_post( trim( stripslashes( $_POST[ $value['id'] ] ) ) );
					}
					else {
						$option_value = '';
					}
				break;

				case "text" :
				case "email":
				case "number":
				case "select" :
				case "color" :
				case "password" :
				case "single_select_page" :
				//case "single_select_country" :
				case "radio" :
					if ( isset( $_POST[$value['id']] ) ) {
						$option_value = plugin_name_clean( stripslashes( $_POST[ $value['id'] ] ) );
					}
					else {
						$option_value = '';
					}
				break;

				// Special types
				case "multiselect" :
				//case "multi_select_countries" :
					// Get countries array
					if ( isset( $_POST[ $value['id'] ] ) ) {
						$selected_values = array_map( 'plugin_name_clean', array_map( 'stripslashes', (array) $_POST[ $value['id'] ] ) );
					}
					else {
						$selected_values = array();
					}

					$option_value = $selected_values;
				break;

				case "image_width" :
					if ( isset( $_POST[$value['id'] ]['width'] ) ) {
						$update_options[ $value['id'] ]['width']  = plugin_name_clean( stripslashes( $_POST[ $value['id'] ]['width'] ) );
						$update_options[ $value['id'] ]['height'] = plugin_name_clean( stripslashes( $_POST[ $value['id'] ]['height'] ) );

						if ( isset( $_POST[ $value['id'] ]['crop'] ) ) {
							$update_options[ $value['id'] ]['crop'] = 1;
						}
						else {
							$update_options[ $value['id'] ]['crop'] = 0;
						}
					}
					else {
						$update_options[ $value['id'] ]['width'] 	= $value['default']['width'];
						$update_options[ $value['id'] ]['height'] 	= $value['default']['height'];
						$update_options[ $value['id'] ]['crop'] 	= $value['default']['crop'];
					}
				break;

				// Custom handling
				default :
					do_action( 'plugin_name_update_option_' . $type, $value );
				break;
			} // END switch()

			if ( ! is_null( $option_value ) ) {
				// Check if option is an array
				if ( strstr( $value['id'], '[' ) ) {

					parse_str( $value['id'], $option_array );

					// Option name is first key
					$option_name = current( array_keys( $option_array ) );

					// Get old option value
					if ( ! isset( $update_options[ $option_name ] ) ) {
						$update_options[ $option_name ] = get_option( $option_name, array() );
					}

					if ( ! is_array( $update_options[ $option_name ] ) ) {
						$update_options[ $option_name ] = array();
					}

					// Set keys and value
					$key = key( $option_array[ $option_name ] );

					$update_options[ $option_name ][ $key ] = $option_value;

				// Single value
				}
				else {
					$update_options[ $value['id'] ] = $option_value;
				}
			}

			// Custom handling
			do_action( 'plugin_name_update_option', $value );
		}

		// Now save the options
		foreach( $update_options as $name => $value ) {
			update_option( $name, $value );
		}

		// Save all options as an array. Ready for export.
		if( empty( $current_section ) ) {
			update_option( 'plugin_name_options_' . $current_tab, $update_options );
		}
		else{
			update_option( 'plugin_name_options_' . $current_tab . '_' . $current_section, $update_options );
		}

		return true;
	} // END save_fields()

} // END class.

} // end if class exists.

?>
