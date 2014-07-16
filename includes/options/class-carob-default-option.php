<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Default_Option' ) ) : 

class Carob_Default_Option extends Carob_Option {

	public function display( $option, $value ) {

		if( defined('WP_DEBUG') && WP_DEBUG == true ) {
			
			echo '<p class="carob-notice">' . 
					sprintf( __( 'The [%s] option is not registered or does not inherit from Carob_Option.', 'carob-framework' ), $option['type'] ) . 
				'</p>';
		}
	}
}

endif;

?>