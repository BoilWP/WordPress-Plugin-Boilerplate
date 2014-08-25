/**
 * Plugin Name Admin JS
 */
jQuery(function(){

	jQuery("body").click(function(){
		jQuery('.plugin_name_error_tip').fadeOut('100', function(){ jQuery(this).remove(); } );
	});

	// Tooltips
	jQuery(".tips, .help_tip").tipTip({
		'attribute' : 'data-tip',
		'fadeIn' : 50,
		'fadeOut' : 50,
		'delay' : 200
	});

	// Availability inputs
	jQuery('select.availability').change(function(){
		if ( jQuery(this).val() == "all" ) {
			jQuery(this).closest('tr').next('tr').hide();
		}
		else {
			jQuery(this).closest('tr').next('tr').show();
		}
	}).change();

	// Hidden options
	jQuery('.hide_options_if_checked').each(function(){

		jQuery(this).find('input:eq(0)').change(function() {

			if (jQuery(this).is(':checked')) {
				jQuery(this).closest('fieldset, tr').nextUntil( '.hide_options_if_checked, .show_options_if_checked', '.hidden_option').hide();
			}
			else {
				jQuery(this).closest('fieldset, tr').nextUntil( '.hide_options_if_checked, .show_options_if_checked', '.hidden_option').show();
			}

		}).change();

	});

	jQuery('.show_options_if_checked').each(function(){

		jQuery(this).find('input:eq(0)').change(function() {

			if (jQuery(this).is(':checked')) {
				jQuery(this).closest('fieldset, tr').nextUntil( '.hide_options_if_checked, .show_options_if_checked', '.hidden_option').show();
			}
			else {
				jQuery(this).closest('fieldset, tr').nextUntil( '.hide_options_if_checked, .show_options_if_checked', '.hidden_option').hide();
			}

		}).change();

	});

	jQuery('input#plugin_name_checkbox').change(function() {
		if (jQuery(this).is(':checked')) {
			jQuery('#plugin_name_input_text').closest('tr').show();
		}
		else {
			jQuery('#plugin_name_input_text').closest('tr').hide();
		}
	}).change();

});