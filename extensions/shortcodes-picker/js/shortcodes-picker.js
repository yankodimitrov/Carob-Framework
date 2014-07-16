/*--------------------------------------
 * Carob Shortcodes Picker
 *
 * @version  1.0
 --------------------------------------*/
jQuery(document).ready( function($){

	window.CarobShortcodes = {};

	CarobShortcodes.editFrame = null;
	CarobShortcodes.editFrameTitle = '';

	/**
	 * Templates
	 * 
	 */
	CarobShortcodes.templates = {
		modal: $('#carob-tmpl-shortcodes').html()
	};

	/**
	 * Open Shortcodes Modal
	 * 
	 */
	CarobShortcodes.openModal = function() {
		
		if( CarobShortcodes.editFrame == null ) {
				
			CarobShortcodes.editFrame = new CarobShortcodes.Views.ShotcodesFrame();
			$('body').append( CarobShortcodes.editFrame.render().$el );
		}
		
		CarobShortcodes.editFrame.open();
	}

	/*---------------------------*
	 * Views
	 *---------------------------*/
	CarobShortcodes.Views = {};

	/**
	 * Shotcodes Frame
	 * 
	 */
	CarobShortcodes.Views.ShotcodesFrame = Backbone.View.extend({

		tagName: 'div',
		className: 'carob-edit-frame-wrap',
		template: _.template( CarobShortcodes.templates.modal ),
		title: null,
		optionsForm: null,
		optionsWrap: null,
		insertButton: null,
		loader: null,
		request: null,
		
		events: {
			'click .media-modal-backdrop': 'close',
			'click .media-modal-close': 'close',
			'click .button-insert': 'insertClick'
		},

		render: function() {
			
			this.$el.html( this.template() );
			
			this.optionsForm = this.$el.find('#carob-shortcode-options-form');
			this.optionsWrap = this.$el.find('.carob-shortcode-options');
			this.loader = this.$el.find('.loader');
			this.insertButton = this.$el.find('.button-insert');
			this.title = this.$el.find('.carob-frame-title');
			
			this.insertButton.hide();

			return this;
		},

		isJSON: function( string ) {
			
			string = _.unescape( string );

			try {

				JSON.parse( string );

			} catch (e) {

				return false;
			}

			return true;
		},

		open: function() {
			
			this.$el.show();
			this.loader.fadeIn(300);
			this.getShortcodes();
		},

		close: function(e) {
			
			if(e) {
				e.preventDefault();
			}

			// unbind options events
			Carob.destroyOptions( this.optionsWrap );
			this.removeShortcodesList();
			
			// cancel AJAX request
			if( this.request ) {
				this.request.abort();
			}

			CarobShortcodes.editFrame.title.html( CarobShortcodes.editFrameTitle );

			// hide frame and remove options
			this.loader.fadeOut(0);
			this.$el.hide();
			this.optionsWrap.empty();
		},

		initShortcodesList: function() {
			
			this.optionsWrap.find('.carob-shortcode').each( function(){

				$(this).on('click', CarobShortcodes.editFrame.shortcodeClick);
			});
		},

		removeShortcodesList: function() {
			
			this.optionsWrap.find('.carob-shortcode').each( function(){

				$(this).off();
				$(this).remove();
			});

			this.optionsWrap.empty();
		},

		shortcodeClick: function() {

			var data = $(this).attr('data-shortcode'),
				shortcode = JSON.parse( _.unescape( data ) ),
				title;

			if( shortcode.has_options == false ) {

				CarobShortcodes.editFrame.insertShortcode( shortcode );
			
			} else {
				
				CarobShortcodes.editFrameTitle = CarobShortcodes.editFrame.title.html();

				title = shortcode.title + ' ' + CarobShortcodes_l10n.optionsTitle;

				CarobShortcodes.editFrame.removeShortcodesList();
				CarobShortcodes.editFrame.title.html( title );
				CarobShortcodes.editFrame.loader.fadeIn(300);
				CarobShortcodes.editFrame.getShortcodeOptions( shortcode );
			}
		},

		insertClick: function(e) {
			
			e.preventDefault();
			
			var serialized_array = this.optionsForm.serializeArray(),
				data = {},
				obj_value = null,
				options = [],
				content = '';

			_.each( serialized_array, function( item ) {
				
				if( item.name == 'crb-sh-content' ) {
					
					content = item.value;
				
				} else {

					data = {};
					data.name = item.name;
					data.value = item.value;

					// if value is JSON string
					if( CarobShortcodes.editFrame.isJSON( data.value ) ) {
						
						data.value = _.unescape( data.value ); 
						obj_value = JSON.parse( data.value );

						if( obj_value.id ) {
							
							data.value = obj_value.id;
						}
					}

					// match data in array format
					if( data.value.match( /^\[[A-Za-z0-9,]+\]$/g ) ) {
						
						// remove array brackets
						data.value = data.value.replace(/[\[\]]/g, '');
					}

					options.push(data);
				}
			});

			this.shortcode.options = options;
			this.shortcode.content = content;

			this.insertShortcode( this.shortcode );
		},

		insertShortcode: function( shortcode ) {

			var shortcode_str = '',
				option_str,
				option_name = '';

			// open shortcode
			shortcode_str += '[' + shortcode.name;

			// add shortcode options
			if( shortcode.options ) {
				
				_.each( shortcode.options, function( option ){
					
					option_name = option.name.replace('crb-sh-', '');
					option_str = option_name += '="' + option.value + '"';
					shortcode_str += ' ' + option_str; 
				});
			}

			shortcode_str += '] ';

			// close shortcode if it has content
			if( shortcode.has_content == true ) {

				if( shortcode.content ) {
				
					shortcode_str += shortcode.content;
				}

				shortcode_str += ' [/' + shortcode.name + ']';
			}

			wp.media.editor.insert( shortcode_str );
			this.close();
		},

		getShortcodes: function() {

			this.request = $.ajax({
				context: this,
		        type: 'post',
		        url: ajaxurl,
		        data: { 
		        	action: 'carob_list_shortcodes',
		        	nonce: CarobShortcodes_l10n.nonce
		        },
		        success: function(data) {

		        	this.loader.fadeOut(300);
		        	this.optionsWrap.html( data );
					this.initShortcodesList();
				}
			});

		},

		getShortcodeOptions: function( shortcode ) {

			this.shortcode = shortcode;

			this.request = $.ajax({
				context: this,
		        type: 'post',
		        url: ajaxurl,
		        data: { 
		        	action: 'carob_edit_shortcode',
		        	shortcode: shortcode.id,
		        	nonce: CarobShortcodes_l10n.nonce
		        },
		        success: function(data) {

		        	this.insertButton.show();
		        	this.loader.fadeOut(300);
					this.optionsWrap.html( data );
					
					Carob.initOptions( this.optionsWrap );
				}
			});

		}

	});
});