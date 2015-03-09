<?php
/**
 * Installation related functions and actions.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Install' ) ) {

/**
 * Plugin_Name_Install Class
 */
class Plugin_Name_Install {

	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		register_activation_hook( PLUGIN_NAME_FILE,                                    array( $this, 'install' ) );

		add_action( 'admin_init',                                                      array( $this, 'install_actions' ) );
		add_action( 'admin_init',                                                      array( $this, 'check_version' ), 5 );
		add_action( 'in_plugin_update_message-' . plugin_basename( PLUGIN_NAME_FILE ), array( $this, 'in_plugin_update_message' ) );
	} // END __construct()

	/**
	 * When called, the plugin checks the version
	 * of the plugin and the database version in use.
	 * This function determins if the plugin requires
	 * to process an update.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && ( get_option( 'plugin_name_version' ) != Plugin_Name()->version || get_option( 'plugin_name_db_version' ) != Plugin_Name()->version ) )
			$this->install();

			do_action( 'plugin_name_updated' );
	} // END check_version()

	/**
	 * Install actions such as installing pages when a button is clicked.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function install_actions() {
		// Install - Add pages button
		if ( ! empty( $_GET['install_plugin_name_pages'] ) ) {

			$this->create_pages();

			// We no longer need to install pages
			delete_option( '_plugin_name_needs_pages' );
			delete_transient( 'plugin_name_activation_redirect' );

			// What's new redirect
			wp_redirect( admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-about&plugin-name-installed=true' ) );
			exit;

		// Skip button
		} else if ( ! empty( $_GET['skip_install_plugin_name_pages'] ) ) {
			// We no longer need to install pages
			delete_option( '_plugin_name_needs_pages' );
			delete_transient( 'plugin_name_activation_redirect' );

			// What's new redirect
			wp_redirect( admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-about' ) );
			exit;

		// Update button
		} else if ( ! empty( $_GET['do_update_plugin_name'] ) ) {
			$this->update();

			// Update complete
			delete_option( '_plugin_name_needs_pages' );
			delete_option( '_plugin_name_needs_update' );
			delete_transient( 'plugin_name_activation_redirect' );

			// What's new redirect
			wp_redirect( admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-about&plugin-name-updated=true' ) );
			exit;
		}
	} // END install_action()

	/**
	 * Install Plugin Name
	 *
	 * @todo   Change the 'page-slug' to the page slug
	 *         of the main page this plugin needs.
	 * @since  1.0.0
	 * @access public
	 */
	public function install() {
		$this->create_options();
		$this->create_user_roles();
		$this->create_files();

		// Queue upgrades
		$current_version    = get_option( 'plugin_name_version', null );
		$current_db_version = get_option( 'plugin_name_db_version', null );

		if ( version_compare( $current_db_version, '1.0.1', '<' ) && null !== $current_db_version ) {
			update_option( '_plugin_name_needs_update', 1 );
		} else {
			update_option( 'plugin_name_db_version', Plugin_Name()->version );
		}

		// Update version
		update_option( 'plugin_name_version', Plugin_Name()->version );

		// Check if pages are needed
		if ( plugin_name_get_page_id( 'page-slug' ) < 1 ) {
			update_option( '_plugin_name_needs_pages', 1 );
		}

		// Flush rewrite rules
		flush_rewrite_rules();

		// Redirect to welcome screen
		set_transient( 'plugin_name_activation_redirect', 1, HOUR_IN_SECONDS );

		// Trigger action
		do_action( 'plugin_name_installed' );
	} // END install()

	/**
	 * Handle updates
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function update() {
		// Do updates
		$current_db_version = get_option( 'plugin_name_db_version' );

		if ( version_compare( $current_db_version, '1.0.1', '<' ) || PLUGIN_NAME_VERSION == '1.0.1' ) {
			include( 'updates/plugin-name-update-1.0.1.php' );
			update_option( 'plugin_name_db_version', '1.0.1' );
		}

		update_option( 'plugin_name_db_version', Plugin_Name()->version );
	} // END update()

	/**
	 * List the pages that your plugin relies on,
	 * fetching the page id's in variables.
	 *
	 * @since  1.0.0
	 * @access public
	 * @filter plugin_name_pages
	 * @return void
	 */
	public function plugin_name_pages() {
		return apply_filters( 'plugin_name_pages', array(
			'example'   => array(
				'name'    => _x( 'example', 'page_slug', PLUGIN_NAME_TEXT_DOMAIN ),
				'title'   => __( 'Example Page', PLUGIN_NAME_TEXT_DOMAIN ),
				'content' => __( 'This page was created as an example to show you the ability to creating pages automatically when the plugin is installed. You may if you wish create a page just to insert a single shortcode. You should find this page already set in the plugin settings. This save the user time to setup the pages the plugin requires.', PLUGIN_NAME_TEXT_DOMAIN )
			),

			'shortcode' => array(
				'name'    => _x( 'shortcode', 'page_slug', PLUGIN_NAME_TEXT_DOMAIN ),
				'title'   => __( 'Shortcode Example Page', PLUGIN_NAME_TEXT_DOMAIN ),
				'content' => __( '[caption align="alignright" width="300"]<img src="http://placekitten.com/300/205" alt="Cat" title="Cute Cat" width="300" height="205" /> Cute Cat[/caption] This page was created to show shortcode detection in the page.', PLUGIN_NAME_TEXT_DOMAIN )
			),
		) );
	} // END plugin_name_pages()

	/**
	 * Create the pages the plugin relies on,
	 * storing page id's in variables.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function create_pages() {
		$pages = self::plugin_name_pages(); // Get the pages.

		foreach ( $pages as $key => $page ) {
			plugin_name_create_page( esc_sql( $page['name'] ), 'plugin_name_' . $key . '_page_id', $page['title'], $page['content'], ! empty( $page['parent'] ) ? plugin_name_get_page_id( $page['parent'] ) : '' );
		}
	} // END create_pages()

	/**
	 * Default Options
	 *
	 * Sets up the default options defined on the settings pages.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function create_options() {
		// Include settings so that we can run through defaults
		include_once( 'class-plugin-name-admin-settings.php' );

		$settings = Plugin_Name_Admin_Settings::get_settings_pages();

		foreach ( $settings as $section ) {
			foreach ( $section->get_settings() as $value ) {
				if ( isset( $value['default'] ) && isset( $value['id'] ) ) {
					$autoload = isset( $value['autoload'] ) ? (bool) $value['autoload'] : true;
					add_option( $value['id'], $value['default'], '', ( $autoload ? 'yes' : 'no' ) );
				}
			}
		}
	} // END create_options()

	/**
	 * Create user roles and user capabilities.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $wp_roles
	 * @see    http://codex.wordpress.org/Roles_and_Capabilities
	 */
	public function create_user_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {

			/**
			 * Add your custom user roles here and
			 * set the permissions for that role.
			 */
			add_role( 'custom_role', sprintf( __( '%s Manager', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->version ), array(
				'level_9'                => true,
				'level_8'                => false,
				'level_7'                => false,
				'level_6'                => false,
				'level_5'                => false,
				'level_4'                => false,
				'level_3'                => false,
				'level_2'                => false,
				'level_1'                => false,
				'level_0'                => false,
				'read'                   => true,
				'read_private_pages'     => false,
				'read_private_posts'     => false,
				'edit_users'             => false,
				'edit_posts'             => false,
				'edit_pages'             => false,
				'edit_published_posts'   => false,
				'edit_published_pages'   => false,
				'edit_private_pages'     => false,
				'edit_private_posts'     => false,
				'edit_others_posts'      => false,
				'edit_others_pages'      => false,
				'publish_posts'          => false,
				'publish_pages'          => false,
				'delete_posts'           => false,
				'delete_pages'           => false,
				'delete_private_pages'   => false,
				'delete_private_posts'   => false,
				'delete_published_pages' => false,
				'delete_published_posts' => false,
				'delete_others_posts'    => false,
				'delete_others_pages'    => false,
				'manage_categories'      => false,
				'manage_links'           => false,
				'moderate_comments'      => false,
				'unfiltered_html'        => false,
				'upload_files'           => false,
				'export'                 => false,
				'import'                 => false,
				'list_users'             => false
			) );

			$capabilities = self::get_core_capabilities();

			foreach( $capabilities as $cap_group ) {
				foreach( $cap_group as $cap ) {
					$wp_roles->add_cap( 'administrator', $cap );
				}
			}
		}
	} // END create_roles()

	/**
	 * Get capabilities for Plugin Name.
	 *
	 * These are assigned to admin and any other
	 * user role capabilities during installation
	 * or resetting the plugin.
	 *
	 * @todo   Replace the post types with your custom post types.
	 * @access public
	 * @filter plugin_name_capability_post_types
	 * @return array
	 */
	public function get_core_capabilities() {
		$capabilities = array();

		$capabilities['core'] = array(
			"manage_plugin_name",
		);

		// List the post types you want to apply these capability types to.
		$capability_types = apply_filters( 'plugin_name_capability_post_types', array( 'post', 'page' ) );

		foreach( $capability_types as $capability_type ) {

			$capabilities[ $capability_type ] = array(
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",

				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms"
			);
		}

		return $capabilities;
	} // END get_core_capabilities()

	/**
	 * Remove User Roles.
	 *
	 * This removes any custom user roles created by the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function remove_user_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {

			$capabilities = self::get_core_capabilities();

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->remove_cap( 'administrator', $cap );
				}
			}

			remove_role( 'custom_role' );
		}
	} // END remove_user_roles()

	/**
	 * Delete all plugin options.
	 *
	 * @todo   Replace 'plugin_name' with the prefix
	 *         your plugin options begin with.
	 * @since  1.0.0
	 * @access public
	 * @global $wpdb
	 * @return void
	 */
	public function delete_options() {
		global $wpdb;

		// Delete options
		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'plugin_name_%';" );
	} // END delete_options()

	/**
	 * Active plugins pre update option filter
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $new_value
	 * @return string
	 */
	/*public function pre_update_option_active_plugins( $new_value ) {
		$old_value = (array) get_option('active_plugins');

		if ( $new_value !== $old_value && in_array( W3TC_FILE, (array) $new_value ) && in_array( W3TC_FILE, (array) $old_value ) ) {
			$this->_config->set('notes.plugins_updated', true);

			try {
				$this->_config->save();
			}

			catch(Exception $ex) {}
		}

		return $new_value;
	}*/

	/**
	 * Create files and directories.
	 *
	 * @since  1.0.2
	 * @access private
	 * @filter plugin_name_create_files
	 */
	private static function create_files() {
		$upload_dir = wp_upload_dir();

		$files = apply_filters( 'plugin_name_create_files', array(
			array(
				'base'    => $upload_dir['basedir'] . '/plugin-name-logs/',
				'file'    => '.htaccess',
				'content' => 'deny from all'
			),
			array(
				'base'    => $upload_dir['basedir'] . '/plugin-name-logs/',
				'file'    => 'index.html',
				'content' => ''
			)
		) );

		foreach ( $files as $file ) {
			if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
				if ( $file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ) ) {
					fwrite( $file_handle, $file['content'] );
					fclose( $file_handle );
				}
			}
		}
	} // END create_files()

	/**
	 * Show details of plugin changes on the
	 * Installed Plugins screen.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function in_plugin_update_message() {
		$response = wp_remote_get( PLUGIN_NAME_README_FILE );

		if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {

			// Output Upgrade Notice
			$matches = null;
			$regexp  = '~==\s*Upgrade Notice\s*==\s*=\s*[0-9.]+\s*=(.*)(=\s*' . preg_quote( PLUGIN_NAME_VERSION ) . '\s*=|$)~Uis';

			if ( preg_match( $regexp, $response['body'], $matches ) ) {
				$notices = (array) preg_split('~[\r\n]+~', trim( $matches[1] ) );

				echo '<div class="plugin_name_upgrade_notice" style="padding: 8px; margin: 6px 0;">';

				foreach ( $notices as $index => $line ) {
					echo '<p style="margin: 0; font-size: 1.1em; text-shadow: 0 1px 1px #3563e8;">' . preg_replace( '~\[([^\]]*)\]\(([^\)]*)\)~', '<a href="${2}">${1}</a>', $line ) . '</p>';
				}

				echo '</div>';
			}

			// Output Changelog
			$matches = null;
			$regexp  = '~==\s*Changelog\s*==\s*=\s*[0-9.]+\s*-(.*)=(.*)(=\s*' . preg_quote( PLUGIN_NAME_VERSION ) . '\s*-(.*)=|$)~Uis';

			if ( preg_match( $regexp, $response['body'], $matches ) ) {
				$changelog = (array) preg_split('~[\r\n]+~', trim( $matches[2] ) );

				echo ' ' . __( 'What\'s new:', PLUGIN_NAME_TEXT_DOMAIN ) . '<div style="font-weight: normal;">';

				$ul = false;

				foreach ( $changelog as $index => $line ) {
					if ( preg_match('~^\s*\*\s*~', $line ) ) {
						if ( ! $ul ) {
							echo '<ul style="list-style: disc inside; margin: 9px 0 9px 20px; overflow:hidden; zoom: 1;">';
							$ul = true;
						}
						$line = preg_replace( '~^\s*\*\s*~', '', htmlspecialchars( $line ) );
						echo '<li style="width: 50%; margin: 0; float: left; ' . ( $index % 2 == 0 ? 'clear: left;' : '' ) . '">' . $line . '</li>';
					} else {
						if ( $ul ) {
							echo '</ul>';
							$ul = false;
						}
						echo '<p style="margin: 9px 0;">' . htmlspecialchars( $line ) . '</p>';
					}
				}

				if ( $ul ) {
					echo '</ul>';
				}

				echo '</div>';
			}
		}
	} // END in_plugin_update_message()

} // END if class.

} // END if class exists.

return new Plugin_Name_Install();

?>
