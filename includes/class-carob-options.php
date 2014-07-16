<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Options' ) ) :

class Carob_Options {

	public function __construct() {

		$this->register_options();
	}

	private function register_options() {

		// register the default options

		$options_factory = Carob_Options_Factory::get_instance();
		$options = $this->get_default_options();
			
		foreach( $options as $type => $option ) {
			
			$options_factory->register_option( $type, $option );
		}
		
	}

	private function get_default_options() {

		$options = array();
		
		$options['heading'] = array( 
			'class' => 'Carob_Heading',
			'validator' => 'Carob_Default_Validator'
		);

		$options['text'] = array( 
			'class' => 'Carob_Text',
			'validator' => 'Carob_Text_Validator'
		);
			
		$options['textarea'] = array( 
			'class' => 'Carob_Textarea',
			'validator' => 'Carob_Text_Validator'
		);

		$options['checkbox'] = array( 
			'class' => 'Carob_Checkbox',
			'validator' => 'Carob_Checkbox_Validator'
		);
		
		$options['radio'] = array( 
			'class' => 'Carob_Radio',
			'validator' => 'Carob_Select_Validator'
		);

		$options['select'] = array( 
			'class' => 'Carob_Select',
			'validator' => 'Carob_Select_Validator'
		);

		$options['checkboxes'] = array( 
			'class' => 'Carob_Checkboxes',
			'validator' => 'Carob_Checkboxes_Validator'
		);

		$options['editor'] = array( 
			'class' => 'Carob_Editor',
			'validator' => 'Carob_Text_Validator'
		);

		$options['select_image_option'] = array( 
			'class' => 'Carob_Select_Image_Option',
			'validator' => 'Carob_Select_Validator'
		);

		$options['slider_input'] = array( 
			'class' => 'Carob_Slider_Input',
			'validator' => 'Carob_Slider_Input_Validator'
		);

		$options['color_picker'] = array( 
			'class' => 'Carob_Color_Picker',
			'validator' => 'Carob_Color_Validator'
		);

		$options['switch_toggle'] = array( 
			'class' => 'Carob_Switch_Toggle',
			'validator' => 'Carob_Checkbox_Validator'
		);

		$options['file'] = array( 
			'class' => 'Carob_File',
			'validator' => 'Carob_File_Validator'
		);

		$options['gallery'] = array( 
			'class' => 'Carob_Gallery',
			'validator' => 'Carob_Gallery_Validator'
		);

		$options['icon_picker'] = array( 
			'class' => 'Carob_Icon_Picker',
			'validator' => 'Carob_Icon_Picker_Validator'
		);

		return $options;
	}

}

endif;

?>