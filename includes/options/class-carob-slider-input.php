<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Slider_Input' ) ) : 

class Carob_Slider_Input extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		echo '<input id="' . esc_attr( $option['id'] ) . '" 
					 class="carob-input ' . esc_attr( $option['class'] ) . '" 
					 name="' . esc_attr($option['id']) . '" 
					 type="text" 
					 value="' . esc_attr( $value ) . '" 
				/>';

		echo '<div 	data-value="' . esc_attr( $value ) . '" 
					data-field="' . esc_attr( $option['id'] ) . '" 
					data-min="' . esc_attr( $option['options']['min'] ) . '" 
					data-max="' . esc_attr( $option['options']['max'] ) . '" 
					data-step="' . esc_attr( $option['options']['step'] ) . '" 
					class="carob-ui-slider" >';

			echo '<span class="ui-slider-handle"></span>';

		echo '</div>';
		
		echo '<div class="carob-clear"></div>';
	}
}
	
endif;

?>