<div class="wrap plugin_name">
	<form method="post" id="mainform" action="" enctype="multipart/form-data">
		<div class="icon32 icon32-plugin-name-settings" id="icon-plugin-name"><br /></div><h2 class="nav-tab-wrapper">
			<?php
				foreach ( $tabs as $name => $label ) {
					echo '<a href="' . admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings&tab=' . $name ) . '" class="nav-tab ' . ( $current_tab == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
				}

				do_action( 'plugin_name_settings_tabs' );
			?>
		</h2>

		<?php
		do_action( 'plugin_name_sections_' . $current_tab );
		do_action( 'plugin_name_settings_' . $current_tab );
		?>

		<p class="submit">
			<?php if ( ! isset( $GLOBALS['hide_save_button'] ) ) : ?>
				<input name="save" class="button-primary" type="submit" value="<?php _e( 'Save changes', PLUGIN_NAME_TEXT_DOMAIN ); ?>" />
			<?php endif; ?>
			<input type="hidden" name="subtab" id="last_tab" />
			<?php wp_nonce_field( 'plugin-name-settings' ); ?>
		</p>
	</form>
</div>