<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Editor' ) ) : 

class Carob_Editor extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );

		$settings = array(
			'textarea_name' => $option['id'],
			'textarea_rows' => 7,
			'media_buttons' => false,
			'tinymce' => false
		);
			
		if( ! empty( $option['options'] ) ) {
			
			$settings = array_merge( $settings, $option['options'] );
		}

		echo '<div class="' . esc_attr( $option['class'] ) . '">';
		
		wp_editor( $value, $option['id'] . '-editor', $settings );
		
		echo '</div>';

	}
}
	
endif;

?>