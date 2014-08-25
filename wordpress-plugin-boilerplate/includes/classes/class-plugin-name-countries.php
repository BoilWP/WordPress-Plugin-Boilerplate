<?php
/**
 * Plugin Name countries
 *
 * The Plugin Name countries class stores country/state data.
 *
 * @class 		Plugin_Name_Countries
 * @version		1.0.0
 * @package		Plugin Name/Classes
 * @category	Class
 * @author 		Your Name / Your Company Name
 */
class Plugin_Name_Countries {

	/** @var array Array of countries */
	public $countries;

	/** @var array Array of states */
	public $states;

	/** @var array Array of locales */
	public $locale;

	/** @var array Array of address formats for locales */
	public $address_formats;

	/**
	 * Constructor for the counties class - defines all countries and states.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		global $plugin_name, $states;

		$this->countries = apply_filters( 'plugin_name_countries', array(
			'AF' => __( 'Afghanistan', PLUGIN_NAME_TEXT_DOMAIN ),
			'AX' => __( '&#197;land Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'AL' => __( 'Albania', PLUGIN_NAME_TEXT_DOMAIN ),
			'DZ' => __( 'Algeria', PLUGIN_NAME_TEXT_DOMAIN ),
			'AD' => __( 'Andorra', PLUGIN_NAME_TEXT_DOMAIN ),
			'AO' => __( 'Angola', PLUGIN_NAME_TEXT_DOMAIN ),
			'AI' => __( 'Anguilla', PLUGIN_NAME_TEXT_DOMAIN ),
			'AQ' => __( 'Antarctica', PLUGIN_NAME_TEXT_DOMAIN ),
			'AG' => __( 'Antigua and Barbuda', PLUGIN_NAME_TEXT_DOMAIN ),
			'AR' => __( 'Argentina', PLUGIN_NAME_TEXT_DOMAIN ),
			'AM' => __( 'Armenia', PLUGIN_NAME_TEXT_DOMAIN ),
			'AW' => __( 'Aruba', PLUGIN_NAME_TEXT_DOMAIN ),
			'AU' => __( 'Australia', PLUGIN_NAME_TEXT_DOMAIN ),
			'AT' => __( 'Austria', PLUGIN_NAME_TEXT_DOMAIN ),
			'AZ' => __( 'Azerbaijan', PLUGIN_NAME_TEXT_DOMAIN ),
			'BS' => __( 'Bahamas', PLUGIN_NAME_TEXT_DOMAIN ),
			'BH' => __( 'Bahrain', PLUGIN_NAME_TEXT_DOMAIN ),
			'BD' => __( 'Bangladesh', PLUGIN_NAME_TEXT_DOMAIN ),
			'BB' => __( 'Barbados', PLUGIN_NAME_TEXT_DOMAIN ),
			'BY' => __( 'Belarus', PLUGIN_NAME_TEXT_DOMAIN ),
			'BE' => __( 'Belgium', PLUGIN_NAME_TEXT_DOMAIN ),
			'PW' => __( 'Belau', PLUGIN_NAME_TEXT_DOMAIN ),
			'BZ' => __( 'Belize', PLUGIN_NAME_TEXT_DOMAIN ),
			'BJ' => __( 'Benin', PLUGIN_NAME_TEXT_DOMAIN ),
			'BM' => __( 'Bermuda', PLUGIN_NAME_TEXT_DOMAIN ),
			'BT' => __( 'Bhutan', PLUGIN_NAME_TEXT_DOMAIN ),
			'BO' => __( 'Bolivia', PLUGIN_NAME_TEXT_DOMAIN ),
			'BQ' => __( 'Bonaire, Saint Eustatius and Saba', PLUGIN_NAME_TEXT_DOMAIN ),
			'BA' => __( 'Bosnia and Herzegovina', PLUGIN_NAME_TEXT_DOMAIN ),
			'BW' => __( 'Botswana', PLUGIN_NAME_TEXT_DOMAIN ),
			'BV' => __( 'Bouvet Island', PLUGIN_NAME_TEXT_DOMAIN ),
			'BR' => __( 'Brazil', PLUGIN_NAME_TEXT_DOMAIN ),
			'IO' => __( 'British Indian Ocean Territory', PLUGIN_NAME_TEXT_DOMAIN ),
			'VG' => __( 'British Virgin Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'BN' => __( 'Brunei', PLUGIN_NAME_TEXT_DOMAIN ),
			'BG' => __( 'Bulgaria', PLUGIN_NAME_TEXT_DOMAIN ),
			'BF' => __( 'Burkina Faso', PLUGIN_NAME_TEXT_DOMAIN ),
			'BI' => __( 'Burundi', PLUGIN_NAME_TEXT_DOMAIN ),
			'KH' => __( 'Cambodia', PLUGIN_NAME_TEXT_DOMAIN ),
			'CM' => __( 'Cameroon', PLUGIN_NAME_TEXT_DOMAIN ),
			'CA' => __( 'Canada', PLUGIN_NAME_TEXT_DOMAIN ),
			'CV' => __( 'Cape Verde', PLUGIN_NAME_TEXT_DOMAIN ),
			'KY' => __( 'Cayman Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'CF' => __( 'Central African Republic', PLUGIN_NAME_TEXT_DOMAIN ),
			'TD' => __( 'Chad', PLUGIN_NAME_TEXT_DOMAIN ),
			'CL' => __( 'Chile', PLUGIN_NAME_TEXT_DOMAIN ),
			'CN' => __( 'China', PLUGIN_NAME_TEXT_DOMAIN ),
			'CX' => __( 'Christmas Island', PLUGIN_NAME_TEXT_DOMAIN ),
			'CC' => __( 'Cocos (Keeling) Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'CO' => __( 'Colombia', PLUGIN_NAME_TEXT_DOMAIN ),
			'KM' => __( 'Comoros', PLUGIN_NAME_TEXT_DOMAIN ),
			'CG' => __( 'Congo (Brazzaville)', PLUGIN_NAME_TEXT_DOMAIN ),
			'CD' => __( 'Congo (Kinshasa)', PLUGIN_NAME_TEXT_DOMAIN ),
			'CK' => __( 'Cook Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'CR' => __( 'Costa Rica', PLUGIN_NAME_TEXT_DOMAIN ),
			'HR' => __( 'Croatia', PLUGIN_NAME_TEXT_DOMAIN ),
			'CU' => __( 'Cuba', PLUGIN_NAME_TEXT_DOMAIN ),
			'CW' => __( 'Cura&Ccedil;ao', PLUGIN_NAME_TEXT_DOMAIN ),
			'CY' => __( 'Cyprus', PLUGIN_NAME_TEXT_DOMAIN ),
			'CZ' => __( 'Czech Republic', PLUGIN_NAME_TEXT_DOMAIN ),
			'DK' => __( 'Denmark', PLUGIN_NAME_TEXT_DOMAIN ),
			'DJ' => __( 'Djibouti', PLUGIN_NAME_TEXT_DOMAIN ),
			'DM' => __( 'Dominica', PLUGIN_NAME_TEXT_DOMAIN ),
			'DO' => __( 'Dominican Republic', PLUGIN_NAME_TEXT_DOMAIN ),
			'EC' => __( 'Ecuador', PLUGIN_NAME_TEXT_DOMAIN ),
			'EG' => __( 'Egypt', PLUGIN_NAME_TEXT_DOMAIN ),
			'SV' => __( 'El Salvador', PLUGIN_NAME_TEXT_DOMAIN ),
			'GQ' => __( 'Equatorial Guinea', PLUGIN_NAME_TEXT_DOMAIN ),
			'ER' => __( 'Eritrea', PLUGIN_NAME_TEXT_DOMAIN ),
			'EE' => __( 'Estonia', PLUGIN_NAME_TEXT_DOMAIN ),
			'ET' => __( 'Ethiopia', PLUGIN_NAME_TEXT_DOMAIN ),
			'FK' => __( 'Falkland Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'FO' => __( 'Faroe Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'FJ' => __( 'Fiji', PLUGIN_NAME_TEXT_DOMAIN ),
			'FI' => __( 'Finland', PLUGIN_NAME_TEXT_DOMAIN ),
			'FR' => __( 'France', PLUGIN_NAME_TEXT_DOMAIN ),
			'GF' => __( 'French Guiana', PLUGIN_NAME_TEXT_DOMAIN ),
			'PF' => __( 'French Polynesia', PLUGIN_NAME_TEXT_DOMAIN ),
			'TF' => __( 'French Southern Territories', PLUGIN_NAME_TEXT_DOMAIN ),
			'GA' => __( 'Gabon', PLUGIN_NAME_TEXT_DOMAIN ),
			'GM' => __( 'Gambia', PLUGIN_NAME_TEXT_DOMAIN ),
			'GE' => __( 'Georgia', PLUGIN_NAME_TEXT_DOMAIN ),
			'DE' => __( 'Germany', PLUGIN_NAME_TEXT_DOMAIN ),
			'GH' => __( 'Ghana', PLUGIN_NAME_TEXT_DOMAIN ),
			'GI' => __( 'Gibraltar', PLUGIN_NAME_TEXT_DOMAIN ),
			'GR' => __( 'Greece', PLUGIN_NAME_TEXT_DOMAIN ),
			'GL' => __( 'Greenland', PLUGIN_NAME_TEXT_DOMAIN ),
			'GD' => __( 'Grenada', PLUGIN_NAME_TEXT_DOMAIN ),
			'GP' => __( 'Guadeloupe', PLUGIN_NAME_TEXT_DOMAIN ),
			'GT' => __( 'Guatemala', PLUGIN_NAME_TEXT_DOMAIN ),
			'GG' => __( 'Guernsey', PLUGIN_NAME_TEXT_DOMAIN ),
			'GN' => __( 'Guinea', PLUGIN_NAME_TEXT_DOMAIN ),
			'GW' => __( 'Guinea-Bissau', PLUGIN_NAME_TEXT_DOMAIN ),
			'GY' => __( 'Guyana', PLUGIN_NAME_TEXT_DOMAIN ),
			'HT' => __( 'Haiti', PLUGIN_NAME_TEXT_DOMAIN ),
			'HM' => __( 'Heard Island and McDonald Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'HN' => __( 'Honduras', PLUGIN_NAME_TEXT_DOMAIN ),
			'HK' => __( 'Hong Kong', PLUGIN_NAME_TEXT_DOMAIN ),
			'HU' => __( 'Hungary', PLUGIN_NAME_TEXT_DOMAIN ),
			'IS' => __( 'Iceland', PLUGIN_NAME_TEXT_DOMAIN ),
			'IN' => __( 'India', PLUGIN_NAME_TEXT_DOMAIN ),
			'ID' => __( 'Indonesia', PLUGIN_NAME_TEXT_DOMAIN ),
			'IR' => __( 'Iran', PLUGIN_NAME_TEXT_DOMAIN ),
			'IQ' => __( 'Iraq', PLUGIN_NAME_TEXT_DOMAIN ),
			'IE' => __( 'Republic of Ireland', PLUGIN_NAME_TEXT_DOMAIN ),
			'IM' => __( 'Isle of Man', PLUGIN_NAME_TEXT_DOMAIN ),
			'IL' => __( 'Israel', PLUGIN_NAME_TEXT_DOMAIN ),
			'IT' => __( 'Italy', PLUGIN_NAME_TEXT_DOMAIN ),
			'CI' => __( 'Ivory Coast', PLUGIN_NAME_TEXT_DOMAIN ),
			'JM' => __( 'Jamaica', PLUGIN_NAME_TEXT_DOMAIN ),
			'JP' => __( 'Japan', PLUGIN_NAME_TEXT_DOMAIN ),
			'JE' => __( 'Jersey', PLUGIN_NAME_TEXT_DOMAIN ),
			'JO' => __( 'Jordan', PLUGIN_NAME_TEXT_DOMAIN ),
			'KZ' => __( 'Kazakhstan', PLUGIN_NAME_TEXT_DOMAIN ),
			'KE' => __( 'Kenya', PLUGIN_NAME_TEXT_DOMAIN ),
			'KI' => __( 'Kiribati', PLUGIN_NAME_TEXT_DOMAIN ),
			'KW' => __( 'Kuwait', PLUGIN_NAME_TEXT_DOMAIN ),
			'KG' => __( 'Kyrgyzstan', PLUGIN_NAME_TEXT_DOMAIN ),
			'LA' => __( 'Laos', PLUGIN_NAME_TEXT_DOMAIN ),
			'LV' => __( 'Latvia', PLUGIN_NAME_TEXT_DOMAIN ),
			'LB' => __( 'Lebanon', PLUGIN_NAME_TEXT_DOMAIN ),
			'LS' => __( 'Lesotho', PLUGIN_NAME_TEXT_DOMAIN ),
			'LR' => __( 'Liberia', PLUGIN_NAME_TEXT_DOMAIN ),
			'LY' => __( 'Libya', PLUGIN_NAME_TEXT_DOMAIN ),
			'LI' => __( 'Liechtenstein', PLUGIN_NAME_TEXT_DOMAIN ),
			'LT' => __( 'Lithuania', PLUGIN_NAME_TEXT_DOMAIN ),
			'LU' => __( 'Luxembourg', PLUGIN_NAME_TEXT_DOMAIN ),
			'MO' => __( 'Macao S.A.R., China', PLUGIN_NAME_TEXT_DOMAIN ),
			'MK' => __( 'Macedonia', PLUGIN_NAME_TEXT_DOMAIN ),
			'MG' => __( 'Madagascar', PLUGIN_NAME_TEXT_DOMAIN ),
			'MW' => __( 'Malawi', PLUGIN_NAME_TEXT_DOMAIN ),
			'MY' => __( 'Malaysia', PLUGIN_NAME_TEXT_DOMAIN ),
			'MV' => __( 'Maldives', PLUGIN_NAME_TEXT_DOMAIN ),
			'ML' => __( 'Mali', PLUGIN_NAME_TEXT_DOMAIN ),
			'MT' => __( 'Malta', PLUGIN_NAME_TEXT_DOMAIN ),
			'MH' => __( 'Marshall Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'MQ' => __( 'Martinique', PLUGIN_NAME_TEXT_DOMAIN ),
			'MR' => __( 'Mauritania', PLUGIN_NAME_TEXT_DOMAIN ),
			'MU' => __( 'Mauritius', PLUGIN_NAME_TEXT_DOMAIN ),
			'YT' => __( 'Mayotte', PLUGIN_NAME_TEXT_DOMAIN ),
			'MX' => __( 'Mexico', PLUGIN_NAME_TEXT_DOMAIN ),
			'FM' => __( 'Micronesia', PLUGIN_NAME_TEXT_DOMAIN ),
			'MD' => __( 'Moldova', PLUGIN_NAME_TEXT_DOMAIN ),
			'MC' => __( 'Monaco', PLUGIN_NAME_TEXT_DOMAIN ),
			'MN' => __( 'Mongolia', PLUGIN_NAME_TEXT_DOMAIN ),
			'ME' => __( 'Montenegro', PLUGIN_NAME_TEXT_DOMAIN ),
			'MS' => __( 'Montserrat', PLUGIN_NAME_TEXT_DOMAIN ),
			'MA' => __( 'Morocco', PLUGIN_NAME_TEXT_DOMAIN ),
			'MZ' => __( 'Mozambique', PLUGIN_NAME_TEXT_DOMAIN ),
			'MM' => __( 'Myanmar', PLUGIN_NAME_TEXT_DOMAIN ),
			'NA' => __( 'Namibia', PLUGIN_NAME_TEXT_DOMAIN ),
			'NR' => __( 'Nauru', PLUGIN_NAME_TEXT_DOMAIN ),
			'NP' => __( 'Nepal', PLUGIN_NAME_TEXT_DOMAIN ),
			'NL' => __( 'Netherlands', PLUGIN_NAME_TEXT_DOMAIN ),
			'AN' => __( 'Netherlands Antilles', PLUGIN_NAME_TEXT_DOMAIN ),
			'NC' => __( 'New Caledonia', PLUGIN_NAME_TEXT_DOMAIN ),
			'NZ' => __( 'New Zealand', PLUGIN_NAME_TEXT_DOMAIN ),
			'NI' => __( 'Nicaragua', PLUGIN_NAME_TEXT_DOMAIN ),
			'NE' => __( 'Niger', PLUGIN_NAME_TEXT_DOMAIN ),
			'NG' => __( 'Nigeria', PLUGIN_NAME_TEXT_DOMAIN ),
			'NU' => __( 'Niue', PLUGIN_NAME_TEXT_DOMAIN ),
			'NF' => __( 'Norfolk Island', PLUGIN_NAME_TEXT_DOMAIN ),
			'KP' => __( 'North Korea', PLUGIN_NAME_TEXT_DOMAIN ),
			'NO' => __( 'Norway', PLUGIN_NAME_TEXT_DOMAIN ),
			'OM' => __( 'Oman', PLUGIN_NAME_TEXT_DOMAIN ),
			'PK' => __( 'Pakistan', PLUGIN_NAME_TEXT_DOMAIN ),
			'PS' => __( 'Palestinian Territory', PLUGIN_NAME_TEXT_DOMAIN ),
			'PA' => __( 'Panama', PLUGIN_NAME_TEXT_DOMAIN ),
			'PG' => __( 'Papua New Guinea', PLUGIN_NAME_TEXT_DOMAIN ),
			'PY' => __( 'Paraguay', PLUGIN_NAME_TEXT_DOMAIN ),
			'PE' => __( 'Peru', PLUGIN_NAME_TEXT_DOMAIN ),
			'PH' => __( 'Philippines', PLUGIN_NAME_TEXT_DOMAIN ),
			'PN' => __( 'Pitcairn', PLUGIN_NAME_TEXT_DOMAIN ),
			'PL' => __( 'Poland', PLUGIN_NAME_TEXT_DOMAIN ),
			'PT' => __( 'Portugal', PLUGIN_NAME_TEXT_DOMAIN ),
			'QA' => __( 'Qatar', PLUGIN_NAME_TEXT_DOMAIN ),
			'RE' => __( 'Reunion', PLUGIN_NAME_TEXT_DOMAIN ),
			'RO' => __( 'Romania', PLUGIN_NAME_TEXT_DOMAIN ),
			'RU' => __( 'Russia', PLUGIN_NAME_TEXT_DOMAIN ),
			'RW' => __( 'Rwanda', PLUGIN_NAME_TEXT_DOMAIN ),
			'BL' => __( 'Saint Barth&eacute;lemy', PLUGIN_NAME_TEXT_DOMAIN ),
			'SH' => __( 'Saint Helena', PLUGIN_NAME_TEXT_DOMAIN ),
			'KN' => __( 'Saint Kitts and Nevis', PLUGIN_NAME_TEXT_DOMAIN ),
			'LC' => __( 'Saint Lucia', PLUGIN_NAME_TEXT_DOMAIN ),
			'MF' => __( 'Saint Martin (French part)', PLUGIN_NAME_TEXT_DOMAIN ),
			'SX' => __( 'Saint Martin (Dutch part)', PLUGIN_NAME_TEXT_DOMAIN ),
			'PM' => __( 'Saint Pierre and Miquelon', PLUGIN_NAME_TEXT_DOMAIN ),
			'VC' => __( 'Saint Vincent and the Grenadines', PLUGIN_NAME_TEXT_DOMAIN ),
			'SM' => __( 'San Marino', PLUGIN_NAME_TEXT_DOMAIN ),
			'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', PLUGIN_NAME_TEXT_DOMAIN ),
			'SA' => __( 'Saudi Arabia', PLUGIN_NAME_TEXT_DOMAIN ),
			'SN' => __( 'Senegal', PLUGIN_NAME_TEXT_DOMAIN ),
			'RS' => __( 'Serbia', PLUGIN_NAME_TEXT_DOMAIN ),
			'SC' => __( 'Seychelles', PLUGIN_NAME_TEXT_DOMAIN ),
			'SL' => __( 'Sierra Leone', PLUGIN_NAME_TEXT_DOMAIN ),
			'SG' => __( 'Singapore', PLUGIN_NAME_TEXT_DOMAIN ),
			'SK' => __( 'Slovakia', PLUGIN_NAME_TEXT_DOMAIN ),
			'SI' => __( 'Slovenia', PLUGIN_NAME_TEXT_DOMAIN ),
			'SB' => __( 'Solomon Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'SO' => __( 'Somalia', PLUGIN_NAME_TEXT_DOMAIN ),
			'ZA' => __( 'South Africa', PLUGIN_NAME_TEXT_DOMAIN ),
			'GS' => __( 'South Georgia/Sandwich Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'KR' => __( 'South Korea', PLUGIN_NAME_TEXT_DOMAIN ),
			'SS' => __( 'South Sudan', PLUGIN_NAME_TEXT_DOMAIN ),
			'ES' => __( 'Spain', PLUGIN_NAME_TEXT_DOMAIN ),
			'LK' => __( 'Sri Lanka', PLUGIN_NAME_TEXT_DOMAIN ),
			'SD' => __( 'Sudan', PLUGIN_NAME_TEXT_DOMAIN ),
			'SR' => __( 'Suriname', PLUGIN_NAME_TEXT_DOMAIN ),
			'SJ' => __( 'Svalbard and Jan Mayen', PLUGIN_NAME_TEXT_DOMAIN ),
			'SZ' => __( 'Swaziland', PLUGIN_NAME_TEXT_DOMAIN ),
			'SE' => __( 'Sweden', PLUGIN_NAME_TEXT_DOMAIN ),
			'CH' => __( 'Switzerland', PLUGIN_NAME_TEXT_DOMAIN ),
			'SY' => __( 'Syria', PLUGIN_NAME_TEXT_DOMAIN ),
			'TW' => __( 'Taiwan', PLUGIN_NAME_TEXT_DOMAIN ),
			'TJ' => __( 'Tajikistan', PLUGIN_NAME_TEXT_DOMAIN ),
			'TZ' => __( 'Tanzania', PLUGIN_NAME_TEXT_DOMAIN ),
			'TH' => __( 'Thailand', PLUGIN_NAME_TEXT_DOMAIN ),
			'TL' => __( 'Timor-Leste', PLUGIN_NAME_TEXT_DOMAIN ),
			'TG' => __( 'Togo', PLUGIN_NAME_TEXT_DOMAIN ),
			'TK' => __( 'Tokelau', PLUGIN_NAME_TEXT_DOMAIN ),
			'TO' => __( 'Tonga', PLUGIN_NAME_TEXT_DOMAIN ),
			'TT' => __( 'Trinidad and Tobago', PLUGIN_NAME_TEXT_DOMAIN ),
			'TN' => __( 'Tunisia', PLUGIN_NAME_TEXT_DOMAIN ),
			'TR' => __( 'Turkey', PLUGIN_NAME_TEXT_DOMAIN ),
			'TM' => __( 'Turkmenistan', PLUGIN_NAME_TEXT_DOMAIN ),
			'TC' => __( 'Turks and Caicos Islands', PLUGIN_NAME_TEXT_DOMAIN ),
			'TV' => __( 'Tuvalu', PLUGIN_NAME_TEXT_DOMAIN ),
			'UG' => __( 'Uganda', PLUGIN_NAME_TEXT_DOMAIN ),
			'UA' => __( 'Ukraine', PLUGIN_NAME_TEXT_DOMAIN ),
			'AE' => __( 'United Arab Emirates', PLUGIN_NAME_TEXT_DOMAIN ),
			'GB' => __( 'United Kingdom (UK)', PLUGIN_NAME_TEXT_DOMAIN ),
			'US' => __( 'United States (US)', PLUGIN_NAME_TEXT_DOMAIN ),
			'UY' => __( 'Uruguay', PLUGIN_NAME_TEXT_DOMAIN ),
			'UZ' => __( 'Uzbekistan', PLUGIN_NAME_TEXT_DOMAIN ),
			'VU' => __( 'Vanuatu', PLUGIN_NAME_TEXT_DOMAIN ),
			'VA' => __( 'Vatican', PLUGIN_NAME_TEXT_DOMAIN ),
			'VE' => __( 'Venezuela', PLUGIN_NAME_TEXT_DOMAIN ),
			'VN' => __( 'Vietnam', PLUGIN_NAME_TEXT_DOMAIN ),
			'WF' => __( 'Wallis and Futuna', PLUGIN_NAME_TEXT_DOMAIN ),
			'EH' => __( 'Western Sahara', PLUGIN_NAME_TEXT_DOMAIN ),
			'WS' => __( 'Western Samoa', PLUGIN_NAME_TEXT_DOMAIN ),
			'YE' => __( 'Yemen', PLUGIN_NAME_TEXT_DOMAIN ),
			'ZM' => __( 'Zambia', PLUGIN_NAME_TEXT_DOMAIN ),
			'ZW' => __( 'Zimbabwe', PLUGIN_NAME_TEXT_DOMAIN )
		));

		// States set to array() are blank i.e. the country has no use for the state field.
		$states = array(
			'AF' => array(),
			'AT' => array(),
			'BE' => array(),
			'BI' => array(),
			'CZ' => array(),
			'DE' => array(),
			'DK' => array(),
			'EE' => array(),
			'FI' => array(),
			'FR' => array(),
			'IS' => array(),
			'IL' => array(),
			'KR' => array(),
			'NL' => array(),
			'NO' => array(),
			'PL' => array(),
			'PT' => array(),
			'SG' => array(),
			'SK' => array(),
			'SI' => array(),
			'LK' => array(),
			'SE' => array(),
			'VN' => array(),
		);

		// Load only the state files the site owner wants/needs
		$allowed = array_merge( $this->get_allowed_countries() );

		if ( $allowed ) {
			foreach ( $allowed as $CC => $country ) {
				if ( ! isset( $states[ $CC ] ) && file_exists( Plugin_Name()->plugin_path() . '/includes/states/' . $CC . '.php' ) ) {
					include( Plugin_Name()->plugin_path() . '/includes/states/' . $CC . '.php' );
				}
			}
		}

		$this->states = apply_filters( 'plugin_name_states', $states );
	}

	/**
	 * Get the base country for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_country() {
		$default = esc_attr( get_option('plugin_name_default_country') );
		$country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );

		return apply_filters( 'plugin_name_countries_base_country', $country );
	}

	/**
	 * Get the base state for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_state() {
		$default 	= plugin_name_clean( get_option( 'plugin_name_default_country' ) );
		$state 		= ( ( $pos = strrpos( $default, ':' ) ) === false ) ? '' : substr( $default, $pos + 1 );

		return apply_filters( 'plugin_name_countries_base_state', $state );
	}

	/**
	 * Get the base city for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_city() {
		return apply_filters( 'plugin_name_countries_base_city', '' );
	}

	/**
	 * Get the base postcode for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_postcode() {
		return apply_filters( 'plugin_name_countries_base_postcode', '' );
	}

	/**
	 * Get the allowed countries for the store.
	 *
	 * @access public
	 * @return array
	 */
	public function get_allowed_countries() {
		if ( apply_filters('plugin_name_sort_countries', true ) ) {
			asort( $this->countries );
		}

		if ( get_option('plugin_name_allowed_countries') !== 'specific' ) {
			return $this->countries;
		}

		$countries = array();

		$raw_countries = get_option( 'plugin_name_specific_allowed_countries' );

		foreach ( $raw_countries as $country ) {
			$countries[ $country ] = $this->countries[ $country ];
		}

		return apply_filters( 'plugin_name_countries_allowed_countries', $countries );
	}

