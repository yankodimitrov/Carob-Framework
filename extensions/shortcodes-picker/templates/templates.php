<!-- Carob Shortcodes Picker -->
<script type="text/html" id="carob-tmpl-shortcodes">
	
	<div class="media-modal wp-core-ui carob-edit-frame">
		
		<a class="media-modal-close" href="#" title="Close">
			<span class="media-modal-icon"></span>
		</a>

		<div class="media-modal-content">
			<div class="media-frame hide-menu">

				<div class="media-frame-title">
					
					<h1 class="carob-frame-title">
						<?php _e( 'Shortcodes Picker', 'carob-framework' ); ?>
					</h1>
					
					<div class="loader">
						<img src="<?php echo CAROB_FRAMEWORK_URI . 'extensions/shortcodes-picker/images/ajax-loader.gif'; ?>" alt="Loader"/>
					</div>
					<div class="carob-clear"></div>

				</div>
				
				<form id="carob-shortcode-options-form" method="post" action="post.php">
					<div class="media-frame-content carob-shortcode-options"></div>
				</form>

				<div class="media-frame-toolbar">
					<div class="media-toolbar">
						<div class="media-toolbar-primary">
							<a href="#" class="button media-button button-primary button-large button-insert">
								<?php _e( 'Insert Shortcode', 'carob-framework' ); ?>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
	<div class="media-modal-backdrop"></div>

</script>