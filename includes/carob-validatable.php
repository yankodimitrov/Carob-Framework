<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Validator' ) ) :

interface Carob_Validatable {

	public function validate( $option, $value );
}

endif;

?>