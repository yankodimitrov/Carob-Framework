<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Abstract_Cache' ) ) :

abstract class Carob_Abstract_Cache {

	protected $cache = array();

	public function get_item( $type ) {

		if( ! array_key_exists( $type, $this->cache ) ) {

			$this->add_item( $type );
		}

		return $this->cache[ $type ];
	}

	public function add_item( $type ) {

		$item_class = $this->get_item_class( $type );
		$item  = null;

		if( class_exists( $item_class ) ) {

			$item = new $item_class();
		}

		if( ! $this->is_valid_object( $item ) ) {
			
			$item = $this->get_default_item();
		}

		$this->cache[ $type ] = $item;
	}

	abstract protected function get_item_class( $type );
	abstract protected function is_valid_object( $item );
	abstract protected function get_default_item();
}

endif;

?>