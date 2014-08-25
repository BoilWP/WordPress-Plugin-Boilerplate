<form method="post" action="options.php">

	<?php settings_fields( 'plugin_name_status_settings_fields' ); ?>

	<?php $options = wp_parse_args( get_option( 'plugin_name_status_options', array() ), array( 'uninstall_data' => 0 ) ); ?>

	<table class="plugin_name_status_table widefat" cellspacing="0">
		<thead class="tools">
			<tr>
				<th colspan="2"><?php _e( 'Tools', PLUGIN_NAME_TEXT_DOMAIN ); ?></th>
			</tr>
		</thead>
		<tbody class="tools">
			<?php foreach( $tools as $action => $tool ) { ?>
				<tr>
					<td><?php echo esc_html( $tool['name'] ); ?></td>
					<td>
						<p>
							<a href="<?php echo wp_nonce_url( admin_url('admin.php?page=' . PLUGIN_NAME_PAGE . '-status&tab=tools&action=' . $action ), 'debug_action' ); ?>" class="button"><?php echo esc_html( $tool['button'] ); ?></a>
							<span class="description"><?php echo wp_kses_post( $tool['desc'] ); ?></span>
						</p>
					</td>
				</tr>
			<?php } ?>
	 		<tr>
				<td><?php _e( 'Remove all data on uninstall', PLUGIN_NAME_TEXT_DOMAIN ); ?></td>
	 			<td>
	 				<p>
						<label><input type="checkbox" class="checkbox" name="plugin_name_status_options[uninstall_data]" value="1" <?php checked( '1', $options['uninstall_data'] ); ?> /> <?php _e( 'Enabled', PLUGIN_NAME_TEXT_DOMAIN ); ?></label>
					</p>
					<p>
						<span class="description"><?php _e( 'This tool will delete all data when uninstalling via Plugins > Delete.', PLUGIN_NAME_TEXT_DOMAIN ); ?></span>
	 				</p>
	 			</td>
	 		</tr>
		</tbody>
	</table>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', PLUGIN_NAME_TEXT_DOMAIN ) ?>" />
	</p>

</form>