<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Page_Options_View' ) ) :

class Carob_Page_Options_View extends Carob_Options_View {

	private $menu;
	private $menu_counter;
	private $saved_options;

	public function display_page_options( $saved_options, $options ) {

		$this->menu = '';
		$this->menu_counter = 0;
		$this->saved_options = $saved_options;

		parent::display_options( $options );
	}

	protected function before_options() {

		echo '<div class="carob-options carob-page-content">';
	}
	
	protected function after_options() {

		echo '</div>';
	}
	
	protected function get_option_value( $option ) {

		if( array_key_exists( $option['id'], $this->saved_options ) ) {

			return $this->saved_options[ $option['id'] ];
		}

		if( isset( $option['default'] ) ) {

			return $option['default'];
		}

		return null;
	}

	protected function before_option( $option ) {

		if( $option['type'] == 'heading' ) {

			$this->add_options_group( $option );
			$this->add_menu_item( $option );
		}
	}

	private function add_options_group( $option ) {

		if( $this->menu_counter >= 1 ) {
			echo '</div>';
		}

		echo '<div class="hidden group" id="' . esc_attr( $option['id'] ) . '">';
	}

	private function add_menu_item( $option ) {

		$item = '<li class="carob-menu-item"><a id="' . esc_attr( $option['id'] ) . '"
					 title="' . esc_attr( $option['title'] ) . '"
					 href="#' . esc_attr( $option['id'] ) . '">'
					 . esc_html( $option['title'] ) . 
				'</a></li>';

		$this->menu .= $item;
		$this->menu_counter += 1;
	}

	public function get_menu() {

		return $this->menu;
	}
}

endif;

?>