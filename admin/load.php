<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( is_admin() ) {

	require_once( dirname(__FILE__) . '/class-carob-admin.php' );
}

?>