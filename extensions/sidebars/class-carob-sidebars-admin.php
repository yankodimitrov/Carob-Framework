<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Sidebars_Admin' ) ) :

class Carob_Sidebars_Admin {

	private $page_id = 'carob-custom-sidebars';

	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( &$this, 'load_scripts' ) );
		add_action( 'admin_print_styles', array( &$this, 'load_styles' ) );
		add_action( 'admin_footer', array( &$this, 'print_templates' ) );
		add_action( 'admin_menu', array( &$this, 'add_sidebars_page' ) );
		add_action( 'wp_ajax_carob_save_sidebars', array( &$this, 'save_sidebars' ) );
	}

	public function load_scripts() {

		if( ! $this->is_sidebars_page() ) {
			
			return;
		}

		wp_enqueue_script( 'backbone' );
		
		wp_enqueue_script( 
			'carob-sidebars-js',
			CAROB_FRAMEWORK_URI . 'extensions/sidebars/js/custom-sidebars.js', 
			array( 'backbone' ),
			'1.0',
			true
		);
		
		// localize script strings
		$localized = array(
			'shortName' => __( 'Please, enter a name for your sidebar.', 'carob-framework' ),
			'dupSidebar' => __( 'Sidebar with this name already exists!', 'carob-framework' ),
			'nonce' => wp_create_nonce( $this->page_id )
		);
		
		wp_localize_script( 'carob-sidebars-js', 'CarobSidebars_l10n', $localized );
		
	}

	public function load_styles() {

		if( ! $this->is_sidebars_page() ) {
			return;
		}
		
		wp_enqueue_style(
			'carob-sidebars-css',
			CAROB_FRAMEWORK_URI . 'extensions/sidebars/css/custom-sidebars.css'
		);
		
	}

	public function print_templates() {

		if( ! $this->is_sidebars_page() ) {
			return;
		}
			
		require_once ( CAROB_FRAMEWORK_ROOT . 'extensions/sidebars/templates/templates.php' );
	}

	private function is_sidebars_page() {

		global $current_screen;

		if( $current_screen->id == 'appearance_page_' . $this->page_id ) {
			
			return true;
		}

		return false;
	}

	public function add_sidebars_page() {

		add_theme_page( 
			__( 'Sidebars', 'carob-framework' ),
			__( 'Sidebars', 'carob-framework' ), 
			'manage_options',
			$this->page_id,
			array( &$this, 'display_sidebars_page' )
		);

	}

	public function display_sidebars_page() {

		require_once( CAROB_FRAMEWORK_ROOT . 'extensions/sidebars/page-custom-sidebars.php' );
	}

	public function save_sidebars() {

		check_ajax_referer( $this->page_id, 'nonce' );

		if( ! isset( $_POST['sidebars'] ) ) {
			
			die( __( 'There are no sidebars to save!', 'carob-framework' ) );
		}

		$sidebars = array();
		$theme_sidebars = apply_filters( 'carob_theme_sidebars', array() );
		
		if( is_array( $_POST['sidebars'] ) ) {
			
			foreach ( $_POST['sidebars'] as $sidebar ) {
				
				if( ! isset( $sidebar['name'] ) ) {
					continue;
				}

				$sidebar_name = sanitize_text_field( $sidebar['name'] );

				if( strlen( trim( $sidebar_name ) ) < 2 ) {
					continue;
				}

				$sidebar_structure = array( 'name' => $sidebar_name );

				if( ! in_array( $sidebar_structure, $sidebars ) &&
					! in_array( $sidebar_structure, $theme_sidebars) ) {

					$sidebars[] = $sidebar_structure;
				}
			}
		}

		update_option( Carob_Sidebars::ID, $sidebars );

		if( empty( $sidebars ) ) {
			
			die( __( 'All custom sidebars are removed!', 'carob-framework' ) );
		}

		die( __( 'All custom sidebars are saved!', 'carob-framework' ) );
	}
}

endif;

?>