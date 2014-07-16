<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( dirname(__FILE__) . '/class-carob-meta-box.php' );
require_once( dirname(__FILE__) . '/class-carob-custom-post-types.php' );
require_once( dirname(__FILE__) . '/class-carob-taxonomy.php' );
require_once( dirname(__FILE__) . '/sidebars/class-carob-sidebars.php' );
require_once( dirname(__FILE__) . '/shortcodes-picker/class-carob-shortcode.php' );
require_once( dirname(__FILE__) . '/shortcodes-picker/class-carob-register-shortcodes.php' );
require_once( dirname(__FILE__) . '/shortcodes-picker/class-carob-shortcodes-picker.php' );

if( is_admin() ) {

	require_once( dirname(__FILE__) . '/class-carob-meta-boxes-manager.php' );
	require_once( dirname(__FILE__) . '/sidebars/class-carob-sidebars-admin.php' );
	require_once( dirname(__FILE__) . '/sidebars/class-carob-select-sidebar.php' );
	require_once( dirname(__FILE__) . '/sidebars/class-carob-select-sidebar-validator.php' );
	require_once( dirname(__FILE__) . '/shortcodes-picker/class-carob-shortcodes-admin.php' );
}

?>