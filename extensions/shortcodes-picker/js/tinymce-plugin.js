jQuery(document).ready( function($){

	tinymce.create('tinymce.plugins.CarobShortcodesPicker', {

		init : function(ed, url) {

			ed.addCommand('carob_shortcodes_picker', function() {
				
				CarobShortcodes.openModal();
			});

			ed.addButton('carob_shortcodes_picker', {
				title : 'Carob Shortcodes',
				cmd : 'carob_shortcodes_picker',
				image : url.replace('js', 'images') + '/shortcodes-button.png'
			});
		},
	});

    tinymce.PluginManager.add('carob_shortcodes_picker', tinymce.plugins.CarobShortcodesPicker);
	
});