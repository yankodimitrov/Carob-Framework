<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Checkbox' ) ) : 

class Carob_Checkbox extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );

		$checked = '';
		
		if( $value == 'on' ) {
			
			$checked = ' checked=checked';
		}

		echo '<input type="checkbox" 
					 class="' . esc_attr( $option['class'] ) . '" 
					 id="' . esc_attr( $option['id'] ) . '" 
					 name="' . esc_attr( $option['id'] ) . '" ' . $checked . ' />';
		
		echo '<label for="' . esc_attr( $option['id'] ) . '" 
					class="carob-label"  
				>' . esc_html( $option['label'] ) . '</label>';

	}
}
	
endif;

?>