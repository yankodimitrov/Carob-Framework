<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Taxonomy' ) ) :

class Carob_Taxonomy {

	public function register_post_taxonomy( $post_type, $taxonomy ) {

		if( empty( $post_type ) || empty( $taxonomy ) || ! post_type_exists( $post_type ) ) {
			
			return;
		}

		$post_type = mb_strtolower( str_replace( ' ', '-', $post_type ) );
		$taxonomy_name = mb_strtolower( str_replace( ' ', '-', $taxonomy['name'] ) );
		$label_name = ucfirst( $taxonomy['singular'] );

		if( ! isset( $taxonomy['plural'] ) ){
		
			$taxonomy_plural = $label_name . 's';
		
		}else{
		
			$taxonomy_plural = ucfirst( $taxonomy['plural'] );
		}

		$labels =  array(
	        'name' => __( $taxonomy_plural, 'taxonomy general name', 'carob-framework' ),
	        'singular_name' => __( $label_name, 'taxonomy singular name', 'carob-framework' ),
	        'search_items' => sprintf( __( 'Search %s', 'carob-framework' ), $taxonomy_plural ),
	        'popular_items' => sprintf( __( 'Popular %s', 'carob-framework' ), $taxonomy_plural ),
	        'all_items' => sprintf( __( 'All %s', 'carob-framework' ), $taxonomy_plural ),
	        'edit_item' => sprintf( __( 'Edit %s', 'carob-framework' ), $label_name ),
	        'update_item' => sprintf( __( 'Update %s', 'carob-framework' ), $label_name ),
	        'add_new_item' => sprintf( __( 'Add New %s', 'carob-framework' ), $label_name ),
	        'new_item_name' => sprintf( __( 'New %s Name', 'carob-framework' ), $label_name ),
	        'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'carob-framework' ), $taxonomy_plural ),
	        'add_or_remove_items' => sprintf( __( 'Add or remove %s', 'carob-framework' ), $taxonomy_plural ),
	        'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'carob-framework' ), $taxonomy_plural )
	    );

		if( isset( $taxonomy['labels'] ) && is_array( $taxonomy['labels'] ) ) {
			
			$labels = array_merge( $labels, $taxonomy['labels'] );
		}

		$taxonomy_options = array(  
		    'hierarchical' => true,  
		    'labels' => $labels,  
		    'query_var' => true,
		    'show_ui' => true,  
		    'rewrite' => array('slug' => $taxonomy_name )  
		);

		if( isset( $taxonomy['options'] ) && is_array( $taxonomy['options'] ) ) {
			
			$taxonomy_options = array_merge( $taxonomy_options, $taxonomy['options'] );
		}

		register_taxonomy( $taxonomy_name, $post_type, $taxonomy_options );
	}

}

endif;

?>