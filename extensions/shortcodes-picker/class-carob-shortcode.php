<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Shortcode' ) ) :

abstract class Carob_Shortcode {
	
	protected $name = 'carob_default_shortcode';
	protected $title = 'Default Shortcode';
	protected $icon;
	protected $has_content = false;

	protected function register() {
		
		add_shortcode( $this->name, array( &$this, 'display' ) );
	}

	abstract public function display( $atts, $content = '' );
	
	public function get_options() {

		return array();
	}

	public function has_options() {

		$options = $this->get_options();

		if( ! empty( $options ) ) {

			return true;
		}

		return false;
	}

	public function get_name() {
		
		return $this->name;
	}

	public function get_title() {
		
		return $this->title;
	}

	public function get_icon() {
		
		return $this->icon;
	}

	public function has_content() {
		
		return $this->has_content;
	}

}

endif;

?>