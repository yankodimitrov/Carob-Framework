<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Icon_Picker' ) ) : 

class Carob_Icon_Picker extends Carob_Option {

	private $fonts_icons_cache = null;

	public function display( $option, $value ) {

		parent::display_title( $option );
		
		$icons_list = $this->get_icons_list( $option );

		if( empty( $icons_list ) ) {

			return;
		}

		$icons_prefix = 'fa';

		if( isset( $icon_font['prefix'] ) ) {

			$icons_prefix = $icon_font['prefix'];
		}

		echo '<div class="' . esc_attr( $option['class'] ) . '">';
		echo 	'<input type="hidden" name="' . esc_attr( $option['id'] ) . '" value="' . esc_attr( $value ) . '"/>';
		
		echo '<div class="carob-font-icon-preview">
					<span class="' . esc_attr( $icons_prefix . ' ' . $value ) . '"></span>
			  </div>';

		echo 	'<div class="carob-font-icons-list-wrap">
					<ul class="carob-font-icons-list">';
		
		foreach( $icons_list as $icon ) {

			$selected = '';

			if( $value == $icon ) {
				
				$selected = ' is-active';
			}

			echo '<li class="carob-font-icon carob-left' . $selected . '" data-name="' . esc_attr( $icon ) . '">
					<span class="' . esc_attr( $icons_prefix . ' ' . $icon ) . '"></span>
				  </li>';

		}
		
		echo '</ul><div class="carob-clear"></div>
			  </div>';

		echo '</div>';
	}

	private function get_icons_list( $option ) {

		$icon_font = apply_filters( 'carob_icon_font', array() );

		if( empty( $icon_font ) ) {

			echo '<p class="carob-notice">' .
					 __( 'There are no icon fonts available.', 'carob-framework' ) .
				  '</p>';

			return array();
		}

		$icons_list = $this->get_font_icons( $icon_font, $icon_font['prefix'] );

		if( is_wp_error( $icons_list ) ) {

			echo '<p class="carob-notice">' .
					 $icons_list->get_error_message() .
				  '</p>';
			
			
			return array();
		}

		return $icons_list;
	}

	private function get_font_icons( $icon_font, $icons_prefix = 'fa' ) {

		if( ! empty( $this->fonts_icons_cache ) ) {

			return $this->fonts_icons_cache;
		}

		WP_Filesystem();
		global $wp_filesystem;

		if( ! $wp_filesystem->exists( $icon_font['css_file'] ) ) {

			return new WP_Error( 
				'carob-icon-font',
				__( 'Icon font CSS file does not exists!', 'carob-framework' )
			);
		}

		$content = $wp_filesystem->get_contents( $icon_font['css_file'] );

		if( ! $content ) {

			return new WP_Error( 
				'carob-icon-font',
				__( 'There was an error while reading the font CSS file!', 'carob-framework' )
			);
		}

		$icons_list = array();
		$pattern = '/\.(' . $icons_prefix . '-(?:\w+(?:-)?)+):before/';
		
		preg_match_all( $pattern, $content, $icons, PREG_SET_ORDER );

		foreach( $icons as $icon ) {
            
            $icons_list[] = $icon[1];
        }

        if( ! empty( $icons_list ) ) {
			
			$this->fonts_icons_cache = $icons_list;
		}

        return $icons_list;
	}
}
	
endif;

?>