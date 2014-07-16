<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Options_View' ) ) :

class Carob_Options_View {

	public function display_options( $options ) {

		$options_factory = Carob_Options_Factory::get_instance();

		$this->before_options();

		foreach ( $options as $item ) {
			
			$value = $this->get_option_value( $item );
			
			if( empty( $value ) && isset( $item['default'] ) ) {

				$value = $item['default'];
			}

			$this->before_option( $item );

			$option = $options_factory->make_option( $item['type'] );
			$option->display( $item, $value, $this );
			
			echo '<div class="carob-line"></div>';
		}

		$this->after_options();
	}

	protected function before_options(){}
	protected function after_options(){}
	protected function before_option( $option ){}

	protected function get_option_value( $option ) {

		return $option['default'];
	}
}

endif;

?>