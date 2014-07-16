<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Checkboxes_Validator' ) ) :

class Carob_Checkboxes_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		$available_values = array();
		$cb_values = array();

		foreach ( $option['options'] as $option_item ) {
			
			$available_values[] = $option_item['value'];
		}

		if( ! is_array( $value ) ) {
			
			return $option['default'];
		}

		foreach( $value as $cb_val ) { 

			if( ! in_array( $cb_val, $available_values ) ) {
				
				continue;
			}

			$cb_values[] = $cb_val;
		}

		return $cb_values;
	}
}

endif;

?>