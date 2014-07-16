<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Heading' ) ) : 

class Carob_Heading extends Carob_Option {

	public function display( $option, $value ) {

		echo '<h2 class="carob-heading">' . esc_html( $option['title'] ) . '</h2>';
		echo '<p class="description carob-description">' . esc_html( $option['desc'] ) . '</p>';
	}
}
	
endif;

?>