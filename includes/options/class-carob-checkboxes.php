<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Checkboxes' ) ) : 

class Carob_Checkboxes extends Carob_Option {

	public function display( $option, $value ) {

		if( ! is_array( $value ) ) {
			
			return;
		}

		parent::display_title( $option );

		$counter = 0;

		foreach ( $option['options'] as $checkbox ) {
			
			$checked = '';
			
			$cbx_id = esc_attr( $option['id']  ) . '_' . $counter;

			if( in_array( $checkbox['value'], $value ) ) {
				
				$checked = ' checked=checked';
			}

			echo '<input type="checkbox" 
						 class="' . esc_attr( $option['class'] ) . '"
						 id="' . esc_attr( $cbx_id ) . '" 
						 name="' . esc_attr( $option['id'] ) . '[]" ' . $checked . '
						 value="'. esc_attr( $checkbox['value'] ) .'" />';
			
			echo '<label for="' . esc_attr( $cbx_id ) . '" 
						class="carob-label" 
					>' . esc_html( $checkbox['label'] ) . '</label>';

			$counter += 1;

		}
	}
}
	
endif;

?>