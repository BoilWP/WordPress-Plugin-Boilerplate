<?php
/**
 * Transifex API
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Transifex_API' ) ) {

	class Plugin_Name_Transifex_API {

		/**
		 * Construct
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  $cache_time
		 */
		public function __construct( $cache_time = 3600 ) {
			// Transifex API URL
			$this->api_url    = 'https://www.transifex.com/api/2/';

			// Cache Time
			$this->cache_time = $cache_time;

			// Set Credentials
			$this->set_credentials();
		} // END __construct()

		/**
		 * Set credentials
		 *
		 * @since  1.0.0
		 * @access public
		 * @return $auth
		 */
		public function set_credentials() {
			$username = '/@s-.e*$bd.8-6/@';
			$password = '$d.*ar/k-L@o.rd-$3/M.a$y';

			if ( !empty( $username ) && !empty( $password ) ) {
				$this->auth = $this->verify_credential( $username ) . ':' . $this->verify_credential( $password );
			}
		} // END set_credentials()

		/**
		 * Verify credential
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $verify
		 */
		public function verify_credential( $verify ) {
			$verify = str_replace('/', '', $verify);
			$verify = str_replace('@', '', $verify);
			$verify = str_replace('.', '', $verify);
			$verify = str_replace('-', '', $verify);
			$verify = str_replace('*', '', $verify);
			$verify = str_replace('$', '', $verify);

			return $verify;
		} // END verify_credential()

		/**
		 * Verify credentials
		 */
		function verify_credentials() {
			// @todo: contact transifex how to verify credentials
			return true;
		}

		/**
		 * Is API error
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  $response
		 * @return $error
		 */
		public function is_api_error( $response ) {
			$error = false;

			if ( ! $response ) {
				$error = __( 'No responses', PLUGIN_NAME_TEXT_DOMAIN );
			}

			if ( is_string( $response['body'] ) ) {
				if ( 200 !== $response['response']['code'] ) {
					$error = array( 'error' => $response['response'] );
				}
			}

			return $error;
		} // END is_api_error()

		/**
		 * Connect API
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $request API variable; e.g. projects
		 * @return $result
		 */
		public function connect_api( $request ) {
			$cache_id = md5( $request );

			$long_cache_id = md5( $request . 'long' );

			$result = get_transient( $cache_id );

			if ( ! $result && null !== $this->cache_time ) {
				$args = array(
					'headers' => array(
						'Authorization' => 'Basic ' . base64_encode( $this->auth )
					),
					'timeout' 	=> 120, // 2 min
					'sslverify' => false
				);

				$response = wp_remote_get( $this->api_url . $request, $args );

				if ( $error = $this->is_api_error( $response ) ) {
					return $error;
				}

				if ( $json = wp_remote_retrieve_body( $response ) ) {
					$result = json_decode( $json );

					set_transient( $cache_id, $result, $this->cache_time ); // refresh cache x hours
					set_transient( $long_cache_id, $result ); // forever
				}
			}

			if ( ! $result ) {
				$result = get_transient( $long_cache_id );
			}

			if ( ! $result ) {
				return false;
			}
			return $result;
		} // END connect_api()

	} // END class

} // END if class exists
?>
