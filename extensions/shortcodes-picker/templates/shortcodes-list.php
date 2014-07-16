<div class="carob-options carob-options--meta-box">

	<p class="carob-notice">
		<?php echo esc_html( __( 'Place the cursor where you want to insert the shortcode and click on the desired shortcode from the list below:', 'carob-framework' ) ); ?>
	</p>
	<div class="carob-line"></div>

	<ul class="carob-shortcodes-list">

		<?php

			foreach ( $shortcodes as $shortcode ) :

				$data = array(
					'id' => $shortcode->get_name(),
					'name' => $shortcode->get_name(),
					'title' => $shortcode->get_title(),
					'has_options' => $shortcode->has_options(),
					'has_content' => $shortcode->has_content()
				);

				$data = json_encode( $data );
				
		?>

			<li class="carob-shortcode" data-shortcode="<?php echo esc_attr( $data ); ?>">
				<img src="<?php echo esc_url( $shortcode->get_icon() ); ?>" alt="<?php echo esc_attr( $shortcode->get_name() ); ?>"/>
				<span><?php echo esc_html( $shortcode->get_title() ); ?></span>
			</li>
		
		<?php endforeach; ?>

	</ul>

</div>