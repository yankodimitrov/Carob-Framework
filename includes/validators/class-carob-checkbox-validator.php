<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Checkbox_Validator' ) ) :

class Carob_Checkbox_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		if( ! isset( $value ) || $value != 'on' ) {
			
			return 'off';
		}

		return 'on';
	}
}

endif;

?>