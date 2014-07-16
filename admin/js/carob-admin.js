/*--------------------------------------
 * Carob Framework 
 * 
 * @version  1.0
 --------------------------------------*/
jQuery(document).ready(function($){

	window.Carob = {};

	/**
	 * Settings
	 * 
	 */
	Carob.settings = {
		optionsView: $('.carob-options'),
		mediaFrame: null
	};

	/**
	 * Event Dispatcher
	 * 
	 */
	Carob.eventDispatcher = $('body');

	/**
	 * INIT
	 * 
	 */
	Carob.init = function() {
		
		this.settings.optionsView.each( function(){

			Carob.initOptions( $(this) );
		});
	};

	/**
	 * Init Options
	 * 
	 * @param Object context - jQuery object
	 */
	Carob.initOptions = function( context ) {

		this.selectImageOption.addTo( context );
		this.sliderInput.addTo( context );
		this.switchToggle.addTo( context );
		this.colorPicker.addTo( context );
		this.fileUpload.addTo( context );
		this.gallery.addTo( context );
		this.iconPicker.addTo( context );

		this.eventDispatcher.trigger( 'carobInitOptions', context );
	}

	/**
	 * Destroy Options
	 * 
	 * @param Object context - jQuery object
	 */
	Carob.destroyOptions = function( context ) {

		this.selectImageOption.removeFrom( context );
		this.sliderInput.removeFrom( context );
		this.switchToggle.removeFrom( context );
		this.colorPicker.removeFrom( context );
		this.fileUpload.removeFrom( context );
		this.gallery.removeFrom( context );
		this.iconPicker.removeFrom( context );

		this.eventDispatcher.trigger( 'carobDestroyOptions', context );
	};

	/**
	 * Slider Input
	 * 
	 */
	Carob.sliderInput = {

		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-ui-slider').each( function(){

				var startVal = $(this).attr('data-value'),
					fieldV = $('#' + $(this).attr('data-field') ),
					min_v = parseFloat( $(this).attr('data-min') ),
					max_v = parseFloat( $(this).attr('data-max') ),
					step_v = parseFloat( $(this).attr('data-step') );

				$(this).slider({
					value: startVal,
					range: 'min',
					min: min_v,
					max: max_v,
					step: step_v,
					slide: function( event, ui ) {
						fieldV.val(ui.value);
					}
				});

			});

		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-ui-slider').each( function(){
				
				$(this).slider({ slide: null });
				$(this).unbind();

			});
		}

	};

	/**
	 * Select Image Option
	 * 
	 */
	Carob.selectImageOption = {

		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				
				return;
			}

			context.find('.carob-select-image-option').each( function(){

				var target = $( '#' + $(this).attr('data-target-id') );

				$(this).find('a').click( function(e){
					
					e.preventDefault();

					$(this).parent()
							.parent()
								.find('.selected')
									.removeClass('selected');
					
					$(this).parent()
							.addClass('selected');

					target.val( $(this).attr('data-sel-val') );
				});
			});
		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-select-image-option').each( function(){

				$(this).find('li').unbind('click');
			});
		}
	};

	/**
	 * Switch Toggle
	 * 
	 */
	Carob.switchToggle = {

		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-switch-toggle').each( function(){

				$(this).click( function(){

					var val_id = $(this).attr('data-val-id'),
						val_el = $(this).find( '#' + val_id );

					// check toggle state
					if( val_el.val() === 'on' ) {

						$(this).removeClass('state-on')
									.addClass('state-off');

						val_el.val('off');

					}else{

						$(this).removeClass('state-off')
									.addClass('state-on');

						val_el.val('on');
					}
				});

			});

		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-switch-toggle').each( function(){

				$(this).unbind('click');

			});
		}
	};

	/**
	 * Color Picker
	 * 
	 */
	Carob.colorPicker = {
			
		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-color-picker').each( function(){

				$(this).ColorPicker({
					
					onSubmit: function(hsb, hex, rgb, el) {
						
						var c_box = $(el).attr('data-color-box');

						$( '#' + c_box ).css('backgroundColor', '#' + hex );
					
						$(el).val(hex);
						$(el).ColorPickerHide();
					},

					onBeforeShow: function (el) {
						$(this).ColorPickerSetColor( this.value );
					}
				})
				.bind('keyup', function(){
					$(this).ColorPickerSetColor( this.value );
				});

			});

		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-color-picker').each( function(){

				$(this).ColorPicker({ onSubmit: null, onBeforeShow: null });
				$(this).unbind();

			});
		}
	};

	/**
	 * File Upload
	 * 
	 */
	Carob.fileUpload = {

		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-file-button').each( function(){

				var v_field = $(this).prev(),
					url_field = v_field.prev(),
					url_val = url_field.val(),
					file_type = $(this).attr('data-type'),
					img_preview = $( '#' + v_field.attr('id') + '_preview' ),
					title = $(this).attr('data-title'),
					btn_text = $(this).html();

				// Button click
				$(this).click( function(e){

					e.preventDefault();

					Carob.settings.mediaFrame = wp.media.frames.carob_media_frame = wp.media({
						title: title,
				      	button: { text: btn_text, },
				      	frame: 'select',
				      	library: { type: file_type },
				      	multiple: false
					});

					// Frame attachment select
					Carob.settings.mediaFrame.on('select', function(){

						// get selected attachment
						var selected = Carob.settings.mediaFrame.state().get('selection').first().toJSON(),
							attachment = {};

						attachment.id = selected.id;
						attachment.url = selected.url;
						
						// if file type is image update image preview
						if( file_type == 'image' ) {
							
							if( _.isUndefined( selected.sizes ) ) {

								attachment.url = selected.url;

							}else if( ! _.isUndefined( selected.sizes.medium ) ) {
								
								attachment.url = selected.sizes.medium.url;
							}

							img_preview.attr( 'src', attachment.url );
						}

						v_field.val( _.escape( JSON.stringify( attachment ) ) );

						// update url field
						url_field.val( attachment.url );
						url_val = attachment.url;

						
						Carob.settings.mediaFrame = null;

					});

					Carob.settings.mediaFrame.open();

				});
				
				// Handle URL input field change
				url_field.focusout( function(){

					if( file_type != 'image' ) {
						return;
					}

					if( url_val != url_field.val() ) {
						url_val = url_field.val();

						// update field JSON value
						// use id:0 for images that are not
						// from the media library manager
						var ob = { id:0, url: url_val };

						v_field.val( _.escape( JSON.stringify( ob ) ) );

						// update image preview
						if( url_field.val() != '' ) {
							img_preview.attr( 'src', url_val );
						}
					}

				});


			});

		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-file-button').each( function(){

				$(this).unbind('click');
				$(this).prev().prev().unbind('focusout');
				
				if( Carob.settings.mediaFrame ) {
					Carob.settings.mediaFrame.unbind('select');
					Carob.settings.mediaFrame = null;
				}

			});
		}

	};

	/**
	 * Gallery
	 * 
	 */
	Carob.gallery = {

		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-gallery-button').each( function(){

				var v_field = $(this).next(),
					slides = $( '#' + v_field.attr('id') + '_slides'),
					t_slide = slides.find('.template').clone().removeAttr('class'),
					state = 'gallery',
					selection = {};

				// Button click
				$(this).click( function(e){

					e.preventDefault();

					// if there are saved attachments set state to gallery-edit
					// and fill gallery selection with those attachments
					var saved_att = JSON.parse( _.unescape( v_field.val() ) );

					if( ! _.isEmpty( saved_att ) ) {

						var ids = [],
							query,
							query_args = {};
						
						// get attachment ids
						_.map( saved_att, function( attachment_id ){
							ids.push( attachment_id );
						});

						query_args.post__in = ids;
						query_args.orderby  = 'post__in';
						state = 'gallery-edit';

						// create query for saved attachments
						query = wp.media.query( query_args );

						// fill selection with query result
						selection = new wp.media.model.Selection( query.models, {
							props: query.props.toJSON(),
							multiple: true
						});
					}

					// Create gallery frame
					Carob.settings.mediaFrame = wp.media.frames.carob_media_frame = wp.media({
						frame: 'post',
				      	library: { type: 'image' },
				      	multiple: true,
				      	state: state,
				      	selection: selection
					});

					
					// Frame update
					Carob.settings.mediaFrame.on('update', function( selected ){

						var ids = [],
							slide;

						selected = selected.toJSON();

						// remove current slides
						slides.empty();

						_.map( selected, function( att ){
							
							// add attachment id to list with ids
							ids.push( att.id );
							
							// create new slide
							slide = t_slide.clone()

							slide.find('img')
									.attr('src', att.sizes.thumbnail.url)
										.attr('alt', att.title);
							
							// add slide to slides container
							slides.append( slide );

						});

						v_field.val( _.escape( JSON.stringify( ids ) ) );

						Carob.settings.mediaFrame = null;

					});

					// Frame close
					Carob.settings.mediaFrame.on('close', function(){

						// if gallery contains no
						// attachments clear the slides
						var count = Carob.settings.mediaFrame.state().get('library').length;
						
						if( ! count ) {

							slides.empty();
							v_field.val('[]');

							// add empty gallery text
							var no_slides = t_slide.clone(),
								no_slides_text = 'No images selected.';

							if( ! _.isUndefined( Carob_l10n.noGallerySlides ) ) {
								no_slides_text = Carob_l10n.noGallerySlides;
							}

							no_slides.addClass('no-slides');
							no_slides.html( no_slides_text );
							
							slides.append( no_slides );
						}

					});

					Carob.settings.mediaFrame.open();

				});

			});

		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-gallery-button').each( function(){
				
				$(this).unbind('click');
				
				if( Carob.settings.mediaFrame ) {
					Carob.settings.mediaFrame.unbind('update');
					Carob.settings.mediaFrame.unbind('close');
					Carob.settings.mediaFrame = null;
				}

			});
		}
	};

	/**
	 * Icon Picker
	 * 
	 */
	Carob.iconPicker = {

		addTo: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-font-icon-picker').each( function(){

				var picker = $(this),
					field = picker.children('input').first(),
					preview = picker.find('.carob-font-icon-preview > span');

				picker.on('icon-change', function( e ){
					
					preview.removeClass( field.val() );

					picker.find('.carob-font-icon.is-active')
							.removeClass('is-active');
					
					e.caller.addClass('is-active');
					field.val( e.name );

					preview.addClass( e.name );
				});

				$(this).find('.carob-font-icon').each( function(){

					$(this).on('click', function(){

						var name = $(this).attr('data-name');
						
						picker.trigger( { type: 'icon-change', caller: $(this), name: name } );
						
					});
				});

			});

		},

		removeFrom: function( context ) {

			if( _.isUndefined( context ) || _.isNull( context ) ) {
				return;
			}

			context.find('.carob-font-icon-picker').each( function(){
				
				$(this).off();
				
				$(this).find('.carob-font-icon').each( function(){

					$(this).off();
				});
			});
		}

	};

	Carob.init();
});