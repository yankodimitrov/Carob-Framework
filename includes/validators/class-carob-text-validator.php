<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Text_Validator' ) ) :

class Carob_Text_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		if( ! isset( $value ) || ! is_string( $value ) ) {
			
			return '';
		}

		if( isset( $option['raw'] ) && $option['raw'] == true ) {

			return $value;
		}

		global $allowedposttags;

		return wp_kses( stripslashes( $value ), $allowedposttags );
	}
}

endif;

?>