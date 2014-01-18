<?php
/**
 * Plugin Name API Authentication Class
 *
 * @author 		Your Name / Your Company Name
 * @category    API
 * @package     Plugin Name/Classes/API
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Plugin_Name_API_Authentication {

	/**
	 * Setup class
	 *
	 * @return Plugin_Name_API_Authentication
	 */
	public function __construct() {

		// to disable authentication, hook into this filter at a later priority and return a valid WP_User
		add_filter( 'plugin_name_api_check_authentication', array( $this, 'authenticate' ), 0 );
	}

	/**
	 * Authenticate the request. The authentication method 
	 * varies based on whether the request was made over 
	 * SSL or not.
	 *
	 * @param WP_User $user
	 * @return null|WP_Error|WP_User
	 */
	public function authenticate( $user ) {

		// allow access to the index by default
		if ( '/' === WC()->api->server->path )
			return new WP_User(0);

		try {

			if ( is_ssl() )
				$user = $this->perform_ssl_authentication();
			else
				$user = $this->perform_oauth_authentication();

			// check API key-specific permission
			$this->check_api_key_permissions( $user );

		} catch ( Exception $e ) {

			$user = new WP_Error( 'plugin_name_api_authentication_error', $e->getMessage(), array( 'status' => $e->getCode() ) );
		}

		return $user;
	}

	/**
	 * SSL-encrypted requests are not subject to sniffing 
	 * or man-in-the-middle attacks, so the request can be 
	 * authenticated by simply looking up the user 
	 * associated with the given consumer key and confirming 
	 * the consumer secret provided is valid
	 *
	 * @return WP_User
	 * @throws Exception
	 */
	private function perform_ssl_authentication() {

		if ( empty( $_SERVER['PHP_AUTH_USER'] ) )
			throw new Exception( __( 'Consumer Key is missing', 'local_plugin_name' ), 404 );

		if ( empty( $_SERVER['PHP_AUTH_PW'] ) )
			throw new Exception( __( 'Consumer Secret is missing', 'local_plugin_name' ), 404 );

		$consumer_key    = $_SERVER['PHP_AUTH_USER'];
		$consumer_secret = $_SERVER['PHP_AUTH_PW'];

		$user = $this->get_user_by_consumer_key( $consumer_key );

		if ( ! $this->is_consumer_secret_valid( $user, $consumer_secret ) )
			throw new Exception( __( 'Consumer Secret is invalid', 'local_plugin_name'), 401 );

		return $user;
	}

	/**
	 * Perform OAuth 1.0a "one-legged" (http://oauthbible.com/#oauth-10a-one-legged) authentication for non-SSL requests
	 *
	 * This is required so API credentials cannot be sniffed or intercepted when making API requests over plain HTTP
	 *
	 * This follows the spec for simple OAuth 1.0a authentication (RFC 5849) as closely as possible, with two exceptions:
	 *
	 * 1) There is no token associated with request/responses, only consumer keys/secrets are used
	 *
	 * 2) The OAuth parameters are included as part of the request query string instead of part of the Authorization header,
	 *    This is because there is no cross-OS function within PHP to get the raw Authorization header
	 *
	 * @link http://tools.ietf.org/html/rfc5849 for the full spec
	 * @return WP_User
	 * @throws Exception
	 */
	private function perform_oauth_authentication() {

		$params = WC()->api->server->params['GET'];

		$param_names =  array( 'oauth_consumer_key', 'oauth_timestamp', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method' );

		// check for required OAuth parameters
		foreach ( $param_names as $param_name ) {

			if ( empty( $params[ $param_name ] ) )
				throw new Exception( sprintf( __( '%s parameter is missing', 'local_plugin_name' ), $param_name ), 404 );
		}

		// fetch WP user by consumer key
		$user = $this->get_user_by_consumer_key( $params['oauth_consumer_key'] );

		// perform OAuth validation
		$this->check_oauth_signature( $user, $params );
		$this->check_oauth_timestamp_and_nonce( $user, $params['oauth_timestamp'], $params['oauth_nonce'] );

		// remove oauth params before further parsing
		foreach( $param_names as $param_name ) {
			unset( WC()->api->server->params[ $param_name ] );
		}

		// authentication successful, return user
		return $user;
	}

	/**
	 * Verify that the consumer-provided request signature 
	 * matches our generated signature, this ensures the 
	 * consumer has a valid key/secret
	 *
	 * @param WP_User $user
	 * @param array $params the request parameters
	 * @throws Exception
	 */
	private function check_oauth_signature( $user, $params ) {

		$http_method = strtoupper( WC()->api->server->method );

		$base_request_uri = rawurlencode( get_home_url( null, parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), 'http' ) );

		// get the signature provided by the consumer and remove it from the parameters prior to checking the signature
		$consumer_signature = rawurldecode( $params['oauth_signature'] );
		unset( $params['oauth_signature'] );

		// normalize parameter key/values
		array_walk( $params, array( $this, 'normalize_parameters' ) );

		// sort parameters
		if ( ! uksort( $params, 'strcmp' ) )
			throw new Exception( __( 'Invalid Signature - failed to sort parameters', 'local_plugin_name' ), 401 );

		// form query string
		$query_params = array();
		foreach ( $params as $param_key => $param_value ) {

			$query_params[] = $param_key . '%3D' . $param_value; // join with equals sign
		}
		$query_string = implode( '%26', $query_params ); // join with ampersand

		$string_to_sign = $http_method . '&' . $base_request_uri . '&' . $query_string;

		if ( $params['oauth_signature_method'] !== 'HMAC-SHA1' && $params['oauth_signature_method'] !== 'HMAC-SHA256' )
			throw new Exception( __( 'Invalid Signature - signature method is invalid', 'local_plugin_name' ), 401 );

		$hash_algorithm = strtolower( str_replace( 'HMAC-', '', $params['oauth_signature_method'] ) );

		$signature = base64_encode( hash_hmac( $hash_algorithm, $string_to_sign, $user->plugin_name_api_consumer_secret, true ) );

		if ( $signature !== $consumer_signature )
			throw new Exception( __( 'Invalid Signature - provided signature does not match', 'local_plugin_name' ), 401 );
	}

	/**
	 * Normalize each parameter by assuming each parameter 
	 * may have already been encoded, so attempt to decode, 
	 * and then re-encode according to RFC 3986
	 *
	 * @see rawurlencode()
	 * @param string $key
	 * @param string $value
	 */
	private function normalize_parameters( &$key, &$value ) {

		$key = rawurlencode( rawurldecode( $key ) );
		$value = rawurlencode( rawurldecode( $value ) );
	}

	/**
	 * Verify that the timestamp and nonce provided with the request are valid. This prevents replay attacks where
	 * an attacker could attempt to re-send an intercepted request at a later time.
	 *
	 * - A timestamp is valid if it is within 15 minutes of now
	 * - A nonce is valid if it has not been used within the last 15 minutes
	 *
	 * @param WP_User $user
	 * @param int $timestamp the unix timestamp for when the request was made
	 * @param string $nonce a unique (for the given user) 32 alphanumeric string, consumer-generated
	 * @throws Exception
	 */
	private function check_oauth_timestamp_and_nonce( $user, $timestamp, $nonce ) {

		$valid_window = 15 * 60; // 15 minute window

		if ( ( $timestamp < time() - $valid_window ) ||  ( $timestamp > time() + $valid_window ) )
			throw new Exception( __( 'Invalid timestamp', 'local_plugin_name' ) );

		$used_nonces = $user->plugin_name_api_nonces;

		if ( empty( $used_nonces ) )
			$used_nonces = array();

		if ( in_array( $nonce, $used_nonces ) )
			throw new Exception( __( 'Invalid nonce - nonce has already been used', 'local_plugin_name' ), 401 );

		$used_nonces[ $timestamp ] = $nonce;

		// remove expired nonces
		foreach( $used_nonces as $nonce_timestamp => $nonce ) {

			if ( $nonce_timestamp < $valid_window )
				unset( $used_nonces[ $nonce_timestamp ] );
		}

		update_user_meta( $user->ID, 'plugin_name_api_nonces', $used_nonces );
	}

	/**
	 * Check that the API keys provided have the proper 
	 * key-specific permissions to either read or write API resources
	 *
	 * @param WP_User $user
	 * @throws Exception if the permission check fails
	 */
	public function check_api_key_permissions( $user ) {

		$key_permissions = $user->plugin_name_api_key_permissions;

		switch ( WC()->api->server->method ) {

			case 'HEAD':
			case 'GET':
				if ( 'read' !== $key_permissions && 'read_write' !== $key_permissions ) {
					throw new Exception( __( 'The API key provided does not have read permissions', 'local_plugin_name' ), 401 );
				}
				break;

			case 'POST':
			case 'PUT':
			case 'PATCH':
			case 'DELETE':
				if ( 'write' !== $key_permissions && 'read_write' !== $key_permissions ) {
					throw new Exception( __( 'The API key provided does not have write permissions', 'local_plugin_name' ), 401 );
				}
				break;
		}
	}
}

?>