<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Select' ) ) : 

class Carob_Select extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );

		echo '<select name="' . esc_attr( $option['id'] ) . '" 
					  class="' . esc_attr( $option['class'] ) . '">';

		foreach ( $option['options'] as $item ) {
			
			$selected = '';

			if( $value == $item['value'] ) {
				
				$selected = ' selected=selected';
			}

			echo '<option value="' . esc_attr( $item['value'] ) . '" ' . $selected . '>
					' . esc_html( $item['label'] ) . '
				  </option>';
		}

		echo '</select>';
	}
}
	
endif;

?>