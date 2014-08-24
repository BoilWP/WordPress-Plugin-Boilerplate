<div id="message" class="plugin-name-message">
	<p><?php _e( 'Please include this information when requesting support:', PLUGIN_NAME_TEXT_DOMAIN ); ?> </p>
	<p class="submit debug-report"><a href="#" class="button-primary debug-report"><?php _e( 'Get System Report', PLUGIN_NAME_TEXT_DOMAIN ); ?></a></p>
	<div id="debug-report"><textarea readonly="readonly"></textarea></div>
</div>
<br/>
<table class="plugin_name_status_table widefat" cellspacing="0">

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Environment', PLUGIN_NAME_TEXT_DOMAIN ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td><?php _e( 'Home URL', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo home_url(); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'Site URL', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo site_url(); ?></td>
		</tr>
		<tr>
			<td><?php echo sprintf( __( '%s Version', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?>:</td>
			<td><?php echo esc_html( Plugin_Name()->version ); ?></td>
		</tr>
		<tr>
			<td><?php echo sprintf( __( '%s Database Version', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?>:</td>
			<td><?php echo esc_html( get_option( 'plugin_name_db_version' ) ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Version', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php
				if ( get_bloginfo('version') < Plugin_Name()->wp_version_min ) {
					echo '<mark class="error">';
				}
				else {
					echo '<mark class="yes">';
				}
				bloginfo('version');
				echo '</mark>';
			?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Multisite Enabled', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php
				if ( is_multisite() ) {
					echo __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN );
				}
				else{
					echo __( 'No', PLUGIN_NAME_TEXT_DOMAIN );
				}
			?></td>
		</tr>
		<tr>
			<td><?php _e( 'Web Server Info', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'PHP Version', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php 
				if ( function_exists( 'phpversion' ) ) {
					if( phpversion() < '5.2.4' ) {
						echo '<mark class="error">';
					}
					else {
						echo '<mark class="yes">';
					}
					echo esc_html( phpversion() );
					echo '</mark>';
				}
			?></td>
		</tr>
		<tr>
			<td><?php _e( 'MySQL Version', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php
				global $wpdb;
				$mysql_version = $wpdb->db_version();
				if( $mysql_version < '5.0' ) {
					echo '<mark class="error">';
				}
				else {
					echo '<mark class="yes">';
				}
				echo esc_html( $mysql_version );
				echo '</mark>';
				?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Memory Limit', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php
				$memory = plugin_name_let_to_num( WP_MEMORY_LIMIT );
				$memory_limit = plugin_name_let_to_num( Plugin_Name()->memory_limit );

				if ( $memory < $memory_limit ) {
					echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least ' . $memory_limit . 'MB. See: <a href="%s" target="_blank">Increasing memory allocated to PHP</a>', PLUGIN_NAME_TEXT_DOMAIN ), size_format( $memory ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
				}
				else {
					echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
				}
			?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Debug Mode', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ) . '</mark>'; else echo '<mark class="no">' . __( 'No', PLUGIN_NAME_TEXT_DOMAIN ) . '</mark>'; ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Language', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php if ( defined( 'WPLANG' ) && WPLANG ) echo WPLANG; else  _e( 'Default', PLUGIN_NAME_TEXT_DOMAIN ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Max Upload Size', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo size_format( wp_max_upload_size() ); ?></td>
		</tr>
		<?php if ( function_exists( 'ini_get' ) ) { ?>
			<tr>
				<td><?php _e('PHP Post Max Size', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
				<td><?php echo size_format( plugin_name_let_to_num( ini_get('post_max_size') ) ); ?></td>
			</tr>
			<tr>
				<td><?php _e('PHP Time Limit', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
				<td><?php echo ini_get('max_execution_time'); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'PHP Max Input Vars', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
				<td><?php echo ini_get('max_input_vars'); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'SUHOSIN Installed', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
				<td><?php echo extension_loaded( 'suhosin' ) ? __( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ) : __( 'No', PLUGIN_NAME_TEXT_DOMAIN ); ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td><?php echo sprintf( __( '%s Logging', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?>:</td>
			<td><?php
				if ( @fopen( Plugin_Name()->plugin_path() . '/logs/logs.txt', 'a' ) )
					echo '<mark class="yes">' . __( 'Log directory is writable.', PLUGIN_NAME_TEXT_DOMAIN ) . '</mark>';
				else
					echo '<mark class="error">' . __( 'Log directory (<code>plugin-name/logs/</code>) is not writable. Logging will not be possible.', PLUGIN_NAME_TEXT_DOMAIN ) . '</mark>';
			?></td>
		</tr>
		<tr>
			<td><?php _e( 'Default Timezone', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php
				$default_timezone = date_default_timezone_get();
				if ( 'UTC' !== $default_timezone ) {
					echo '<mark class="error">' . sprintf( __( 'Default timezone is %s - it should be UTC', PLUGIN_NAME_TEXT_DOMAIN ), $default_timezone ) . '</mark>';
				} else {
					echo '<mark class="yes">' . sprintf( __( 'Default timezone is %s', PLUGIN_NAME_TEXT_DOMAIN ), $default_timezone ) . '</mark>';
				} ?>
			</td>
		</tr>
		<?php
			$posting = array();

			// fsockopen/cURL
			$posting['fsockopen_curl']['name'] = __( 'fsockopen/cURL', PLUGIN_NAME_TEXT_DOMAIN);
			if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
				if ( function_exists( 'fsockopen' ) && function_exists( 'curl_init' )) {
					$posting['fsockopen_curl']['note'] = __('Your server has fsockopen and cURL enabled.', PLUGIN_NAME_TEXT_DOMAIN );
				} elseif ( function_exists( 'fsockopen' )) {
					$posting['fsockopen_curl']['note'] = __( 'Your server has fsockopen enabled, cURL is disabled.', PLUGIN_NAME_TEXT_DOMAIN );
				} else {
					$posting['fsockopen_curl']['note'] = __( 'Your server has cURL enabled, fsockopen is disabled.', PLUGIN_NAME_TEXT_DOMAIN );
				}
				$posting['fsockopen_curl']['success'] = true;
			} else {
				$posting['fsockopen_curl']['note'] = __( 'Your server does not have fsockopen or cURL enabled - Various scripts which communicate with other servers will not work. Contact your hosting provider.', PLUGIN_NAME_TEXT_DOMAIN ). '</mark>';
				$posting['fsockopen_curl']['success'] = false;
			}

			// SOAP
			$posting['soap_client']['name'] = __( 'SOAP Client', PLUGIN_NAME_TEXT_DOMAIN );
			if ( class_exists( 'SoapClient' ) ) {
				$posting['soap_client']['note'] = __('Your server has the SOAP Client class enabled.', PLUGIN_NAME_TEXT_DOMAIN );
				$posting['soap_client']['success'] = true;
			} else {
				$posting['soap_client']['note'] = sprintf( __( 'Your server does not have the <a href="%s">SOAP Client</a> class enabled - some features of the plugin which use SOAP may not work as expected.', PLUGIN_NAME_TEXT_DOMAIN ), 'http://php.net/manual/en/class.soapclient.php' ) . '</mark>';
				$posting['soap_client']['success'] = false;
			}

			$posting = apply_filters( 'plugin_name_debug_posting', $posting );

			foreach( $posting as $post ) { $mark = ( isset( $post['success'] ) && $post['success'] == true ) ? 'yes' : 'error';
				?>
				<tr>
					<td><?php echo esc_html( $post['name'] ); ?>:</td>
					<td>
						<mark class="<?php echo $mark; ?>">
							<?php echo wp_kses_data( $post['note'] ); ?>
						</mark>
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Plugins', PLUGIN_NAME_TEXT_DOMAIN ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td><?php _e( 'Installed Plugins', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php
				$active_plugins = (array) get_option( 'active_plugins', array() );

				if ( is_multisite() ) {
					$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
				}

				$plugin_name_plugins = array();

				foreach ( $active_plugins as $plugin ) {

					$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
					$dirname        = dirname( $plugin );
					$version_string = '';

					if ( ! empty( $plugin_data['Name'] ) ) {

						// link the plugin name to the plugin url if available
						$plugin_name = $plugin_data['Name'];
						if ( ! empty( $plugin_data['PluginURI'] ) ) {
							$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . __( 'Visit plugin homepage', PLUGIN_NAME_TEXT_DOMAIN ) . '">' . $plugin_name . '</a>';
						}

						if ( strstr( $dirname, PLUGIN_NAME_TEXT_DOMAIN ) ) {

							if ( false === ( $version_data = get_transient( $plugin . '_version_data' ) ) ) {
								$changelog = wp_remote_get( Plugin_Name()->changelog_url . $dirname . '/changelog.txt' );
								$cl_lines  = explode( "\n", wp_remote_retrieve_body( $changelog ) );
								if ( ! empty( $cl_lines ) ) {
									foreach ( $cl_lines as $line_num => $cl_line ) {
										if ( preg_match( '/^[0-9]/', $cl_line ) ) {

											$date         = str_replace( '.' , '-' , trim( substr( $cl_line , 0 , strpos( $cl_line , '-' ) ) ) );
											$version      = preg_replace( '~[^0-9,.]~' , '' ,stristr( $cl_line , "version" ) );
											$update       = trim( str_replace( "*" , "" , $cl_lines[ $line_num + 1 ] ) );
											$version_data = array( 'date' => $date , 'version' => $version , 'update' => $update , 'changelog' => $changelog );
											set_transient( $plugin . '_version_data', $version_data , 60*60*12 );
											break;
										}
									}
								}
							}

							if ( ! empty( $version_data['version'] ) && version_compare( $version_data['version'], $plugin_data['Version'], '!=' ) )
								$version_string = ' &ndash; <strong style="color:red;">' . $version_data['version'] . ' ' . __( 'is available', PLUGIN_NAME_TEXT_DOMAIN ) . '</strong>';
						}

						$plugin_name_plugins[] = $plugin_name . ' ' . __( 'by', PLUGIN_NAME_TEXT_DOMAIN ) . ' ' . $plugin_data['Author'] . ' ' . __( 'Version', PLUGIN_NAME_TEXT_DOMAIN ) . ' ' . $plugin_data['Version'] . $version_string;

					}
				}

				if ( sizeof( $plugin_name_plugins ) == 0 ) {
					echo '-';
				}
				else {
					echo implode( ', <br/>', $plugin_name_plugins );
				}
			?></td>
		</tr>
	</tbody>

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Settings', PLUGIN_NAME_TEXT_DOMAIN ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td><?php _e( 'Force SSL', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo get_option( 'plugin_name_force_ssl' ) === 'yes' ? '<mark class="yes">'.__( 'Yes', PLUGIN_NAME_TEXT_DOMAIN ).'</mark>' : '<mark class="no">'.__( 'No', PLUGIN_NAME_TEXT_DOMAIN ).'</mark>'; ?></td>
		</tr>
	</tbody>

	<thead>
		<tr>
			<th colspan="2"><?php echo sprintf( __( '%s Pages', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php
			$check_pages = apply_filters( 'plugin_name_status_report_check_pages', array(

				__( 'Sample Page', PLUGIN_NAME_TEXT_DOMAIN ) => array(
						'option' 	=> 'plugin_name_select_single_page_id',
						'shortcode' => '[shortcode]'
				),

				__( 'Example Page', PLUGIN_NAME_TEXT_DOMAIN ) => array(
						'option' 	=> 'plugin_name_example_page_id',
						'shortcode' => ''
				),

				__( 'Shortcode Example Page', PLUGIN_NAME_TEXT_DOMAIN ) => array(
						'option' 	=> 'plugin_name_shortcode_page_id',
						'shortcode' => '[caption'
				),

			) );

			$alt = 1;

			foreach ( $check_pages as $page_name => $values ) {

				if ( $alt == 1 ) echo '<tr>'; else echo '<tr>';

				echo '<td>' . esc_html( $page_name ) . ':</td><td>';

				$error = false;

				$page_id = get_option( $values['option'] );

				// Page ID check
				if ( ! $page_id ) {
					echo '<mark class="error">' . __( 'Page not set', PLUGIN_NAME_TEXT_DOMAIN ) . '</mark>';
					$error = true;
				}
				else {
					// Shortcode check
					if ( $values['shortcode'] ) {
						$page = get_post( $page_id );

						if ( empty( $page ) ) {
							echo '<mark class="error">' . sprintf( __( 'Page does not exist', PLUGIN_NAME_TEXT_DOMAIN ) ) . '</mark>';
							$error = true;
						}
						else if ( ! strstr( $page->post_content, $values['shortcode'] ) ) {
							echo '<mark class="error">' . sprintf( __( 'Page does not contain the shortcode: %s', PLUGIN_NAME_TEXT_DOMAIN ), $values['shortcode'] ) . '</mark>';
							$error = true;
						}
					}
				}

				if ( ! $error ) echo '<mark class="yes">' . __( 'Page ID', PLUGIN_NAME_TEXT_DOMAIN ) . ': <strong>#' . absint( $page_id ) . '</strong> - ' . __( 'Page Slug', PLUGIN_NAME_TEXT_DOMAIN ) . ': <strong>' . str_replace( home_url(), '', get_permalink( $page_id ) ) . '</strong></mark>';

				echo '</td></tr>';

				$alt = $alt * -1;
			}
		?>
	</tbody>

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Theme', PLUGIN_NAME_TEXT_DOMAIN ); ?></th>
		</tr>
	</thead>

	<?php
	$active_theme = wp_get_theme();
	if ( $active_theme->{'Author URI'} == Plugin_Name()->theme_author_url ) {

		$theme_dir = strtolower( str_replace( ' ','', $active_theme->Name ) );

		if ( false === ( $theme_version_data = get_transient( $theme_dir . '_version_data' ) ) ) {

			$theme_changelog = wp_remote_get( Plugin_Name()->changelog_url . $theme_dir . '/changelog.txt' );
			$cl_lines  = explode( "\n", wp_remote_retrieve_body( $theme_changelog ) );
			if ( ! empty( $cl_lines ) ) {

				foreach ( $cl_lines as $line_num => $cl_line ) {
					if ( preg_match( '/^[0-9]/', $cl_line ) ) {

						$theme_date    		= str_replace( '.' , '-' , trim( substr( $cl_line , 0 , strpos( $cl_line , '-' ) ) ) );
						$theme_version      = preg_replace( '~[^0-9,.]~' , '' ,stristr( $cl_line , "version" ) );
						$theme_update       = trim( str_replace( "*" , "" , $cl_lines[ $line_num + 1 ] ) );
						$theme_version_data = array( 'date' => $theme_date , 'version' => $theme_version , 'update' => $theme_update , 'changelog' => $theme_changelog );
						set_transient( $theme_dir . '_version_data', $theme_version_data , 60*60*12 );
						break;

					}
				}

			}

		}

	}
	?>

	<tbody>
		<tr>
			<td><?php _e( 'Theme Name', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo $active_theme->Name; ?></td>
		</tr>
		<tr>
			<td><?php _e( 'Theme Version', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php 
			echo $active_theme->Version; 
			if ( ! empty( $theme_version_data['version'] ) && version_compare( $theme_version_data['version'], $active_theme->Version, '!=' ) ) {
				echo ' &ndash; <strong style="color:red;">' . $theme_version_data['version'] . ' ' . __( 'is available', PLUGIN_NAME_TEXT_DOMAIN ) . '</strong>';
			}
			?></td>
		</tr>
		<tr>
			<td><?php _e( 'Author URL', PLUGIN_NAME_TEXT_DOMAIN ); ?>:</td>
			<td><?php echo $active_theme->{'Author URI'}; ?></td>
		</tr>
	</tbody>

</table>

<script type="text/javascript">
	/*
	@var i string default
	@var l how many repeat s
	@var s string to repeat
	@var w where s should indent
	*/
	jQuery.plugin_name_strPad = function(i,l,s,w) {
		var o = i.toString();
		if (!s) { s = '0'; }
		while (o.length < l) {
			// empty
			if(w == 'undefined'){
				o = s + o;
			}else{
				o = o + s;
			}
		}
		return o;
	};

	jQuery('a.debug-report').click(function(){

		var report = "";

		jQuery('.plugin_name_status_table thead, .plugin_name_status_table tbody').each(function(){
			if ( jQuery( this ).is('thead') ) {
				report = report + "\n### " + jQuery.trim( jQuery( this ).text() ) + " ###\n\n";
			}
			else {

				jQuery('tr', jQuery( this )).each(function(){
					var the_name    = jQuery.plugin_name_strPad( jQuery.trim( jQuery( this ).find('td:eq(0)').text() ), 25, ' ' );
					var the_value   = jQuery.trim( jQuery( this ).find('td:eq(1)').text() );
					var value_array = the_value.split( ', ' );

					if ( value_array.length > 1 ){
						// if value have a list of plugins ','
						// split to add new line
						var output = '';
						var temp_line ='';
						jQuery.each( value_array, function(key, line){
							var tab = ( key == 0 )?0:25;
							temp_line = temp_line + jQuery.plugin_name_strPad( '', tab, ' ', 'f' ) + line +'\n';
						});

						the_value = temp_line;
					}

					report = report +''+ the_name + the_value + "\n";
				});

			}
		} );

		try {
			jQuery("#debug-report").slideDown();
			jQuery("#debug-report textarea").val( report ).focus().select();
			jQuery(this).fadeOut();
			return false;
		} catch(e){ console.log( e ); }

		return false;
	});
</script>