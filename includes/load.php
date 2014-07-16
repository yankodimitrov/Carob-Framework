<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( dirname(__FILE__) . '/class-carob-framework.php' );

if( is_admin() ) {

	require_once( dirname(__FILE__) . '/class-carob-options.php' );
	require_once( dirname(__FILE__) . '/class-carob-options-view.php' );
	require_once( dirname(__FILE__) . '/class-carob-meta-options-view.php' );
	require_once( dirname(__FILE__) . '/class-carob-page-options-view.php' );
	require_once( dirname(__FILE__) . '/class-carob-options-factory.php' );
	require_once( dirname(__FILE__) . '/class-carob-abstract-cache.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-options-cache.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-validators-cache.php' );

	// load options
	require_once( dirname(__FILE__) . '/options/class-carob-default-option.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-heading.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-text.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-textarea.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-checkbox.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-checkboxes.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-radio.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-select.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-editor.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-select-image-option.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-slider-input.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-color-picker.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-switch-toggle.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-file.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-gallery.php' );
	require_once( dirname(__FILE__) . '/options/class-carob-icon-picker.php' );

	// load validators
	require_once( dirname(__FILE__) . '/validators/class-carob-default-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-text-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-checkbox-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-select-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-checkboxes-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-slider-input-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-color-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-file-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-gallery-validator.php' );
	require_once( dirname(__FILE__) . '/validators/class-carob-icon-picker-validator.php' );
}

?>