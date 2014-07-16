<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Icon_Picker_Validator' ) ) :

class Carob_Icon_Picker_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		return sanitize_html_class( $value, $option['default'] );
	}
}

endif;

?>