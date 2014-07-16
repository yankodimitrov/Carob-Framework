<?php

/**
 * Plugin Name: Carob Framework
 * Plugin URI: https://github.com/ydimitrov/Carob-Framework
 * Description: A WordPress framework for premium themes.
 * Version: 1.0.0
 * Author: Yanko Dimitrov
 * Author URI: http://www.yankodimitrov.com
 * Requires: WordPress 3.6+
 * 
 * Text Domain: carob-framework
 * Domain Path: languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Carob_Loader' ) ) :

class Carob_Loader {

	public function __construct() {

		add_action( 'after_setup_theme', array( &$this, 'init' ) );
	}

	public function init() {

		$this->set_constants();
		$this->set_text_domain();
		$this->load_files();

		$framework = Carob_Framework::get_instance();
		$framework->add_extension( 'taxonomy', new Carob_Taxonomy() );
		$framework->add_extension( 'post_types', new Carob_Custom_Post_Types() );
		$framework->add_extension( 'sidebars', new Carob_Sidebars() );
		$framework->add_extension( 'shortcodes-picker', new Carob_Shortcodes_Picker() );

		if( is_admin() ) {
			
			$options = new Carob_Options();
			$framework_admin = new Carob_Admin();
			$sidebars_admin = new Carob_Sidebars_Admin();
			$shortcodes_admin = new Carob_Shortcodes_Admin();

			$framework->add_extension( 'meta_boxes', new Carob_Meta_Boxes_Manager() );
			$framework->add_extension( 'options_view', new Carob_Options_View() );
			$framework->add_extension( 'meta_options_view', new Carob_Meta_Options_View() );
			$framework->add_extension( 'page_options_view', new Carob_Page_Options_View() );
		}
	}

	private function set_constants() {

		define( 'CAROB_FRAMEWORK_VERSION', '1.0.0' );
		define( 'CAROB_FRAMEWORK_ROOT', plugin_dir_path( __FILE__ ) );
		define( 'CAROB_FRAMEWORK_URI', plugin_dir_url( __FILE__ ) );
	}

	private function set_text_domain() {

		load_plugin_textdomain( 'carob-framework', false, CAROB_FRAMEWORK_ROOT . 'languages/' );
	}

	private function load_files() {

		require_once( CAROB_FRAMEWORK_ROOT . '/includes/class-carob-option.php' );
		require_once( CAROB_FRAMEWORK_ROOT . '/includes/carob-validatable.php' );
		require_once( CAROB_FRAMEWORK_ROOT . 'admin/load.php' );
		require_once( CAROB_FRAMEWORK_ROOT . 'extensions/load.php' );
		require_once( CAROB_FRAMEWORK_ROOT . 'includes/load.php' );
	}
}

$carob_loader = new Carob_Loader();

endif;

?>