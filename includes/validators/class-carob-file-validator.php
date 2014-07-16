<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_File_Validator' ) ) :

class Carob_File_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		if( ! is_array( $value ) ) {
			
			$value = json_decode( stripslashes( htmlspecialchars_decode( $value ) ), true );
		}
		
		if( empty( $value ) || ! isset( $value['id'] ) ) {
			
			return $option['default'];
		}

		$value['id'] = absint( $value['id'] );

		return $value;
	}
}

endif;

?>