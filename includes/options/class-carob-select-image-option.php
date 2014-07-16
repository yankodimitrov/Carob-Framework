<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Select_Image_Option' ) ) : 

class Carob_Select_Image_Option extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		echo '<div class="' . esc_attr( $option['class'] ) . '" data-target-id="' . esc_attr( $option['id'] ) . '">';
		echo '<ul>';
		
		foreach ( $option['options'] as $item ) {
			
			$checked = '';

			if( $item['value'] == $value ){
				
				$checked = 'selected';
			}

			echo '<li class="' . $checked . '">
					<a href="#" data-sel-val="' . esc_attr( $item['value'] ) . '" title="' . esc_attr( $item['value'] ) . '">
						<img src="' . esc_attr( $item['image'] ) . '" alt="' . esc_attr( $item['value'] ) . '" width="120" height="80" />
					</a>
				  </li>';

		}

		echo '</ul>
				<input type="hidden" 
						id="' . esc_attr( $option['id'] ) . '" 
						name="' . esc_attr( $option['id'] ) . '" 
						value="' . esc_attr( $value ) . '" 
				/>';

		echo '</div>';
	}
}
	
endif;

?>