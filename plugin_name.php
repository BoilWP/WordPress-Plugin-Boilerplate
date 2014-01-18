<?php
/*
 * Plugin Name: Plugin Name
 * Plugin URI: http://www.yourdomain.here
 * Description: Write a short description about what your plugin does here.
 * Version: 1.0.0
 * Author: Your Name / Your Company Name
 * Author Email: your_email@address.here
 * Requires at least: 3.8
 * Tested up to: 3.8
 *
 * Text Domain: plugin_name
 * Domain Path: /languages/
 *
 * @package Plugin_Name
 * @category Core
 * @author Your Name / Your Company Name
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name' ) ) :

/**
 * Main Plugin Name Class
 *
 * @class Plugin_Name
 * @version 1.0.0
 */
final class Plugin_Name {

	/**
	 * Constants
	 * TODO: change contants to the name of your plugin.
	 */
	const slug = 'plugin_name';

	/**
	 * Global Variables
	 * TODO: change contants to the name of your plugin.
	 */

	/**
	 * The Plug-in name.
	 *
	 * @var string
	 */
	public $name = "Plugin Name";

	/**
	 * The Plug-in version.
	 *
	 * @var string
	 */
	public $version = "1.0.0";

	/**
	 * Main Plugin Name Instance
	 *
	 * Ensures only one instance of Plugin Name is loaded or can be loaded.
	 *
	 * @static
	 * @see Plugin_Name()
	 * @return Plugin Name - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		// Auto-load classes on demand
		if ( function_exists( "__autoload" ) )
			spl_autoload_register( "__autoload" );

		spl_autoload_register( array( &$this, 'autoload' ) );

		// Define constants
		$this->define_constants();

		// Include required files
		$this->includes();

		// register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );

		// register a deactivation hook for the plugin
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

		// register a uninstall hook for the plugin
		register_uninstall_hook( __FILE__, array( &$this, 'uninstall' ) );

		/** 
		 * The plugins_loaded action hook fires early, 
		 * and precedes the setup_theme, after_setup_theme, 
		 * init and wp_loaded action hooks.
		 */
		add_action( 'plugins_loaded', array( &$this, 'start' ) );

		// Init API
		$this->api = new Plugin_Name_API();

