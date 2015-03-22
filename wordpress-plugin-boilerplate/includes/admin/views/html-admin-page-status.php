<?php
/**
 * Admin View: Page - Status
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$current_tab = ! empty( $_REQUEST['tab'] ) ? sanitize_title( $_REQUEST['tab'] ) : 'status';
?>
<div class="wrap plugin-name plugin-name-status">
	<h2 class="nav-tab-wrapper">
	<?php echo Plugin_Name()->name; ?>
	<?php
		$tabs = apply_filters( 'plugin_name_system_tools_tabs', array(
			'status' => __( 'System Status', PLUGIN_NAME_TEXT_DOMAIN ),
			'tools'  => __( 'Tools', PLUGIN_NAME_TEXT_DOMAIN ),
			//'import'  => __( 'Import', PLUGIN_NAME_TEXT_DOMAIN ),
			//'export'  => __( 'Export', PLUGIN_NAME_TEXT_DOMAIN ),
		) );
		foreach ( $tabs as $name => $label ) {
			echo '<a href="' . admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-status&tab=' . $name ) . '" class="nav-tab ';
			if ( $current_tab == $name ) echo 'nav-tab-active';
			echo '">' . $label . '</a>';
		}
	?>
	</h2><br/>
	<?php
		switch ( $current_tab ) {
			case "import" :
				Plugin_Name_Admin_Status::status_port( 'import' );
				break;
			case "export" :
				Plugin_Name_Admin_Status::status_port( 'export' );
				break;
			case "tools" :
				Plugin_Name_Admin_Status::status_tools();
				break;
			default :
				Plugin_Name_Admin_Status::status_report();
				break;
		}
	?>
</div>
