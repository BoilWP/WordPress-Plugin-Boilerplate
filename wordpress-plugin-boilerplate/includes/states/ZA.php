<?php
/**
 * Plugin Name States: South African
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Library
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $states;

$states['ZA'] = array(
	'EC'  => __( 'Eastern Cape', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'FS'  => __( 'Free State', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'GP'  => __( 'Gauteng', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'KZN' => __( 'KwaZulu-Natal', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'LP'  => __( 'Limpopo', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'MP'  => __( 'Mpumalanga', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'NC'  => __( 'Northern Cape', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'NW'  => __( 'North West', PLUGIN_NAME_TEXT_DOMAIN ) ,
	'WC'  => __( 'Western Cape', PLUGIN_NAME_TEXT_DOMAIN )
);