<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Text' ) ) : 

class Carob_Text extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		echo '<input class="' . esc_attr( $option['class'] ) . '" 
					 name="' . esc_attr( $option['id'] ) . '" 
					 type="text" 
					 value="' . esc_attr( $value ) . '" 
				/>';
	}
}
	
endif;

?>