<!-- Carob Sidebar -->
<script type="text/html" id="carob-tmpl-sidebar">
					
	<span class="name"><%= _.escape( name ) %></span>

	<div class="controls">
		<a href="#" class="delete" title="<?php echo esc_attr( __( 'Delete Sidebar', 'carob-framework' ) ); ?>">
			<span class="delete-icon"></span>
		</a>
	</div>

</script>

<?php if( ! defined( 'CAROB_THEME_OPTIONS_ID' ) ) : ?>
	
	<!-- Carob Notification -->
	<div id="carob-notification" class="carob-notification info">
		<p class="content"></p>
	</div>

<?php endif; ?>