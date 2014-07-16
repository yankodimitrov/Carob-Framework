<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'manage_options' ) ) {
	
	wp_die( __( 'You do not have sufficient permissions to access this page.', 'carob-framework' ) );
}

$carob_framework = Carob_Framework::get_instance();
$carob_sidebars = $carob_framework->get_extension( 'sidebars' );
$sidebars = json_encode( $carob_sidebars->get_custom_sidebars() );

?>

<form method="post" id="carob-custom-sidebars-form">

	<div class="carob-page-wrap carob-page-wrap--no-sidebar">
		
		<div class="carob-page-header">
			
			<h2 class="title">
				<?php echo esc_html( __( 'Custom Sidebars', 'carob-framework' ) ); ?>
			</h2>
			<p class="description carob-description">
				<?php echo esc_html( __( 'Manage your custom sidebars.', 'carob-framework' ) ); ?>
			</p>

		</div>

		<div class="carob-page-content-wrap">
			
			<div data-sidebars="<?php echo esc_attr( $sidebars ); ?>" class="carob-options carob-page-content carob-custom-sidebars">
				
				<div class="carob-header">
					
					<h3>
						<?php echo esc_html( __( 'Add New Sidebar', 'carob-framework' ) ); ?>
					</h3>
					
					<p class="description carob-description">
						<?php echo esc_html( __( 'Use an unique name for each custom sidebar.', 'carob-framework' ) ); ?>
					</p>
					
					<p class="carob-notice">
						<?php echo esc_html( __( "Before you delete a sidebar, remove or move all of its widgets. Otherwise widgets will be appended to the next available sidebar.", 'carob-framework' ) ); ?>
					</p>
					<div class="carob-line"></div>
					
					<input 	type="text" name="sidebar-name" class="carob-input medium carob-sidebar-name carob-left" value="" placeholder="<?php echo esc_attr( __( 'Sidebar Name', 'carob-framework' ) ) ; ?>" />
					<input type="submit" class="button carob-add-sidebar carob-left" value="<?php echo esc_attr( __( 'Add Sidebar', 'carob-framework' ) ); ?>"/>
			
					<div class="carob-clear"></div>

				</div>

			</div>

		</div>

		<div class="carob-toolbar">
			
			<input type="submit" class="carob-clear button carob-left" value="<?php echo esc_attr( __( 'Remove Custom Sidebars', 'carob-framework' ) ); ?>"/>
			<input type="submit" class="carob-save button button-primary carob-right" value="<?php echo esc_attr( __( 'Save Sidebars', 'carob-framework' ) ); ?>"/>
			
			<div class="carob-clear"></div>
		</div>

	</div>

</form>