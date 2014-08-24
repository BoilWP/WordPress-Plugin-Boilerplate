<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="message" class="updated plugin-name-message">
	<p><?php echo sprintf( __( '<strong>%s Data Update Required</strong> &#8211; We just need to update your install to the latest version', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?></p>
	<p class="submit"><a href="<?php echo add_query_arg( 'do_update_plugin_name', 'true', admin_url('admin.php?page=' . PLUGIN_NAME_PAGE . '-settings') ); ?>" class="plugin-name-update-now button-primary"><?php _e( 'Run the updater', PLUGIN_NAME_TEXT_DOMAIN ); ?></a></p>
</div>
<script type="text/javascript">
	jQuery('.plugin-name-update-now').click('click', function(){
		var answer = confirm( '<?php _e( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', PLUGIN_NAME_TEXT_DOMAIN ); ?>' );
		return answer;
	});
</script>