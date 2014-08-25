<?php
/*
 * Plugin Name: WordPress Plugin Boilerplate
 * Plugin URI: https://github.com/seb86/WordPress-Plugin-Boilerplate
 * Description: The best WordPress plugin boilerplate you will ever need, comes prepaired with settings control panel, system information, a welcoming dashboard and more.
 * Version: 1.0.0
 * Author: Sebastien Dumont
 * Author URI: http://www.sebastiendumont.com
 * Author Email: mailme@sebastiendumont.com
 * Requires at least: 3.8
 * Tested up to: 4.0 beta4
 * Text Domain: textdomain-plugin-name
 * Domain Path: languages
 * Network: false
 * GitHub Plugin URI: https://github.com/seb86/WordPress-Plugin-Boilerplate
 *
 * WordPress Plugin Boilerplate is distributed under the terms of the 
 * GNU General Public License as published by the Free Software Foundation, 
 * either version 2 of the License, or any later version.
 *
 * WordPress Plugin Boilerplate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress Plugin Boilerplate. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Plugin_Name
 * @author Your Name / Your Company Name
 * @category Core
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name' ) ) {

/**
 * Main Plugin Name Class
 *
 * @class Plugin_Name
 * @version 1.0.0
 */
final class Plugin_Name {

	/**
	 * The single instance of the class
	 *
	 * @var Plugin Name
	 */
	protected static $_instance = null;

	/**
	 * Global Variables
	 * TODO: change variables to what you want them to be.
	 */

	/**
	 * Slug
	 *
	 * @var string
	 */
	public $plugin_slug = 'plugin_name';

	/**
	 * Text Domain
	 *
	 * @var string
	 */
	public $text_domain = 'textdomain-plugin-name';

	/**
	 * The Plug-in name.
	 *
	 * @var string
	 */
	public $name = "WordPress Plugin Boilerplate";

	/**
	 * The Plug-in version.
	 *
	 * @var string
	 */
	public $version = "1.0.0";

	/**
	 * The WordPress version the plugin requires minumum.
	 *
	 * @var string
	 */
	public $wp_version_min = "3.8";

	/**
	 * Memory Limit required for the Plugin.
	 *
	 * @var string
	 */
	public $memory_limit = '640'; // returns 64 MB

	/**
	 * @var Plugin_Name_Countries $countries
	 */
	public $countries = null;

	/**
	 * The Plug-in URL.
	 *
	 * @TODO Replace the url
	 * @var string
	 */
	public $web_url = "http://www.sebastiendumont.com/plugins/boilerplates/wordpress-plugin-boilerplate/ ";

	/**
	 * The Plug-in documentation URL.
	 *
	 * @TODO Replace the url
	 * @var string
	 */
	public $doc_url = "https://github.com/seb86/WordPress-Plugin-Boilerplate/wiki/";

	/**
	 * The WordPress Plug-in URL.
	 *
	 * @TODO Replace the url ex. 'http://wordpress.org/plugins/your-plugin-name'
	 * @var string
	 */
	public $wp_plugin_url = "http://wordpress.org/plugins/your-plugin-name";

	/**
	 * The WordPress Plug-in Support URL.
	 *
	 * @TODO Replace the url ex. 'http://wordpress.org/support/plugin/your-plugin-name'
	 * @var string
	 */
	public $wp_plugin_support_url = "http://www.sebastiendumont.com/support/forum/wordpress-plugin-boilerplate/";

	/**
	 * Theme Author URL
	 *
	 * Comment: This is used to detect themes developed by 
	 * the same developer of this plugin.
	 *
	 * @TODO Replace the url
	 * @var string
	 */
	public $theme_author_url = "http://www.yourdomain.com";

	/**
	 * Changelog URL
	 *
	 * Comment: This is used to access the changelogs directory
	 * of the themes developed by the same developer of this plugin.
	 *
	 * @TODO Replace the url
	 * @var string
	 */
	public $changelog_url = "http://www.yourdomain.com/changelogs/";