		// Hooks
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'action_links' ) );
		add_action( 'widgets_init', array( &$this, 'include_widgets' ) );
		add_action( 'init', array( &$this, 'init_plugin_name' ), 0 );
		add_action( 'init', array( 'Plugin_Name_Shortcodes', 'init' ) );
		add_action( 'after_setup_theme', array( &$this, 'setup_environment' ) );

		// Loaded action
		do_action( 'plugin_name_loaded' );
	}

	/**
	 * action_links function.
	 *
	 * @access public
	 * @param mixed $links
	 * @return void
	 */
	// TODO: change 'local_plugin_name' to the name of the plugin.
	public function action_links( $links ) {

		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=plugin_name_settings' ) . '">' . __( 'Settings', 'local_plugin_name' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}

	/**
	 * Auto-load Plugin Name classes on demand to reduce memory consumption.
	 *
	 * @param mixed $class
	 * @return void
	 */
	public function autoload( $class ) {

		$class = strtolower( $class );

		if ( strpos( $class, 'plugin_name_shortcode_' ) === 0 ) {

			$path = $this->plugin_path() . '/includes/classes/shortcodes/';
			$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}

		}

		if ( strpos( $class, 'plugin_name_' ) === 0 ) {

			$path = $this->plugin_path() . '/includes/classes/';
			$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}
		}
	}

	/**
	 * Define Constants
	 */
	private function define_constants() {
		// TODO: change 'PLUGIN_NAME' to the name of the plugin.
		define( 'PLUGIN_NAME_FILE', __FILE__ );
		define( 'PLUGIN_NAME_VERSION', $this->version );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		define( 'PLUGIN_NAME_SCRIPT_MODE', $suffix );

	}

	/**
	 * Checks that the WordPress setup meets the plugin requirements
	 * @global string $wp_version
	 * @return boolean
	 */
	private function check_requirements() {
		global $wp_version;

		if (!version_compare($wp_version, $this->wp_version, '>=')) {
			add_action('admin_notices', array( &$this, 'display_req_notice' ) );
			return false;
		}

		return true;
	}

	/**
	 * Display the requirement notice
	 * @static
	 */
	static function display_req_notice() {
		echo '<div id="message" class="error"><p><strong>';
		echo sprintf(__('Sorry, %s requires WordPress ' . $this->wp_version . ' or higher. Please upgrade your WordPress setup', 'local_plugin_name'), $this->name);
		echo '</strong></p></div>';
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @access public
	 * @return void
	 */
	function includes() {
		include_once( 'includes/plugin-name-core-functions.php' ); // Contains core functions for the front/back end.

		if ( is_admin() )
			$this->admin_includes();

		if ( defined('DOING_AJAX') )
			$this->ajax_includes();

		if ( ! is_admin() || defined('DOING_AJAX') )
			$this->frontend_includes();

		// API Class
		include_once( 'includes/classes/class-plugin-name-api.php' );
	}

	/**
	 * Include required admin files.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_includes() {
		include_once( 'includes/plugin-name-hooks.php' ); // Hooks used in the admin
		include_once( 'includes/admin/plugin-name-admin-init.php' ); // Admin section
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
	 * Runs when the plugin is initialized
	 */
	public function init_plugin_name() {
		// Before init action
		do_action( 'before_plugin_name_init' );

		// Set up localisation
		$this->load_plugin_textdomain();

		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		// This will run when on the frontend and for ajax requests
		if ( ! is_admin() || defined('DOING_AJAX') ) {
			//add_action( 'wp_head', array( &$this, 'generator' ) );

			$this->shortcodes = new Plugin_Name_Shortcodes(); // Shortcodes class, controls all frontend shortcodes

			// HTTPS urls with SSL on
			$filters = array( 'post_thumbnail_html', 'widget_text', 'wp_get_attachment_url', 'wp_get_attachment_image_attributes', 'wp_get_attachment_url', 'option_stylesheet_url', 'option_template_url', 'script_loader_src', 'style_loader_src', 'template_directory_uri', 'stylesheet_directory_uri', 'site_url' );

			foreach ( $filters as $filter ) {
				add_filter( $filter, array( &$this, 'force_ssl' ) );
			}

		}

		// Email Actions
		$email_actions = array( 'plugin_name_welcome' );

		foreach ( $email_actions as $action ) {
			add_action( $action, array( &$this, 'send_transactional_email') );
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
		$locale = apply_filters( 'plugin_locale', get_locale(), 'plugin_name' );

		// Admin Locale
		if ( is_admin() ) {
			load_textdomain( 'plugin_name', WP_LANG_DIR . "/plugin_name/plugin_name-admin-$locale.mo" );
			load_textdomain( 'plugin_name', $this->plugin_path() . "/languages/plugin_name-admin-$locale.mo" );
		}

		// Frontend Locale
		load_textdomain( 'plugin_name', WP_LANG_DIR . "/plugin_name/plugin_name-" . $locale . ".mo" );

		load_plugin_textdomain( 'plugin_name', false, dirname( plugin_basename( __FILE__ ) ) . "/languages" );
	}

	/**
	 * Output generator to aid debugging.
	 *
	 * @access public
	 * @return void
	 */
	public function generator() {
		echo "\n\n" . '<!-- Plugin Name Version -->' . "\n" . '<meta name="generator" content="' . esc_attr( $this->name ) .' ' . esc_attr( $this->version ) . '" />' . "\n\n";
	}

	/** Inline JavaScript Helper **********************************************/

	/**
	 * Add some JavaScript inline to be output in the footer.
	 *
	 * @access public
	 * @param string $code
	 * @return void
	 */
	public function add_inline_js( $code ) {
		$this->_inline_js .= "\n" . $code . "\n";
	}

	/**
	 * Init the mailer and call the notifications for the current filter.
	 *
	 * @access public
	 * @param array $args (default: array())
	 * @return void
	 */
	public function send_transactional_email( $args = array() ) {
		$this->mailer();
		$args = func_get_args();
		do_action_ref_array( current_filter() . '_notification', $args );
	}

	/**
	 * Email Class.
	 *
	 * @access public
	 * @return Plugin_Name_Email
	 */
	public function mailer() {
		if ( empty( $this->plugin_name_email ) ) {
			$this->plugin_name_email = new Plugin_Name_Emails();
		}
		return $this->plugin_name_email;
	}

	/**
	 * Ensure theme and server variable compatibility.
	 */
	public function setup_environment() {
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
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Return the Plugin Name API URL for a given request
	 *
	 * @access public
	 * @param mixed $request
	 * @param mixed $ssl (default: null)
	 * @return string
	 */
	public function api_request_url( $request, $ssl = null ) {
		if ( is_null( $ssl ) ) {
			$scheme = parse_url( get_option( 'home' ), PHP_URL_SCHEME );
		} elseif ( $ssl ) {
			$scheme = 'https';
		} else {
			$scheme = 'http';
		}

		if ( get_option('permalink_structure') ) {
			return esc_url_raw( trailingslashit( home_url( '/plugin-name-api/' . $request, $scheme ) ) );
		} else {
			return esc_url_raw( add_query_arg( 'plugin-name-api', $request, trailingslashit( home_url( '', $scheme ) ) ) );
		}
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
			if ( is_array($content) )
				$content = array_map( array( $this, 'force_ssl' ) , $content );
			else
				$content = str_replace( 'http:', 'https:', $content );
		}
		return $content;
	}

	/**
	 * Runs when the plugin is activated
	 */
	public function activate() {
		// do not generate any output here
	}

	/**
	 * Runs when the plugin is deactivated
	 */
	public function deactivate() {
		// do not generate any output here
	}

	/**
	 * Runs when the plugin is uninstalled
	 */
	public function uninstall() {
		// do not generate any output here
	}

	/**
	 * Starts the plug-in main functionality
	 */
	public function start() {
		/**
		 * Insert your actions to setup your 
		 * plugin, register post types, user roles 
		 * and other stuff you want the plugin to do
		 */
	}

	/**
	 * Registers and enqueues stylesheets and javascripts 
	 * for the administration panel and the front of the site.
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			$this->load_file( self::slug . '-admin-script', '/assets/js/admin/plugin-name' . PLUGIN_NAME_SCRIPT_MODE . '.js', true );
			$this->load_file( self::slug . '-admin-style', '/assets/css/admin/plugin-name.css' );
		}
		else {
			$this->load_file( self::slug . '-script', '/assets/js/plugin-name' . PLUGIN_NAME_SCRIPT_MODE . '.js', true );
			$this->load_file( self::slug . '-style', '/assets/css/plugin-name.css' );

			// Variables for JS scripts
			$plugin_name_params = array(
				'plugin_url' => $this->plugin_url(),
			);

			wp_localize_script( 'plugin_name', 'plugin_name_params', apply_filters( 'plugin_name_params', $plugin_name_params ) );

		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {
		$url = $this->plugin_url() . $file_path;
		$file = $this->plugin_path() . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); // depends on jquery
				wp_enqueue_script( $name );
			}
			else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file

} // end class

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