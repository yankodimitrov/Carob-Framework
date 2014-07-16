<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Textarea' ) ) : 

class Carob_Textarea extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );

		$rows = 7;
		
		if( isset( $option['rows'] ) ) {

			$rows = intval( $option['rows'] );
		}

		echo '<textarea  rows="' . esc_attr( $rows ) . '" 
						 cols="25" 
						 class="' . esc_attr( $option['class'] ) . '" 
						 name="' . esc_attr( $option['id'] ) . '" >' . 
						 esc_textarea( $value ) . 
				'</textarea>';
	}
}

endif;

?>