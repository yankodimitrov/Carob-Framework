<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Custom_Post_Types' ) ) :

class Carob_Custom_Post_Types {

	public function __construct() {

		add_action( 'init', array( &$this, 'add_post_types' ) );
	}

	public function add_post_types() {

		$post_types = apply_filters( 'carob_post_types', array() );

		foreach ( $post_types as $post_type ) {
			
			$this->register_post_type( $post_type );
		}
	}

	private function register_post_type( $post_type ) {

		$post_name = mb_strtolower( str_replace( ' ', '-', $post_type['post_type'] ) );

		if( post_type_exists( $post_name ) ) {
			
			return;
		}

		$label_name = ucfirst( $post_name) ;
		
		if( isset( $post_type['plural'] ) ) {

			$plural = ucfirst( $post_type['plural'] );

		} else {

			$plural = $label_name . 's';
		}

		$labels = array(
			'name' => _x( $plural, 'carob-framework' ),
			'singular_name' => _x( $label_name, 'carob-framework' ),
			'add_new' => __( 'Add New', 'carob-framework' ),
			'add_new_item' => sprintf( __( 'Add New %s', 'carob-framework' ), $label_name ),
			'edit_item' => sprintf( __( 'Edit %s', 'carob-framework' ), $label_name ),
			'new_item' => sprintf( __( 'New %s', 'carob-framework' ), $label_name ),
			'view_item' => sprintf( __( 'View %s', 'carob-framework' ), $label_name ),
			'search_items' => sprintf( __( 'Search %s', 'carob-framework' ), $plural ),
			'not_found' =>  sprintf( __( 'No %s posts found', 'carob-framework' ), $label_name ),
			'not_found_in_trash' => sprintf( __( 'No %s posts found in Trash', 'carob-framework' ), $label_name ), 
			'parent_item_colon' => ''
		);

		if( isset( $post_type['labels'] ) && is_array( $post_type['labels'] ) ) {
			
			$labels = array_merge( $labels, $post_type['labels'] );
	  	}

		$post_options = array(
			'labels' => $labels,
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => $post_name, 'with_front' => false ),
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
			'has_archive' => true,
			'menu_icon' => 'dashicons-hammer'
		);
		
		if( isset( $post_type['options'] ) && is_array( $post_type['options'] ) ) {
			
			$post_options = array_merge( $post_options, $post_type['options'] );
		}

		register_post_type( $post_name, $post_options );

		if( ! empty( $post_type['taxonomies'] ) && is_array( $post_type['taxonomies'] ) ) {

			$framework = Carob_Framework::get_instance();
			$posts_taxonomy = $framework->get_extension( 'taxonomy' );

			foreach ( $post_type['taxonomies']  as $taxonomy ) {
			
				$posts_taxonomy->register_post_taxonomy( $post_name, $taxonomy );
			}
		}
	}
}

endif;

?>