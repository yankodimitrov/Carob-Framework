<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Sidebars' ) ) :

class Carob_Sidebars {

	const ID = 'carob_custom_sidebars';
	private $custom_sidebars;
	private $theme_sidebars;

	public function __construct() {

		$this->custom_sidebars = get_option( Carob_Sidebars::ID, array() );
		
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'widgets_init', array( &$this, 'register_sidebars') );
	}

	public function init() {

		$this->theme_sidebars = apply_filters( 'carob_theme_sidebars', array() );
		
		if( is_admin() ) {
			
			$this->register_option();
		}
	}

	public function register_sidebars() {

		$defaults = array(
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>'
		);

		$options = apply_filters( 'carob_sidebars_options', $defaults );

		foreach ( $this->custom_sidebars as $sidebar ) {
			
			$options['name'] = $sidebar['name'];

			register_sidebar( $options );
		}

	}

	public function register_option() {

		$option = array(
			'class' => 'Carob_Select_Sidebar',
			'validator' => 'Carob_Select_Sidebar_Validator'
		);

		$factory = Carob_Options_Factory::get_instance();
		$factory->register_option( 'select_sidebar', $option );
	}

	public function get_custom_sidebars() {

		return $this->custom_sidebars;
	}

	public function get_sidebars() {
		
		return array_merge( $this->theme_sidebars, $this->custom_sidebars );
	}

	public function get_sidebars_list() {

		$sidebars = $this->get_sidebars();
		$sidebars_list = array();

		foreach( $sidebars as $sidebar ) {
			
			$sidebars_list[] = array( 
				'value' => $sidebar['name'],
				'label' => $sidebar['name']
			);
		}

		return $sidebars_list;
	}
}

endif;

?>