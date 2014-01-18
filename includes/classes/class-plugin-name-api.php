<?php
/**
 * Plugin Name API
 *
 * Handles Plugin-Name-API endpoint requests
 *
 * @author 		Your Name / Your Company Name
 * @category    API
 * @package     Plugin Name/API
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Plugin_Name_API {

	/**
	 * This is the major version for the REST API and takes
	 * first-order position in endpoint URLs
	 */
	const VERSION = 1;

	/** @var Plugin_Name_API_Server the REST API server */
	public $server;

	/**
	 * Setup class
	 *
	 * @access public
	 * @return Plugin_Name_API
	 */
	public function __construct() {

		// add query vars
		add_filter( 'query_vars', array( &$this, 'add_query_vars'), 0 );

		// register API endpoints
		add_action( 'init', array( &$this, 'add_endpoint'), 0 );

		// handle REST/legacy API request
		add_action( 'parse_request', array( &$this, 'handle_api_requests'), 0 );
	}

	/**
	 * add_query_vars function.
	 *
	 * @access public
	 * @param $vars
	 * @return array
	 */
	public function add_query_vars( $vars ) {
		$vars[] = 'plugin-name-api';
		$vars[] = 'plugin-name-api-route';
		return $vars;
	}

	/**
	 * add_endpoint function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_endpoint() {

		// REST API
		add_rewrite_rule( '^plugin-name-api\/v' . self::VERSION . '/?$', 'index.php?plugin-name-api-route=/', 'top' );
		add_rewrite_rule( '^plugin-name-api\/v' . self::VERSION .'(.*)?', 'index.php?plugin-name-api-route=$matches[1]', 'top' );

		// Legacy API, useful for payment gateway IPNs
		add_rewrite_endpoint( 'plugin-name-api', EP_ALL );
	}

	/**
	 * API request - Trigger any API requests
	 *
	 * @access public
	 * @return void
	 */
	public function handle_api_requests() {
		global $wp;

		if ( ! empty( $_GET['plugin-name-api'] ) )
			$wp->query_vars['plugin-name-api'] = $_GET['plugin-name-api'];

		if ( ! empty( $_GET['plugin-name-api-route'] ) )
			$wp->query_vars['plugin-name-api-route'] = $_GET['plugin-name-api-route'];

		// REST API request
		if ( ! empty( $wp->query_vars['plugin-name-api-route'] ) ) {

			define( 'Plugin_Name_API_REQUEST', true );

			// load required files
			$this->includes();

			$this->server = new Plugin_Name_API_Server( $wp->query_vars['plugin-name-api-route'] );

			// load API resource classes
			$this->register_resources( $this->server );

			// Fire off the request
			$this->server->serve_request();

			exit;
		}

		// Legacy API requests
		if ( ! empty( $wp->query_vars['plugin-name-api'] ) ) {

			// Buffer, we won't want any output here
			ob_start();

			// Get API trigger
			$api = strtolower( esc_attr( $wp->query_vars['plugin-name-api'] ) );

			// Load class if exists
			if ( class_exists( $api ) )
				$api_class = new $api();

			// Trigger actions
			do_action( 'plugin_name_api_' . $api );

			// Done, clear buffer and exit
			ob_end_clean();
			die('1');
		}
	}

	/**
	 * Include required files for REST API request
	 */
	private function includes() {

		// API server / response handlers
		include_once( 'api/class-plugin-name-api-server.php' );
		include_once( 'api/class-plugin-name-api-json-handler.php' );

		// Authentication
		include_once( 'api/class-plugin-name-api-authentication.php' );
		$this->authentication = new Plugin_Name_API_Authentication();

		// Allow plugins to load other response handlers or resource classes
		do_action( 'plugin_name_api_loaded' );
	}

	/**
	 * Register available API resources
	 *
	 * @param object $server the REST server
	 */
	public function register_resources( $server ) {

		$api_classes = apply_filters( 'plugin_name_api_classes',
			array(
				'Plugin_Name_API_Users',
			)
		);

		foreach ( $api_classes as $api_class ) {
			$this->$api_class = new $api_class( $server );
		}
	}

}
?>