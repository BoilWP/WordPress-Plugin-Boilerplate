<?php
/**
 * Plugin Name States: Hong Kong
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Library
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $states;

$states['HK'] = array(
	'HONG KONG'       => __( 'Hong Kong Island', PLUGIN_NAME_TEXT_DOMAIN ),
	'KOWLOON'         => __( 'Kowloon', PLUGIN_NAME_TEXT_DOMAIN ),
	'NEW TERRITORIES' => __( 'New Territories', PLUGIN_NAME_TEXT_DOMAIN )
);
