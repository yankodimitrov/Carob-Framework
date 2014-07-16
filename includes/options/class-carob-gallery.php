<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Gallery' ) ) : 

class Carob_Gallery extends Carob_Option {

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		$attachments = array();
		$slides_ids = array();
		$json_slides_ids = array();

		$query_args = array( 
			'post_type' => 'attachment',
			'post_mime_type' =>'image',
			'post_status' => 'inherit',
			'posts_per_page' => -1,
			'orderby' => 'post__in',
			'post__in' => $value
		);

		// execute WP_Query and get only attachments that are available in 
		// media library.
		
		if( ! empty( $value ) ) {
			
			$attachments = new WP_Query( $query_args );
		
			foreach( $attachments->posts as $slide ) {
				
				$slides_ids[] = $slide->ID;
				$json_slides_ids[] = $slide->ID;
			}

			wp_reset_query();
		}

		echo '<span class="button upload carob-gallery-button"   
					data-title="' . esc_attr( $option['title'] ) . '" >'
				. esc_html( $option['button_title'] )
				. '</span>';

		echo '<input type="hidden" 
					id="' . esc_attr( $option['id'] ) . '" 
					name="' . esc_attr( $option['id'] ) . '"
					value="' . esc_attr( json_encode( $json_slides_ids ) ) . '"
				/>';

		echo '<ul id="' . esc_attr( $option['id'] ) . '_slides" 
				  class="' . esc_attr( $option['class'] ) . '">';
		
		echo '<li class="template">
					<img src="' . plugin_dir_url( __FILE__ ) . '../../admin/images/gallery-slide-default.png"
						 width="75" 
						 alt="Template"/>
				</li>';

		// output saved attachments
		if( ! empty( $slides_ids ) ) {
		
			foreach ( $slides_ids as $id ) {
				
				$image = wp_get_attachment_image_src( $id, 'thumbnail' );
				
				echo '<li><img src="' . esc_attr( $image[0] ) . '" width="75" alt="Slide"/></li>';
			}
		
		}else{
			
			echo '<li class="no-slides">
					' . __('No images selected.', 'carob-framework') . '
					</li>';
		}

		echo '</ul>';	
	}
}
	
endif;

?>