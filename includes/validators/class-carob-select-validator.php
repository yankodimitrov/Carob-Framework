<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Select_Validator' ) ) :

class Carob_Select_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		// make sure that selected value is in options array
		$select_values = array();

		foreach ( $option['options'] as $option_item ) {
			
			$select_values[] = $option_item['value'];
		}

		if( ! in_array( $value, $select_values ) ) {
			
			return $option['default'];
		}

		return $value;
	}
}

endif;

?>