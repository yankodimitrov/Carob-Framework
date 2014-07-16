<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Meta_Options_View' ) ) :

class Carob_Meta_Options_View extends Carob_Options_View {

	private $post_id;

	public function display_meta_box_options( $post_id, $options ) {

		$this->post_id = $post_id;

		parent::display_options( $options );
	}

	protected function before_options() {

		echo '<div class="carob-options carob-options--meta-box">';
	}
	
	protected function after_options() {

		echo '</div>';
	}
	
	protected function get_option_value( $option ) {

		return get_post_meta( $this->post_id, $option['id'], true );
	}
}

endif;

?>