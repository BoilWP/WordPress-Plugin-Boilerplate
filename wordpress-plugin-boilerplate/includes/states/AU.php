<?php
/**
 * Plugin Name States: Australian
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Library
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $states;

$states['AU'] = array(
	'ACT' => __( 'Australian Capital Territory', PLUGIN_NAME_TEXT_DOMAIN ),
	'NSW' => __( 'New South Wales', PLUGIN_NAME_TEXT_DOMAIN ),
	'NT'  => __( 'Northern Territory', PLUGIN_NAME_TEXT_DOMAIN ),
	'QLD' => __( 'Queensland', PLUGIN_NAME_TEXT_DOMAIN ),
	'SA'  => __( 'South Australia', PLUGIN_NAME_TEXT_DOMAIN ),
	'TAS' => __( 'Tasmania', PLUGIN_NAME_TEXT_DOMAIN ),
	'VIC' => __( 'Victoria', PLUGIN_NAME_TEXT_DOMAIN ),
	'WA'  => __( 'Western Australia', PLUGIN_NAME_TEXT_DOMAIN )
);
