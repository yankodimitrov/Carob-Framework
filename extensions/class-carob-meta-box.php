<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Meta_Box' ) ) :

abstract class Carob_Meta_Box {
	
	protected $id = 'crb-meta-box';
	protected $title = 'Default Meta Box Title';
	protected $context = 'normal';
	protected $priority = 'high';

	public function get_id() {
		return $this->id;
	}

	public function get_title() {
		return $this->title;
	}

	public function get_context() {
		return $this->context;
	}

	public function get_priority() {
		return $this->priority;
	}

	public function has_options() {
		return true;
	}

	public function get_options() {
		return array();
	}

	public function has_custom_content() {
		return false;
	}

	public function display_content() {

	}

	public function custom_save( $post_id ) {

	}
}

endif;

?>