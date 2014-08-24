/**
 * Plugin Name Admin Menu JS
 */
jQuery(function($){

	if( plugin_name_admin_params.full_settings_menu == 'yes' ) {
		// Hide the 'Settings' item under the custom menu
		$('.wp-submenu-head:contains("' + plugin_name_admin_params.plugin_menu_name + '")').next().next().children().hide();
	}

	// Hide the 'My Plugin' item under the custom menu
	$('.wp-submenu-head:contains("' + plugin_name_admin_params.plugin_menu_name + '")').next().children(':first').hide();

	// Mark the proper list item as active
	var path = document.location.href.split('&')[1]; // This will fetch ex. 'tab=tab_one' assuming &tab=* is first after ?page=plugin-name-settings
	if( path !== undefined && path !== null && path.length > 1 ) 

	var aActiveTab = path.split('tab='); // This returns the value of the tab

	if( aActiveTab !== undefined && aActiveTab !== null && aActiveTab.length > 1 ) {

		var sActiveTab = aActiveTab[1];

		// First Tab
		if( sActiveTab == 'tab_one' ) {
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params._tab_one + ')').parent().addClass('current');
		} // end if

		// Second Tab
		if( sActiveTab == 'tab_two' ) {
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params._tab_two + ')').parent().addClass('current');
		} // end if

		// Tools Tab
		if( sActiveTab == 'tools' ) {
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params.system_status + ')').parent().removeClass('current');
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params.tools + ')').parent().addClass('current');
		} // end if

		// Import Tab
		if( sActiveTab == 'import' ) {
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params.system_status + ')').parent().removeClass('current');
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params._import + ')').parent().addClass('current');
		} // end if

		// Export Tab
		if( sActiveTab == 'export' ) {
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params.system_status + ')').parent().removeClass('current');
			$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params._export + ')').parent().addClass('current');
		} // end if

	} else {

		// If they click the top-level menu item, we'll default to the first tab in the settings
		$('li.toplevel_page_' + plugin_name_admin_params.plugin_screen_id + ' ul.wp-submenu li a:contains(' + plugin_name_admin_params._tab_one + ')').parent().addClass('current');

	} // end if

});