<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Shortcodes_Admin' ) ) :

class Carob_Shortcodes_Admin {
	
	const NONCE_ACTION = 'carob_shortcodes_picker';

	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( &$this, 'load_scripts' ) );
		add_action( 'admin_print_styles', array( &$this, 'load_styles' ) );
		add_action( 'admin_footer', array( &$this, 'print_templates' ) );
		add_filter( 'mce_external_plugins', array( &$this, 'register_shortcode_button' ) );
		add_filter( 'mce_buttons', array( &$this, 'add_shortcode_button' ) );
	}

	public function load_scripts() {

		wp_enqueue_script( 'backbone' );
		
		wp_enqueue_script( 
			'carob-sh-js',
			CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/js/shortcodes-picker.js',
			array( 'editor', 'carob-admin-js', 'backbone' ),
			'1.0',
			true
		);

		$localized = array( 
			'optionsTitle' => __( 'Options', 'carob-framework' ),
			'nonce' => wp_create_nonce( self::NONCE_ACTION )
		);

		wp_localize_script( 'carob-sh-js', 'CarobShortcodes_l10n', $localized );
	}
	
	public function load_styles() {

		wp_enqueue_style(
			'carob-sh-css',
			CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/css/shortcodes-picker.css'
		);
	}

	public function print_templates() {

		require_once ( CAROB_FRAMEWORK_ROOT . 'extensions/shortcodes-picker/templates/templates.php' );
	}

	public function register_shortcode_button( $plugins ) {

		$plugins['carob_shortcodes_picker'] = CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/js/tinymce-plugin.js';

		return $plugins;
	}

	public function add_shortcode_button( $buttons ) {

		$buttons[] = 'carob_shortcodes_picker';

		return $buttons;
	}
}

endif;

?>