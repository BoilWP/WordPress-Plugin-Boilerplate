<?php
/**
* Admin View: Admin Theme Notice
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="message" class="updated plugin-name-message">
	<p><?php _e( sprintf( '<strong>Your theme does not declare %s support</strong> &#8211; if you encounter layout issues please read our integration guide or choose a theme that is compatiable with %s.', Plugin_Name()->name, Plugin_Name()->name ), PLUGIN_NAME_TEXT_DOMAIN ); ?></p>
	<p class="submit"><a href="<?php echo esc_url( apply_filters( 'plugin_name_theme_docs_url', Plugin_Name()->doc_url . 'theme-compatibility-intergration/', 'theme-compatibility' ) ); ?>" class="button-primary"><?php _e( 'Theme Integration Guide', PLUGIN_NAME_TEXT_DOMAIN ); ?></a> <a class="skip button-primary" href="<?php echo esc_url( add_query_arg( 'hide_plugin_name_theme_support_check', 'true' ) ); ?>"><?php _e( 'Hide this notice', PLUGIN_NAME_TEXT_DOMAIN ); ?></a></p>
</div>
