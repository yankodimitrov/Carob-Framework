<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_File' ) ) : 

class Carob_File extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		$url = '';
		
		if( isset( $value['url'] ) ) {
			
			$url = $value['url'];
		}

		echo '<input id="' . esc_attr( $option['id'] ) . '-url" 
					 class="carob-input ' . esc_attr( $option['class'] ) . '" 
					 type="text"  
					 value="' . esc_attr( $url ) . '" 
				/>';

		echo '<input type="hidden" 
					id="' . esc_attr( $option['id'] ) . '" 
					name="' . esc_attr( $option['id'] ) . '"
					value="' . esc_attr( json_encode( $value ) ) . '"
				/>';

		echo '<span class="button upload carob-file-button"
					data-type="' . esc_attr( $option['options']['type'] ) . '"  
					data-title="' . esc_attr( $option['title'] ) . '" >'
				. esc_html( $option['options']['button_title'] )
				. '</span>';
		
		// if its an image file type display the image preview
		if( $option['options']['type'] == 'image' ) {
			
			if( ! isset( $url ) || strlen( trim( $url ) ) == 0 ) {

				$url = CAROB_FRAMEWORK_URI . 'admin/images/default-upload-image.jpg';
			}

			echo '<div>
					<img class="carob-image-preview"
						 id="' . esc_attr( $option['id'] ) . '_preview" 
						 src="'. esc_url( $url ) .'" 
						 alt="' . __( 'Selected Image Preview', 'carob-framework' ) . '"
					/>
				</div>';
		}
	}
}
	
endif;

?>