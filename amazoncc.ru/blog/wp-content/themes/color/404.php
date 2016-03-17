<?php

get_header();

echo '<div class="mega_theme_block_content_top-wrapper cf auto-wrapper">';

	echo '<div class="mega_theme_block_content_top cf auto-width horizontal">';

		mega_widget( 'Mega_Block_Breadcrumbs', array( 'end_leaf' => 1 ));

		if ( mega_option( 'cta_button' ))
			if ( mega_toggle( mega_option( 'cta_button_location' )))
				echo '<a href="' . esc_url( mega_option( 'cta_button_url' )) . '" class="button">' . esc_html( mega_option( 'cta_button_label' )) . '<i></i></a>';

	echo '</div>';

echo '</div>';

echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper odd">';

echo '<div class="mega_theme_block_content cf auto-width horizontal">';

	echo '<div class="mega_theme_block_main ' . ( mega_option( 'layout' ) !== 'fullwidth' ? esc_attr( mega_option( 'layout' )) : 'w100' ) . '">';

		echo '<div id="post-0" class="hentry">';

			echo '<div class="entry">';

				echo

				'<p>' . __( 'We are really sorry but the page you requested was not found.', 'color' ) . '</p>',

				'<p>' . __( 'It seems that the page you were trying to reach does not exist anymore or maybe it has just been moved. Try using the search form below.', 'color' ) . '</p>',

				'<p>' . __( 'Sorry for the inconvenience.', 'color' ) . '</p>';

				get_search_form();

			echo '</div>';

		echo '</div>';

	echo '</div>';

	get_sidebar();

echo '</div>';

echo '</div>';

get_footer();