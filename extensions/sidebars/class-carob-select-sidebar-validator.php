<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Select_Sidebar_Validator' ) ) :

class Carob_Select_Sidebar_Validator implements Carob_Validatable {
	
	public function validate( $option, $value ) {

		$framework = Carob_Framework::get_instance();
		$carob_sidebars = $framework->get_extension( 'sidebars' );
		$sidebars = $carob_sidebars->get_sidebars_list();

		if( empty( $sidebars ) ) {

			return $option['default'];
		}

		$select_values = array();

		foreach ( $sidebars as $option_item ) {
			
			$select_values[] = $option_item['value'];
		}

		if( ! in_array( $value, $select_values ) ) {
			
			return $option['default'];
		}

		return $value;
	}
}

endif;

?>