	/**
	 * GitHub Repo URL
	 *
	 * @TODO Replace the url
	 * @var string
	 */
	public $github_repo_url = "https://github.com/seb86/WordPress-Plugin-Boilerplate/";

	/**
	 * Transifex Project URL
	 *
	 * @TODO Replace the url
	 * @var string
	 */
	public $transifex_project_url = "https://www.transifex.com/projects/p/wordpress-plugin-boilerplate/";

	/**
	 * The Plug-in menu name.
	 *
	 * @TODO Replace the name of the plugin for the side menu
	 * @var string
	 */
	public $menu_name = "My Plugin";

	/**
	 * The Plug-in title page name.
	 *
	 * @TODO Replace the title
	 * @var string
	 */
	public $title_name = "WordPress Plugin Boilerplate";

	/**
	 * The Plug-in manage plugin name.
	 *
	 * @TODO Replace the 'manage_plugin_name' with the 
	 * level control the user must have to control the plugin.
	 * @var string
	 */
	public $manage_plugin = "manage_plugin_name";

	/**
	 * Display single submenu link to the settings page 
	 * or provide a submenu link for each settings tab.
	 *
	 * If value is empty or no then just a single submenu
	 * will be available. If yes then each settings tab 
	 * will have it's own submenu link for quicker access.
	 *
	 * @var string
	 */
	public $full_settings_menu = "no";

	/**
	 * Facebook Page Name/ID.
	 *
	 * @TODO Replace with your own
	 * @var string
	 */
	public $facebook_page = "SebD";

	/**
	 * Twitter Username.
	 *
	 * @TODO Replace with your own
	 * @var string
	 */
	public $twitter_username = "sebd86";

	/**
	 * Google Plus ID Number.
	 *
	 * @TODO Replace with your own
	 * @var string
	 */
	public $google_plus_id = "114016411970997366558";

	/**
	 * Transifex Project Slug
	 *
	 * @TODO Replace with your own
	 * @var string
	 */
	public $transifex_project_slug = 'wordpress-plugin-boilerplate';

	/**
	 * Transifex Resources Slug
	 *
	 * @TODO Replace with your own
	 * @var string
	 */
	public $transifex_resources_slug = 'wordpress-plugin-boilerplate';

	/**
	 * Main Plugin Name Instance
	 *
	 * Ensures only one instance of Plugin Name is loaded or can be loaded.
	 *
	 * @access public static
	 * @see Plugin_Name()
	 * @return Plugin Name - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new Plugin_Name;
		}
		return self::$_instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'textdomain-plugin-name' ), $this->version );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'textdomain-plugin-name' ), $this->version );
	}

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {
		// Auto-load classes on demand
		if ( function_exists( "__autoload" ) )
			spl_autoload_register( "__autoload" );

		spl_autoload_register( array( &$this, 'autoload' ) );

		// Define constants
		$this->define_constants();

		// Check plugin requirements
		$this->check_requirements();

		// Include required files
		$this->includes();

		// Hooks
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'action_links' ) );
		add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
		add_action( 'widgets_init', array( &$this, 'include_widgets' ) );
		add_action( 'init', array( &$this, 'init_plugin_name' ), 0 );
		add_action( 'init', array( 'Plugin_Name_Shortcodes', 'init' ) );
		add_action( 'after_setup_theme', array( &$this, 'setup_environment' ) );

		// Loaded action
		do_action( 'plugin_name_loaded' );
	}

	/**
	 * Plugin action links.
	 *
	 * @access public
	 * @param mixed $links
	 * @return void
	 */
	public function action_links( $links ) {
		// List your action links
		if( current_user_can( $this->manage_plugin ) ) {
			$plugin_links = array(
				'<a href="' . admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings' ) . '">' . __( 'Settings', 'textdomain-plugin-name' ) . '</a>',
			);
			return array_merge( $links, $plugin_links );
		}

		return $links;
	}

