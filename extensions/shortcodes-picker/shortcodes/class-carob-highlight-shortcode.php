<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Highlight_Shortcode' ) ) :

class Carob_Highlight_Shortcode extends Carob_Shortcode {
	
	public function __construct() {

		$this->name = 'carob_highlight';
		$this->title = 'Highlight';
		$this->icon = CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/images/highlight.png';
		$this->has_content = true;

		parent::register();
	}

	public function get_options() {

		$options = array();

		$options[] = array( 
			'title' => __( 'Highlight', 'carob-framework' ),
			'id' => 'heading',
			'desc' => __( 'Write the highlighted text in the shortcode content field below.', 'carob-framework' ),
			'default' => '',
			'type' => 'heading'
		);

		// Highlight Background Color
		$options[] = array( 
			'title' => __( 'Background Color', 'carob-framework' ),
			'id' => 'bgcolor',
			'desc' => __( 'Select the highlight background color:', 'carob-framework' ),
			'default' => 'fbecbb',
			'class' => 'carob-color-picker',
			'type' => 'color_picker'
		);

		// Highlight Text Color
		$options[] = array( 
			'title' => __( 'Text Color', 'carob-framework' ),
			'id' => 'color',
			'desc' => __( 'Select the highlight text color:', 'carob-framework' ),
			'default' => '7a7a7a',
			'class' => 'carob-color-picker',
			'type' => 'color_picker'
		);

		return $options;
	}

	public function display( $atts, $content = '' ) {

		$params = array( 
			'bgcolor' => 'fbecbb',
			'color' => '7a7a7a'
		);

		$atts = shortcode_atts( $params, $atts );
		
		$style = 'background-color: #' . esc_attr( $atts['bgcolor'] ) . '; ';
		$style .= 'color: #' . esc_attr( $atts['color'] ) . ';';
		
		return '<span class="highlight" style="' . $style . '">' . esc_html( $content ) . '</span>';
	}
}

endif;

?>