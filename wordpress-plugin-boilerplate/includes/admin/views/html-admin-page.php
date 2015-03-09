<div class="wrap plugin_name">
	<h2>
		<?php echo Plugin_Name()->name; ?>
		<?php
		/**
		 * These header links do not have to be external.
		 * You may change the links to an internal link connected with the plugin.
		 */
		$links = apply_filters( 'plugin_name_admin_header_links', array(
			Plugin_Name()->web_url . '?utm_source=wpadmin&utm_campaign=header' => __( 'Website', PLUGIN_NAME_TEXT_DOMAIN ),
			Plugin_Name()->doc_url . '?utm_source=wpadmin&utm_campaign=header' => __( 'Documentation', PLUGIN_NAME_TEXT_DOMAIN ),
		) );

		$text = '';

		foreach( $links as $key => $value ) {
			$text .= '<a class="add-new-h2" href="' . $key . '">' . $value . '</a>';
		}

		echo $text;
		?>
	</h2>

	<ul class="subsubsub">
		<?php
			$links = apply_filters( 'plugin_name_section_links', array(
				''      => __( 'Default', PLUGIN_NAME_TEXT_DOMAIN ),
				'two'   => __( 'Section Two', PLUGIN_NAME_TEXT_DOMAIN ),
				'three' => __( 'Section Three', PLUGIN_NAME_TEXT_DOMAIN ),
			) );

			$i = 0;

			foreach ( $links as $link => $name ) {
				$i ++;
				?><li><a class="<?php if ( $view == $link ) { echo 'current'; } ?>" href="<?php echo admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '&view=' . esc_attr( $link ) ); ?>"><?php echo $name; ?></a><?php if ( $i != sizeof( $links ) ) { echo '|'; } ?></li><?php
			}
		?>
	</ul>
	<br class="clear" />

	<?php do_action('plugin_name_page_header'); ?>

	<?php do_action('plugin_name_page_' . $view . '_header'); ?>

	<?php
	/**
	 * The paragraphs below were added just as an example and to explain what this page can do.
	 * You may remove it but leave the hooks in place if you still want to use them.
	 */
	if( empty($view) ) $view = 'default'; echo '<h3>You are viewing section <em>' . $view . '</em></h3>';
	?>

	<p class="about-description"><?php _e( 'You can use this page to place the main back feature of your plugin. Place links at the end of your header and set the page into sections.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>
	<p><?php _e( 'These sections can then display different content based on the section the user is viewing.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>
	<p><?php _e( 'There are many actions and filters in place to allow you to add and display anything you need.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

	<?php echo $page_content; ?>

	<?php do_action('plugin_name_page_' . $view . '_footer'); ?>

	<?php do_action('plugin_name_page_footer'); ?>

</div>
