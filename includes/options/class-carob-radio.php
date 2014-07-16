<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Radio' ) ) : 

class Carob_Radio extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );

		$counter = 0;
		
		foreach ( $option['options'] as $radio ) {
			
			$checked = '';

			$radio_id = esc_attr( $option['id']  ) . '_' . $counter;

			if( $value == $radio['value'] ) {
				
				$checked = ' checked=checked';
			}

			echo '<input type="radio" 
						 id="' . $radio_id . '" 
						 class="' . $option['class'] . '" 
						 name="' . esc_attr( $option['id'] ) . '" 
						 value="' . esc_attr( $radio['value'] ) . '"' . $checked . '>';

			echo '<label for="' . $radio_id . '" class="carob-label">' . esc_html( $radio['label'] ) . '</label>';

			$counter += 1;
		}

	}
}
	
endif;

?>