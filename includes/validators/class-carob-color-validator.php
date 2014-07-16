<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Color_Validator' ) ) :

class Carob_Color_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		if( ! preg_match( '/[0-9A-Fa-f]{6}/', $value ) ) {
			
			return $option['default'];
		}

		return $value;
	}
}

endif;

?>