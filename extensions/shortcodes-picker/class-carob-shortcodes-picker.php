<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Shortcodes_Picker' ) ) :

class Carob_Shortcodes_Picker {
	
	private $shortcodes;
	private $shortcodes_cache;

	public function __construct() {

		$default_shortcodes = new Carob_Register_Shortcodes();

		$load_front_end = apply_filters( 'carob_shortcodes_load_frontend', true );

		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'wp_ajax_carob_list_shortcodes', array( &$this, 'list_shortcodes' ) );
		add_action( 'wp_ajax_carob_edit_shortcode', array( &$this, 'edit_shortcode' ) );
		
		if( $load_front_end ) {
			
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_styles' ) );
		}
	}

	public function init() {

		$this->shortcodes_cache = array();
		$this->shortcodes = apply_filters( 'carob_shortcodes', array() );
		$this->register_shortcodes();
	}

	private function register_shortcodes() {

		foreach ( $this->shortcodes as $shortcode_class ) {
				
			if( ! class_exists( $shortcode_class ) ) {

				continue;
			}

			$shortcode = new $shortcode_class;

			if( $shortcode instanceof Carob_Shortcode ) {

				$this->shortcodes_cache[ $shortcode->get_name() ] = $shortcode;
			}
		}

	}

	public function load_scripts() {

		wp_register_script(
			'carob-shortcodes-js',
			CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/js/shortcodes.js',
			array( 'jquery' ),
			'1.0',
			true
		); 

		wp_enqueue_script( 'carob-shortcodes-js' );
	}

	public function load_styles() {

		wp_register_style( 
			'carob-shortcodes-css',
			CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/css/shortcodes.css',
			null,
			'1.0',
			'screen'
		);
		
		wp_enqueue_style( 'carob-shortcodes-css' );
	}

	public function list_shortcodes() {

		check_ajax_referer( Carob_Shortcodes_Admin::NONCE_ACTION, 'nonce' );

		if( empty( $this->shortcodes_cache ) ) {

			echo '<p class="carob-notice carob-notice--info">' . 
					__( 'There are no shortcodes!', 'carob-framework' ) . 
				 '</p>';
			
			die();	
		}

		$shortcodes = $this->shortcodes_cache;

		require_once( CAROB_FRAMEWORK_ROOT . 'extensions/shortcodes-picker/templates/shortcodes-list.php' );

		die();
	}

	public function edit_shortcode() {

		check_ajax_referer( Carob_Shortcodes_Admin::NONCE_ACTION, 'nonce' );

		if( ! isset( $_POST['shortcode'] ) ) {

			echo '<p class="carob-notice carob-notice--info">' . 
					__( 'Shortcode ID is not defined!', 'carob-framework' ) . 
				 '</p>';

			die();
		}

		$shortcode_id = $_POST['shortcode'];

		if( ! array_key_exists( $shortcode_id, $this->shortcodes_cache ) ) {

			echo '<p class="carob-notice carob-notice--info">' . 
					__( 'The shortcode does not exists!', 'carob-framework' ) . 
				 '</p>';

			die();

		}		
		
		$shortcode = $this->shortcodes_cache[ $shortcode_id ];

		if( ! $shortcode->has_options() ) {

			echo '<p class="carob-notice carob-notice--info">' . 
					__( 'This shortcode have no options!', 'carob-framework' ) . 
				 '</p>';

			die();
		}

		$framework = Carob_Framework::get_instance();
		$options_view = $framework->get_extension( 'options_view' );

		echo '<div class="carob-options carob-options--meta-box">';

		$options_view->display_options( $this->get_shortcode_options( $shortcode ) );
		
		echo '</div>';

		die();
	}

	private function get_shortcode_options( $shortcode ) {

		// prefix the shortcode option ids
		
		$options = array();

		foreach ( $shortcode->get_options() as $option ) {
			
			$option['id'] = 'crb-sh-' . $option['id'];

			$options[] = $option;
		}

		// add shortcode content field
		
		if( $shortcode->has_content() ) {

			$content = array(
				'title' => __( 'Content', 'carob-framework' ),
				'id' => 'crb-sh-content',
				'desc' => __( 'Type here the shortcode content:', 'carob-framework' ),
				'default' => '',
				'class' => 'carob-input',
				'type' => 'textarea'
			);

			$options[] = $content;
		}

		return $options;
	}
}

endif;

?>