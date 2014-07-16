<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Default_Validator' ) ) :

class Carob_Default_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		return $option['default'];
	}
}

endif;

?>