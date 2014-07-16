<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Admin' ) ) :

class Carob_Admin {
	
	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( &$this, 'load_scripts' ) );
		add_action( 'admin_print_styles', array( &$this, 'load_styles' ) );
	}

	public function load_scripts() {

		wp_enqueue_media();
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-slider' );
		
		wp_enqueue_script(
			'jquery-colorpicker',
			CAROB_FRAMEWORK_URI . 'admin/js/colorpicker.js',
			array( 'jquery' ),
			'1.0',
			true
		);

		wp_enqueue_script(
			'carob-admin-js',
		 	CAROB_FRAMEWORK_URI . 'admin/js/carob-admin.js',
			array( 'jquery', 'jquery-colorpicker', 'underscore' ),
			'1.0',
			true
		);

		$localized = array( 
			'noGallerySlides' => __( 'No images selected.', 'carob-framework' )
		);
		
		wp_localize_script( 'carob-admin-js', 'Carob_l10n', $localized );
	}

	public function load_styles() {

		wp_register_style(
			'carob-admin-css',
		 	CAROB_FRAMEWORK_URI . 'admin/css/admin-style.css'
		);

		wp_enqueue_style( 'carob-admin-css' );
		
		$icon_font = apply_filters( 'carob_icon_font', array() );

		if( ! empty( $icon_font ) && isset( $icon_font['css'] ) ) {

			wp_enqueue_style( 'carob-icon-font', $icon_font['css'] );
		}
	}
}
	
endif;

?>