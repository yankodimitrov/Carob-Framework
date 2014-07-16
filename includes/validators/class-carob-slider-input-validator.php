<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Slider_Input_Validator' ) ) :

class Carob_Slider_Input_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		if( ! is_numeric( $value ) ) {
			
			return $option['default'];
		}

		if( $value < $option['options']['min'] ||
			$value > $option['options']['max'] ) {

			return $option['default'];
		}
			
		return $value;
	}
}

endif;

?>