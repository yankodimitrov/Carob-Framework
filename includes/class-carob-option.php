<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Option' ) ) :

abstract class Carob_Option {

	abstract public function display( $option, $value );

	protected function display_title( $option ) {
		
		if( isset( $option['title'] ) && ! empty( $option['title'] ) ) {
			
			echo '<h3 class="carob-title">' . esc_html( $option['title'] ) . '</h3>';
		}

		if( isset( $option['desc'] ) && ! empty( $option['desc'] ) ) {
			
			echo '<p class="description carob-description">' . esc_html( $option['desc'] ) . '</p>';
		}
	}
}

endif;

?>