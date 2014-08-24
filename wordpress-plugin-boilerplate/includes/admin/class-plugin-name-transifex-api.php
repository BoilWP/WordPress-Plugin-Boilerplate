<?php
/**
 * Transifex API
 */
class Plugin_Name_Transifex_API {

	function __construct( $cache_time = 3600 ) {

		$this->api_url = 'https://www.transifex.com/api/2/';
		$this->cache_time = $cache_time;
		$this->set_credentials();
	}

	/**
	 * Set credentials
	 */
	function set_credentials() {
		$username = '/@s-.e*$bd.8-6/@';
		$password = '$d.*ar/k-L@o.rd-$3/M.a$y';

		if ( !empty( $username ) && !empty( $password ) ) {
			$this->auth = $this->verify_credential( $username ) . ':' . $this->verify_credential( $password );
		}
	}

	/**
	 * Verify credential
	 */
	function verify_credential( $verify ) {
		$verify = str_replace('/', '', $verify);
		$verify = str_replace('@', '', $verify);
		$verify = str_replace('.', '', $verify);
		$verify = str_replace('-', '', $verify);
		$verify = str_replace('*', '', $verify);
		$verify = str_replace('$', '', $verify);

		return $verify;
	}

	/**
	 * Verify credentials
	 */
	function verify_credentials() {

		// @todo: contact transifex how to verify credentials
		return true;
	}

	/**
	 * Is API error
	 */
	function is_api_error( $response ) {
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
	}

	/**
	 * Connect API
	 *
	 * @param string $request API variable; e.g. projects
	 */
	function connect_api( $request ) {

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
	}
}

?>