	/**
	 * Plugin row meta links
	 *
	 * @filter plugin_name_about_text_link
	 * @filter plugin_name_documentation_url
	 * @access public
	 * @param array $input already defined meta links
	 * @param string $file plugin file path and name being processed
	 * @return array $input
	 */
	public function plugin_row_meta( $input, $file ) {
		if ( plugin_basename( __FILE__ ) !== $file ) {
			return $input;
		}

		$links = array(
			'<a href="' . admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-about' ) . '">' . esc_html( apply_filters( 'plugin_name_about_text_link', __( 'Getting Started', 'textdomain-plugin-name' ) ) ) . '</a>',
			'<a href="' . admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-credits' ) . '">' . esc_html( __( 'Credits', 'textdomain-plugin-name' ) ) . '</a>',
			'<a href="' . esc_url( apply_filters( 'plugin_name_documentation_url', $this->doc_url ) ) . '">' . __( 'Documentation', 'textdomain-plugin-name' ) . '</a>',
		);

		$input = array_merge( $input, $links );

		return $input;
	}

	/**
	 * Auto-load Plugin Name classes on demand to reduce memory consumption.
	 *
	 * @access public
	 * @param mixed $class
	 * @return void
	 */
	public function autoload( $class ) {
		$path  = null;
		$class = strtolower( $class );
		$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

		$class = strtolower( $class );

		if ( strpos( $class, 'plugin_name_shortcode_' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/classes/shortcodes/';
		}
		else if ( strpos( $class, 'plugin_name_' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/classes/';
		}
		else if ( strpos( $class, 'plugin_name_admin' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/admin/';
		}

		if ( $path && is_readable( $path . $file ) ) {
			include_once( $path . $file );
			return;
		}

		// Fallback
		if ( strpos( $class, 'plugin_name_' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/';
		}

		if ( $path && is_readable( $path . $file ) ) {
			include_once( $path . $file );
			return;
		}

	}

	/**
	 * Define Constants
	 *
	 * @access private
	 */
	private function define_constants() {
		// TODO: change 'PLUGIN_NAME' to the name of the plugin.
		if ( ! defined( 'PLUGIN_NAME' ) ) define( 'PLUGIN_NAME', $this->name );
		if ( ! defined( 'PLUGIN_NAME_FILE' ) ) define( 'PLUGIN_NAME_FILE', __FILE__ );
		if ( ! defined( 'PLUGIN_NAME_VERSION' ) ) define( 'PLUGIN_NAME_VERSION', $this->version );
		if ( ! defined( 'PLUGIN_NAME_WP_VERSION_REQUIRE' ) ) define( 'PLUGIN_NAME_WP_VERSION_REQUIRE', $this->wp_version_min );
		if ( ! defined( 'PLUGIN_NAME_MENU_NAME' ) ) define( 'PLUGIN_NAME_MENU_NAME', strtolower( str_replace( ' ', '-', $this->menu_name ) ) );
		if ( ! defined( 'PLUGIN_NAME_PAGE' ) ) define( 'PLUGIN_NAME_PAGE', str_replace('_', '-', $this->plugin_slug) );
		if ( ! defined( 'PLUGIN_NAME_SCREEN_ID' ) ) define( 'PLUGIN_NAME_SCREEN_ID', strtolower( str_replace( ' ', '-', PLUGIN_NAME_PAGE ) ) );
		if ( ! defined( 'PLUGIN_NAME_SLUG' ) ) define( 'PLUGIN_NAME_SLUG', $this->plugin_slug );
		if ( ! defined( 'PLUGIN_NAME_TEXT_DOMAIN' ) ) define( 'PLUGIN_NAME_TEXT_DOMAIN', $this->text_domain );

		if ( ! defined( 'PLUGIN_NAME_README_FILE' ) ) define( 'PLUGIN_NAME_README_FILE', 'http://plugins.svn.wordpress.org/plugin-name/trunk/readme.txt' );

		if ( ! defined( 'GITHUB_REPO_URL' ) ) define( 'GITHUB_REPO_URL', $this->github_repo_url );
		if ( ! defined( 'TRANSIFEX_PROJECT_URL' ) ) define( 'TRANSIFEX_PROJECT_URL', $this->transifex_project_url );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		define( 'PLUGIN_NAME_SCRIPT_MODE', $suffix );
	}

	/**
	 * Checks that the WordPress setup meets the plugin requirements.
	 *
	 * @access private
	 * @global string $wp_version
	 * @return boolean
	 */
	private function check_requirements() {
		global $wp_version;

		if (!version_compare($wp_version, PLUGIN_NAME_WP_VERSION_REQUIRE, '>=')) {
			add_action('admin_notices', array( &$this, 'display_req_notice' ) );
			return false;
		}

		return true;
	}

	/**
	 * Display the requirement notice.
	 *
	 * @access static
	 */
	static function display_req_notice() {
		echo '<div id="message" class="error"><p><strong>';
		echo sprintf( __('Sorry, %s requires WordPress ' . PLUGIN_NAME_WP_VERSION_REQUIRE . ' or higher. Please upgrade your WordPress setup', 'textdomain-plugin-name'), PLUGIN_NAME );
		echo '</strong></p></div>';
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @access public
	 * @return void
	 */
	public function includes() {
		include_once( 'includes/plugin-name-core-functions.php' ); // Contains core functions for the front/back end.

		if ( is_admin() ) {
			$this->admin_includes();
		}

		if ( defined('DOING_AJAX') ) {
			$this->ajax_includes();
		}

		if ( ! is_admin() || defined('DOING_AJAX') ) {
			$this->frontend_includes();
		}

		include_once( 'includes/plugin-name-hooks.php' ); // Hooks used in either the front or the admin
		// Classes (used on all pages)
		include_once( 'includes/classes/class-plugin-name-countries.php' ); // Defines countries and states.
	}

	/**
	 * Include required admin files.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_includes() {
		include_once( 'includes/admin/class-plugin-name-install.php' ); // Install plugin
		include_once( 'includes/admin/class-plugin-name-admin.php' ); // Admin section
	}

	/**
	 * Include required ajax files.
	 *
	 * @access public
	 * @return void
	 */
	public function ajax_includes() {
		include_once( 'includes/plugin-name-ajax.php' ); // Ajax functions for admin and the front-end
	}

	/**
	 * Include required frontend files.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_includes() {
		// Functions
		include_once( 'includes/plugin-name-template-hooks.php' ); // Include template hooks for themes to remove/modify them
		include_once( 'includes/plugin-name-functions.php' ); // Contains functions for various front-end events

		// Classes
		include_once( 'includes/classes/class-plugin-name-shortcodes.php' ); // Shortcodes class
	}

	/**
	 * Include widgets.
	 *
	 * @access public
	 * @return void
	 */
	public function include_widgets() {
		include_once( 'includes/widgets.php' ); // Includes the widgets listed and registers each one.
	}

	/**
	 * Runs when the plugin is initialized.
	 *
	 * @access public
	 */
	public function init_plugin_name() {
		// Before init action
		do_action( 'before_plugin_name_init' );

		// Set up localisation
		$this->load_plugin_textdomain();

		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		// Load class instances
		$this->countries = new Plugin_Name_Countries(); // Countries class

		// This will run on the frontend and for ajax requests
		if ( ! is_admin() || defined('DOING_AJAX') ) {
			$this->shortcodes = new Plugin_Name_Shortcodes(); // Shortcodes class, controls all frontend shortcodes

			/**
			 * If we're on the frontend, ensure any links output to a page 
			 * (when viewing via HTTPS) are also served over HTTPS.
			 */
			$ssl_filters = apply_filters( 'plugin_name_force_ssl_filter', array( 'post_thumbnail_html', 'widget_text', 'wp_get_attachment_url', 'wp_get_attachment_image_attributes', 'wp_get_attachment_url', 'option_stylesheet_url', 'option_template_url', 'script_loader_src', 'style_loader_src', 'template_directory_uri', 'stylesheet_directory_uri', 'site_url' ) );

			foreach ( $ssl_filters as $filter ) {
				add_filter( $filter, array( &$this, 'force_ssl' ) );
			}
		}

		// Init action
		do_action( 'plugin_name_init' );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any 
	 * following ones if the same translation is present.
	 *
	 * @access public
	 * @return void
	 */
	public function load_plugin_textdomain() {
		// Set filter for plugin's languages directory
		$lang_dir = dirname( plugin_basename( PLUGIN_NAME_FILE ) ) . '/languages/';
		$lang_dir = apply_filters( 'plugin_name_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale',  get_locale(), $this->text_domain );
		$mofile = sprintf( '%1$s-%2$s.mo', $this->text_domain, $locale );

		// Setup paths to current locale file
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/' . $this->text_domain . '/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/plugin-name/ folder
			load_textdomain( $this->text_domain, $mofile_global );
		}
		elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/plugin-name/languages/ folder
			load_textdomain( $this->text_domain, $mofile_local );
		}
		else {
			// Load the default language files
			load_plugin_textdomain( $this->text_domain, false, $lang_dir );
		}
	}

	/**
	 * Ensure theme and server variable compatibility.
	 *
	 * @access public
	 */
	public function setup_environment() {
		// Insert your theme support code here.

		// IIS
		if ( ! isset($_SERVER['REQUEST_URI'] ) ) {
			$_SERVER['REQUEST_URI'] = substr( $_SERVER['PHP_SELF'], 1 );
			if ( isset( $_SERVER['QUERY_STRING'] ) ) {
				$_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
			}
		}

		// NGINX Proxy
		if ( ! isset( $_SERVER['REMOTE_ADDR'] ) && isset( $_SERVER['HTTP_REMOTE_ADDR'] ) ) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_REMOTE_ADDR'];
		}

		if ( ! isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTP_HTTPS'] ) ) {
			$_SERVER['HTTPS'] = $_SERVER['HTTP_HTTPS'];
		}

		// Support for hosts which don't use HTTPS, and use HTTP_X_FORWARDED_PROTO
		if ( ! isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
			$_SERVER['HTTPS'] = '1';
		}
	}

	/** Helper functions ******************************************************/

	/**
	 * Get the plugin url.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'PLUGIN_NAME_TEMPLATE_PATH', 'plugin-name/' );
	}

	/**
	 * force_ssl function.
	 *
	 * @access public
	 * @param mixed $content
	 * @return void
	 */
	public function force_ssl( $content ) {
		if ( is_ssl() ) {
			if ( is_array($content) ) {
				$content = array_map( array( $this, 'force_ssl' ) , $content );
			}
			else {
				$content = str_replace( 'http:', 'https:', $content );
			}
		}
		return $content;
	}

	/**
	 * Registers and enqueues stylesheets and javascripts 
	 * for the administration panel and the front of the site.
	 *
	 * @access private
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			// Main Plugin Javascript
			//$this->load_file( $this->plugin_slug . '_admin_script', '/assets/js/admin/plugin-name' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip'), $this->version );
			$this->load_file( $this->plugin_slug . '_admin_script', '/assets/js/admin/plugin-name.js', true, array('jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip'), $this->version );
			// Plugin Menu
			$this->load_file( $this->plugin_slug . '_admin_menu_script', '/assets/js/admin/admin-menu.js', true, array('jquery'), $this->version );

			// Block UI
			$this->load_file( 'jquery-blockui', '/assets/js/jquery-blockui/jquery.blockUI' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), '2.60' );

			// TipTip
			$this->load_file( 'jquery-tiptip', '/assets/js/jquery-tiptip/jquery.tipTip' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );

			// Chosen
			$this->load_file( 'ajax-chosen', '/assets/js/chosen/ajax-chosen.jquery' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery', 'chosen'), $this->version );
			$this->load_file( 'chosen', '/assets/js/chosen/chosen.jquery' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );

			// Chosen RTL
			if ( is_rtl() ) {
				$this->load_file( 'chosen-rtl', '/assets/js/chosen/chosen-rtl' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );
			}

			// prettyPhoto
			$this->load_file( 'jquery-prettyphoto', '/assets/js/prettyPhoto/jquery.prettyPhoto' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );
			$this->load_file( 'jquery-prettyphoto-init', '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );
			$this->load_file( 'prettyPhoto-style', '/assets/css/prettyPhoto.css' );

			// Transifex
			$this->load_file( 'transifex', '/assets/js/admin/transifex.js', true, array('jquery'), $this->version );

			// Variables for Admin JavaScripts
			wp_localize_script( $this->plugin_slug . '_admin_script', 'plugin_name_admin_params', apply_filters( 'plugin_name_admin_params', array(
				'ajaxurl' 				=> admin_url('admin-ajax.php'),
				'no_result' 			=> __( 'No results', 'textdomain-plugin-name' ),
				'plugin_url' 			=> $this->plugin_url(),
				'i18n_nav_warning' 		=> __( 'The changes you made will be lost if you navigate away from this page.', 'textdomain-plugin-name' ),
				'full_settings_menu' 	=> $this->full_settings_menu,
				'plugin_menu_name' 		=> $this->menu_name,
				'plugin_screen_id' 		=> PLUGIN_NAME_SCREEN_ID,
				'_tab_one' 		=> __( 'First Tab', 'textdomain-plugin-name' ),
				'_tab_two' 		=> __( 'Second Tab', 'textdomain-plugin-name' ),
				'system_status' 		=> __( 'System Status', 'textdomain-plugin-name' ),
				'tools' 				=> __( 'Tools', 'textdomain-plugin-name' ),
				'_import' 				=> __( 'Import', 'textdomain-plugin-name' ),
				'_export' 				=> __( 'Export', 'textdomain-plugin-name' ),
				)
			) );

			// Stylesheets
			$this->load_file( $this->plugin_slug . '_admin_style', '/assets/css/admin/plugin-name.css' );
			$this->load_file( $this->plugin_slug . '_admin_menu_styles', '/assets/css/admin/menu.css' );
		}
		else {
			$this->load_file( $this->plugin_slug . '-script', '/assets/js/frontend/plugin-name' . PLUGIN_NAME_SCRIPT_MODE . '.js', true );

			// prettyPhoto
			$this->load_file( 'jquery-prettyphoto', '/assets/js/prettyPhoto/jquery.prettyPhoto' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );
			$this->load_file( 'jquery-prettyphoto-init', '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array('jquery'), $this->version );
			$this->load_file( 'prettyPhoto-style', '/assets/css/prettyPhoto.css' );

			// Plugin Name Stylesheet
			$this->load_file( $this->plugin_slug . '-style', '/assets/css/plugin-name.css' );

			// Variables for JS scripts
			wp_localize_script( $this->plugin_slug . '-script', 'plugin_name_params', apply_filters( 'plugin_name_params', array(
				'plugin_url' => $this->plugin_url(),
				)
			) );
		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 *
	 * @access private
	 */
	private function load_file( $name, $file_path, $is_script = false, $support = array(), $version = '' ) {
		global $wp_version;

		$url = $this->plugin_url() . $file_path;
		$file = $this->plugin_path() . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, $support, $version );
				wp_enqueue_script( $name );
			}
			else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

		wp_enqueue_style( 'wp-color-picker' );
		if ( is_admin() && $wp_version >= '3.8' ) {
			wp_enqueue_style( 'dashicons' ); // Loads only in WordPress 3.8 and up.
		}

	} // end load_file

} // end class

} // end if class exists

/**
 * Returns the main instance of Plugin_Name to prevent the need to use globals.
 *
 * @return Plugin Name
 */
function Plugin_Name() {
	return Plugin_Name::instance();
}

// Global for backwards compatibility.
$GLOBALS['plugin_name'] = Plugin_Name();

?>