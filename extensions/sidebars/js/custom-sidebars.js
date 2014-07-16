/*--------------------------------------
 * Carob Custom Sidebars
 *
 * @version  1.0
 --------------------------------------*/

/**
 * Document Ready
 * 
 */
jQuery(document).ready(function($){

	window.CarobSidebars = {};

	CarobSidebars.settings = {
		clearButton: $('.carob-toolbar .carob-clear'),
		saveButton: $('.carob-toolbar .carob-save'),
		nameField: $('.carob-sidebar-name'),
		notificationView: $('#carob-notification')
	}

	/**
	 * Templates
	 * 
	 */
	CarobSidebars.templates = {
		sidebar: $('#carob-tmpl-sidebar').html()
	};

	/**
	 * Init
	 * 
	 */
	CarobSidebars.init = function() {

		var target = $('.carob-custom-sidebars'),
			sidebars_data = target.attr('data-sidebars'),
			sidebars,
			sidebars_list;

		if( _.isUndefined( sidebars_data ) ) {
			return;
		}

		sidebars_data = JSON.parse( _.unescape( sidebars_data ) );
		sidebars = new CarobSidebars.Collections.Sidebars( sidebars_data );
		sidebars_list = new CarobSidebars.Views.SidebarsList( { collection: sidebars } );

		target.append( sidebars_list.render().$el );

		// add sidebar
		target.find('.carob-add-sidebar').click(function(e) {
			
			e.preventDefault();
			
			CarobSidebars.addSidebar( sidebars );
			
			return false;
		});

		CarobSidebars.settings.nameField.keypress(function(e) {

			if( e.which == 13 ) {

				CarobSidebars.addSidebar( sidebars );

				return false;
			}

		});

		// save sidebars
		CarobSidebars.settings.saveButton.click(function(e) {

			e.preventDefault();

			$(this).prop('disabled', true);

			CarobSidebars.saveSidebars( sidebars );

		});

		// clear sidebars
		CarobSidebars.settings.clearButton.click(function(e) {

			e.preventDefault();

			CarobSidebars.clearSidebars( sidebars );

		});
	};

	/**
	 * Show Notificaton
	 * 
	 */
	CarobSidebars.showNotification = function( text, type ) {

		var view = this.settings.notificationView;
		
		view.removeClass( 'info success' );
		view.addClass( type );
		view.find('.content').html( text );
		view.stop(true, true)
				.animate({top: 0 }, 300)
					.delay(1600).animate({top: -90 }, 300);
	}

	/**
	 * Add Sidebar
	 * 
	 */
	CarobSidebars.addSidebar = function( collection ) {

		var sidebar = new CarobSidebars.Models.Sidebar({ name: $.trim( CarobSidebars.settings.nameField.val() ) });

		if( ! sidebar.isValid() ) {
			
			CarobSidebars.showNotification( sidebar.validationError, 'info' );
			CarobSidebars.settings.nameField.focus();
			
			return;
		}

		var hasDuplicate = collection.some(function( _sidebar ) { 
	    
	        return sidebar.get('name').toLowerCase() === _sidebar.get('name').toLowerCase();
	    
	    });

		if( hasDuplicate ) {
			
			CarobSidebars.showNotification( CarobSidebars_l10n.dupSidebar, 'info' );
			CarobSidebars.settings.nameField.focus();
			
			return;
		}

		collection.add( sidebar );
		
		CarobSidebars.settings.nameField.val('');
		CarobSidebars.settings.nameField.focus();

	};

	/**
	 * Save Sidebars
	 * 
	 */
	CarobSidebars.saveSidebars = function( sidebars ) {

		var sidebars_json = sidebars.toJSON();

		if( _.isEmpty( sidebars_json ) ) {
			sidebars_json = '[{}]';
		}

		$.ajax({
			type: 'post',
	        url: ajaxurl,
	        data: { 
	        	action: 'carob_save_sidebars',
	        	sidebars: sidebars_json,
	        	nonce: CarobSidebars_l10n.nonce
	        },
	        success: function(data) {

				CarobSidebars.showNotification( data, 'success' );	
	        	CarobSidebars.settings.saveButton.prop('disabled', false);
	        }
		});

	};

	/**
	 * Clear Sidebars
	 * 
	 */
	CarobSidebars.clearSidebars = function( collection ) {

		while ( model = collection.first() ) {
			model.destroy();
			model.off();
		}
	};

	/*---------------------------*
	 * Models
	 *---------------------------*/
	CarobSidebars.Models = {};

	/**
	 * Sidebar Model
	 * 
	 */
	CarobSidebars.Models.Sidebar = Backbone.Model.extend({
		
		defaults: {
			name: 'Default'
		},

		validate: function(atts) {

			if( ! _.isString( atts.name ) ) {
				return 'Sidebar name is not a string.';
			}

			if( $.trim( atts.name ).length < 2 ) {
				return CarobSidebars_l10n.shortName;
			}
		}

	});

	/*---------------------------*
	 * Collections
	 *---------------------------*/
	CarobSidebars.Collections = {};

	/**
	 * Sidebars Collection
	 * 
	 */
	CarobSidebars.Collections.Sidebars = Backbone.Collection.extend({
		model: CarobSidebars.Models.Sidebar
	})

	/*---------------------------*
	 * Views
	 *---------------------------*/
	CarobSidebars.Views = {};

	/**
	 * Sidebars List View
	 * 
	 */
	CarobSidebars.Views.SidebarsList = Backbone.View.extend({
		
		tagName: 'ul',
		className: 'carob-sidebars-list',

		initialize: function() {

			this.collection.on( 'remove', this.setContentState, this );
			this.collection.on( 'add', this.addItem, this);

		},

		render: function() {

			this.collection.each( this.addItem, this );
			this.setContentState();

			return this;
		},

		addItem: function(sidebar) {

			var item = new CarobSidebars.Views.Sidebar({ model: sidebar }),
				element = item.render().$el;

			this.$el.append( element );
			this.setContentState();

			element.animate({opacity: 1}, 200);
		},

		setContentState: function() {

			if( this.collection.length == 0 ) {
				
				CarobSidebars.settings.clearButton.prop('disabled', true);

			} else {

				CarobSidebars.settings.clearButton.prop('disabled', false);

			}
		}

	});

	/**
	 * Sidebar View
	 * 
	 */
	CarobSidebars.Views.Sidebar = Backbone.View.extend({
		
		tagName: 'li',
		className: 'carob-sidebar',
		template: _.template( CarobSidebars.templates.sidebar ),

		events: {
			'click .delete': 'delete'
		},

		initialize: function() {

			this.model.on('change', this.render, this);
			this.model.on('destroy', this.destroy, this);

		},

		render: function() {

			this.$el.html( this.template( this.model.toJSON() ) );

			return this;
		},

		delete: function(e) {

			e.preventDefault();
			
			this.model.destroy();
			this.model.off();
		},

		destroy: function() {

			this.$el.off();
			this.undelegateEvents();

			this.$el.animate({opacity: 0}, 200, 'swing', function(){
				this.remove();
			});
		}

	});

	
	CarobSidebars.init();

});