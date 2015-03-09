<?php
/**
 * Plugin Name Shortcodes.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Class
 * @package  Plugin Name/Classes
 * @license  GPL-2.0+
 */
class Plugin_Name_Shortcodes {

	/**
	 * Initiate Shortcodes
	 *
	 * @todo   Define your shortcodes here.
	 * @since  1.0.0
	 * @access public static
	 */
	public static function init() {
		$shortcodes = array(
			'sample' => __CLASS__ . '::sample',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "plugin_name_{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	} // END init()

	/**
	 * Shortcode Wrapper
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $function
	 * @param  array $atts (default: array())
	 * @return string
	 */
	public function shortcode_wrapper(
		$function, $atts = array(), $wrapper = array( 'class' => 'plugin_name', 'before' => null, 'after' => null ) ){
		ob_start();

		$before = empty( $wrapper['before'] ) ? '<div class="' . $wrapper['class'] . '">' : $wrapper['before'];
		$after  = empty( $wrapper['after'] ) ? '</div>' : $wrapper['after'];

		echo $before;
		call_user_func( $function, $atts );
		echo $after;

		return ob_get_clean();
	}

	/**
	 * Sample shortcode.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $atts
	 * @return string
	 */
	public static function sample( $atts ) {
		return $this->shortcode_wrapper( array( 'Plugin_Name_Shortcode_Sample', 'output' ), $atts );
	} // END sample()

} // END Plugin_Name_Shortcodes class
?>
