<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Switch_Toggle' ) ) : 

class Carob_Switch_Toggle extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		echo '<div 	data-val-id="' . esc_attr( $option['id'] ) . '" 
					class="'. esc_attr( $option['class'] ) . ' state-' . esc_attr( $value ) . '">';

			echo '<div class="carob-switch-overlay"></div>';
			echo '<div class="carob-active-bg"></div>';

			echo '<input type="hidden" 
						 id="' . esc_attr( $option['id'] ) . '" 
						 name="' . esc_attr( $option['id'] ) . '" 
						 value="' . esc_attr( $value ) . '" />';
		
		echo '</div>';
	}
}
	
endif;

?>