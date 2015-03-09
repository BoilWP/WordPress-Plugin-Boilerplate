<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="message" class="updated plugin-name-message">
	<p><?php echo sprintf( __( '<strong>Welcome to %s</strong> &#8211; You\'re almost ready to start using this plugin :)', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?></p>
	<p class="submit"><a href="<?php echo add_query_arg( 'install_plugin_name_pages', 'true', admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings' ) ); ?>" class="button-primary"><?php echo sprintf( __( 'Install %s Pages', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?></a> <a class="skip button-primary" href="<?php echo add_query_arg( 'skip_install_plugin_name_pages', 'true', admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings' ) ); ?>"><?php _e( 'Skip setup', PLUGIN_NAME_TEXT_DOMAIN ); ?></a></p>
</div>
