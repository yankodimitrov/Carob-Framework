<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Select_Sidebar' ) ) : 

class Carob_Select_Sidebar extends Carob_Option {

	public function display( $option, $value ) {

		$framework = Carob_Framework::get_instance();
		$carob_sidebars = $framework->get_extension( 'sidebars' );
		$sidebars = $carob_sidebars->get_sidebars_list();

		parent::display_title( $option );

		if( empty( $sidebars ) ) {
			
			echo '<p class="carob-notice">' . 
					__( 'There are no sidebars available. You can create one in Appearance &rarr; Sidebars.', 'carob-framework' ) . 
				'</p>';
			
			return;
		}

		echo '<select name="' . esc_attr( $option['id'] ) . '" class="' . esc_attr( $option['class'] ) . '">';

		foreach ( $sidebars as $item ) {
			
			$selected = '';

			if( $value == $item['value'] ) {
				
				$selected = ' selected=selected';
			}

			echo '<option value="' . esc_attr( $item['value'] ) . '" ' . $selected . '>
					' . esc_html( $item['label'] ) . '
				  </option>';
		}

		echo '</select>';
	}
}
	
endif;

?>