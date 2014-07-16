<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Color_Picker' ) ) : 

class Carob_Color_Picker extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		echo '<div 	id="carob-color-box-' . esc_attr( $option['id'] ) . '" 
					class="carob-color-picker-preview" 
					style="background-color:#' . esc_attr( $value ) . ';">
				</div>';

		echo '<input data-color-box="carob-color-box-' . esc_attr( $option['id'] ) . '" 
					 type="text" 
					 maxlength="6" 
					 size="6" 
					 id="' . esc_attr( $option['id'] ) . '" 
					 name="' . esc_attr( $option['id'] ) . '" 
					 class="carob-input '. esc_attr( $option['class'] ) .'" 
					 value="' . esc_attr( $value ) . '" 
				/>';

		echo '<div class="carob-clear"></div>';
	}
}
	
endif;

?>