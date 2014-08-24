jQuery(window).load(function(){

	// Countries
	jQuery('select#plugin_name_multi_countries').change(function(){
		if (jQuery(this).val()=="specific") {
			jQuery(this).parent().parent().next('tr').show();
		}
		else {
			jQuery(this).parent().parent().next('tr').hide();
		}
	}).change();

	// Color picker
	jQuery('.colorpick').iris( {
		change: function(event, ui){
			jQuery(this).css( { backgroundColor: ui.color.toString() } );
		},
		hide: true,
		border: true
	} ).each( function() {
		jQuery(this).css( { backgroundColor: jQuery(this).val() } );
	})
	.click(function(){
		jQuery('.iris-picker').hide();
		jQuery(this).closest('.color_box, td').find('.iris-picker').show();
	});

	jQuery('body').click(function() {
		jQuery('.iris-picker').hide();
	});

	jQuery('.color_box, .colorpick').click(function(event){
		event.stopPropagation();
	});

	// Edit prompt
	jQuery(function(){
		var changed = false;

		jQuery('input, textarea, select, checkbox').change(function(){
			changed = true;
		});

		jQuery('.nav-tab-wrapper a').click(function(){
			if (changed) {
				window.onbeforeunload = function() {
					return plugin_name_settings_params.i18n_nav_warning;
				}
			}
			else {
				window.onbeforeunload = '';
			}
		});

		jQuery('.submit input').click(function(){
			window.onbeforeunload = '';
		});
	});

	// Chosen selects
	jQuery("select.chosen_select").chosen({
		width: '350px',
		disable_search_threshold: 5
	});

	jQuery("select.chosen_select_nostd").chosen({
		allow_single_deselect: 'true',
		width: '350px',
		disable_search_threshold: 5
	});

});