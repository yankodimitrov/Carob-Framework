<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Register_Shortcodes' ) ) :

require_once( dirname(__FILE__) . '/shortcodes/class-carob-highlight-shortcode.php' );

class Carob_Register_Shortcodes {
	
	public function __construct() {

		add_filter( 'carob_shortcodes', array( &$this, 'register_shortcodes' ) );
	}

	public function register_shortcodes( $shortcodes ) {

		$shortcodes[] = 'Carob_Highlight_Shortcode';

		return $shortcodes;
	}
}

endif;

?>