<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Meta_Boxes_Manager' ) ) :

class Carob_Meta_Boxes_Manager {

	private $meta_boxes;
	private $posts_meta_boxes;
	
	public function __construct() {

		add_action( 'init', array( &$this, 'init' ), 300 );
		add_action( 'add_meta_boxes', array( &$this, 'register' ) );
		add_action( 'save_post', array( &$this, 'save' ), 10, 2 );
	}

	public function init() {

		$this->meta_boxes = apply_filters( 'carob_meta_boxes', array() );
		$this->posts_meta_boxes = apply_filters( 'carob_assign_meta_box', array() );
	}

	public function register() {

		foreach ( $this->posts_meta_boxes as $post_type => $meta_boxes ) {
			
			foreach ( $meta_boxes as $meta_box ) {
			
				$this->add_meta_box( $post_type, $meta_box );
			}
		}
	}

	private function add_meta_box( $post_type, $meta_box_name ) {

		$meta_box = $this->make_meta_box( $meta_box_name );

		if( is_wp_error( $meta_box ) ) {

			return;
		}

		add_meta_box(
			$meta_box->get_id(),
			$meta_box->get_title(),
			array( &$this, 'display' ),
			$post_type,
			$meta_box->get_context(),
			$meta_box->get_priority(),
			$meta_box
		);
	}

	private function make_meta_box( $meta_box_name ) {

		if( ! array_key_exists( $meta_box_name, $this->meta_boxes ) ) {

			return new WP_Error( 'meta-box-name' );
		}

		$meta_box_class = $this->meta_boxes[ $meta_box_name ];

		if( ! class_exists( $meta_box_class ) ) {

			return new WP_Error( 'meta-box-class' );
		}

		$meta_box = new $meta_box_class();

		if( ! $meta_box instanceof Carob_Meta_Box ) {

			return new WP_Error( 'meta-box-interface' );
		}

		return $meta_box;
	}

	public function display( $post, $arguments = array() ) {

		$meta_box = $arguments['args'];

		if( $meta_box->has_custom_content() ) {

			$meta_box->display_content();
		
		} else {

			$framework = Carob_Framework::get_instance();
			$options_view = $framework->get_extension( 'meta_options_view' );

			$options_view->display_meta_box_options( $post->ID, $meta_box->get_options() );
		}
		
		wp_nonce_field( $meta_box->get_id(), $meta_box->get_id() );
	}

	public function save( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
	    
	      	return;
		}

		if ( ! current_user_can( 'edit_pages', $post->ID ) ) {
		
			return $post->ID;
		}

		$meta_boxes = $this->get_meta_boxes_for_save();

		foreach ( $meta_boxes as $meta_box ) {
				
			if( ! $meta_box->has_options() ) {

				$meta_box->custom_save( $post_id );
			
			} else {

				$this->save_meta_options( $post_id, $meta_box->get_options() );
			}
		}
	}

	private function get_meta_boxes_for_save() {

		$meta_boxes_for_save = array();

		// find which meta boxes we need to save
		foreach ( $this->posts_meta_boxes as $post_type => $meta_boxes ) {
			
			if( isset( $_POST['post_type'] ) && $_POST['post_type'] != $post_type ) {

				continue;
			}

			foreach ( $meta_boxes as $meta_box_name ) {

				$meta_box = $this->make_meta_box( $meta_box_name );

				if( is_wp_error( $meta_box ) ) {

					continue;
				}

				if( ! isset( $_POST[ $meta_box->get_id() ] ) ){
				
					continue;
				}

				if ( ! wp_verify_nonce( $_POST[ $meta_box->get_id() ], $meta_box->get_id() ) ) {
					
					continue;
			 	}

			 	$meta_boxes_for_save[] = $meta_box;
			}
		}

		return $meta_boxes_for_save;
	}

	private function save_meta_options( $post_id, $options ) {

		$options_factory = Carob_Options_Factory::get_instance();

		foreach ( $options as $option ) {
			
			if( ! isset( $_POST[ $option['id'] ] ) ) {
				continue;
			}

			$input_value = $_POST[ $option['id'] ];
			$validator = $options_factory->make_option_validator( $option['type'] );
			$value = $validator->validate( $option, $input_value );

			update_post_meta( $post_id, $option['id'], $value );
		}

	}
}

endif;

?>