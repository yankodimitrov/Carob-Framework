<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Options_Cache' ) ) :

class Carob_Options_Cache extends Carob_Abstract_Cache {

	private $options;

	public function __construct( $options ) {

		$this->options = $options;
	}

	protected function get_item_class( $type ) {

		if( ! array_key_exists( $type, $this->options ) ) {
		
			return null;
		}

		$option_item = $this->options[ $type ];
		$option_class = $option_item['class'];

		return $option_class;
	}

	protected function is_valid_object( $item ) {

		if( is_object( $item ) && $item instanceof Carob_Option ) {

			return true;
		}

		return false;
	}

	protected function get_default_item() {

		return new Carob_Default_Option();
	}
}

endif;

?>