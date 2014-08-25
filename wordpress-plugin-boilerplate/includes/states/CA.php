<?php
/**
 * Plugin Name States: Canadian
 *
 * @author 		Your Name / Your Company Name
 * @category 	Core
 * @package 	Plugin Name/Library
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $states;

$states['CA'] = array(
	'AB' => __( 'Alberta', PLUGIN_NAME_TEXT_DOMAIN ),
	'BC' => __( 'British Columbia', PLUGIN_NAME_TEXT_DOMAIN ),
	'MB' => __( 'Manitoba', PLUGIN_NAME_TEXT_DOMAIN ),
	'NB' => __( 'New Brunswick', PLUGIN_NAME_TEXT_DOMAIN ),
	'NL' => __( 'Newfoundland', PLUGIN_NAME_TEXT_DOMAIN ),
	'NT' => __( 'Northwest Territories', PLUGIN_NAME_TEXT_DOMAIN ),
	'NS' => __( 'Nova Scotia', PLUGIN_NAME_TEXT_DOMAIN ),
	'NU' => __( 'Nunavut', PLUGIN_NAME_TEXT_DOMAIN ),
	'ON' => __( 'Ontario', PLUGIN_NAME_TEXT_DOMAIN ),
	'PE' => __( 'Prince Edward Island', PLUGIN_NAME_TEXT_DOMAIN ),
	'QC' => __( 'Quebec', PLUGIN_NAME_TEXT_DOMAIN ),
	'SK' => __( 'Saskatchewan', PLUGIN_NAME_TEXT_DOMAIN ),
	'YT' => __( 'Yukon Territory', PLUGIN_NAME_TEXT_DOMAIN )
);
