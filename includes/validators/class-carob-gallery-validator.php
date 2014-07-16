<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Gallery_Validator' ) ) :

class Carob_Gallery_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		if( ! is_array( $value ) ) {
			
			$value = $value = json_decode( stripslashes( htmlspecialchars_decode( $value ) ), true );
		}

		if( empty( $value ) ) {
			
			return $option['default'];
		}

		return array_map( 'absint', $value );
	}
}

endif;

?>