	/**
	 * get_allowed_country_states function.
	 *
	 * @access public
	 * @return array
	 */
	public function get_allowed_country_states() {
		if ( get_option('plugin_name_allowed_countries') !== 'specific' ) {
			return $this->states;
		}

		$states = array();

		$raw_countries = get_option( 'plugin_name_specific_allowed_countries' );

		foreach ( $raw_countries as $country ) {
			if ( isset( $this->states[ $country ] ) ) {
				$states[ $country ] = $this->states[ $country ];
			}
		}

		return apply_filters( 'plugin_name_countries_allowed_country_states', $states );
	}

	/**
	 * Gets an array of countries in the EU.
	 *
	 * @access public
	 * @return array
	 */
	public function get_european_union_countries() {
		return array( 'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GB', 'GR', 'HU', 'HR', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' );
	}

	/**
	 * Prefix certain countries with 'the'
	 *
	 * @access public
	 * @return string
	 */
	public function estimated_for_prefix() {
		$return = '';
		if ( in_array( $this->get_base_country(), array( 'GB', 'US', 'AE', 'CZ', 'DO', 'NL', 'PH', 'USAF' ) ) ) $return = __( 'the', 'plugin_name' ) . ' ';
		return apply_filters('plugin_name_countries_estimated_for_prefix', $return, $this->get_base_country());
	}

	/**
	 * Get the states for a country.
	 *
	 * @access public
	 * @param string $cc country code
	 * @return array of states
	 */
	public function get_states( $cc ) {
		return ( isset( $this->states[ $cc ] ) ) ? $this->states[ $cc ] : array();
	}

	/**
	 * Outputs the list of countries and states for use in dropdown boxes.
	 *
	 * @access public
	 * @param string $selected_country (default: '')
	 * @param string $selected_state (default: '')
	 * @param bool $escape (default: false)
	 * @return void
	 */
	public function country_dropdown_options( $selected_country = '', $selected_state = '', $escape = false ) {
		if ( apply_filters('plugin_name_sort_countries', true ) ) {
			asort( $this->countries );
		}

		if ( $this->countries ) foreach ( $this->countries as $key => $value) {
			if ( $states =  $this->get_states($key) ) {
				echo '<optgroup label="' . esc_attr( $value ) . '">';
					foreach ($states as $state_key=>$state_value) {
						echo '<option value="' . esc_attr( $key ) . ':'.$state_key.'"';

						if ($selected_country==$key && $selected_state==$state_key) echo ' selected="selected"';

						echo '>'.$value.' &mdash; '. ($escape ? esc_js($state_value) : $state_value) .'</option>';
					}
				echo '</optgroup>';
			}
			else {
				echo '<option';
				if ( $selected_country == $key && $selected_state == '*' ) echo ' selected="selected"';
				echo ' value="' . esc_attr( $key ) . '">'. ($escape ? esc_js( $value ) : $value) .'</option>';
			}
		}
	}

}

?>