<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Options_Factory' ) ) :

class Carob_Options_Factory {

	private static $instance = null;
	private $options;
	private $options_cache;
	private $validators_cache;

	private function __construct() {
		
		$this->options = array();
	}

	public static function get_instance() {

		if( ! ( self::$instance instanceof Carob_Options_Factory ) ) {

			self::$instance = new Carob_Options_Factory();
		}

		return self::$instance;
	}

	public function register_option( $type, $option = array() ) {

		if( ! isset( $type ) ||
			! isset( $option['class'] ) ||
			! isset( $option['validator'] ) ) {

			return new WP_Error(
				'crb_option',
				__( '[regsiter option] Incomplete option parameters', 'carob-framework' )
			);
		}

		$this->options[ $type ] = array( 
			'class' => $option['class'],
			'validator' => $option['validator']
		);

		return true;
	}

	public function make_option( $type ) {

		$cache = $this->get_options_cache();

		if( ! $this->is_option_registered( $type ) ) {

			$type = 'default';
		}

		return $cache->get_item( $type );
	}

	public function make_option_validator( $type ) {

		$cache = $this->get_validators_cache();

		if( ! $this->is_option_registered( $type ) ) {

			$type = 'default';
		}

		return $cache->get_item( $type );
	}

	private function get_options_cache() {

		if( $this->options_cache == null ) {
			
			$this->options_cache = new Carob_Options_Cache( $this->options );
		}
		
		return $this->options_cache;
	}

	private function get_validators_cache() {

		if( $this->validators_cache == null ) {
			
			$this->validators_cache = new Carob_Validators_Cache( $this->options );
		}
		
		return $this->validators_cache;
	}

	public function is_option_registered( $type ) {

		if( isset( $type ) && array_key_exists( $type , $this->options ) ) {

			return true;
		}

		return false;
	}

	private function __clone(){}
}

endif;

?>