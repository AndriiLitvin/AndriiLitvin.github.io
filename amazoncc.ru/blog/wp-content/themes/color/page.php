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

		if ( have_posts() ) : while ( have_posts() ) : the_post();

		echo '<div id="post-' . get_the_ID() . '" class="' . join( ' ', get_post_class() ) . '">';

		mega_widget( 'Mega_Block_Content' );

		echo '</div>';

		endwhile;

		if ( mega_option( 'show_comments' ))
			comments_template();

		endif;

	echo '</div>';

	if ( !is_page_template( 'template-onecolumn.php' ))
		get_sidebar();

echo '</div>';

echo '</div>';

get_footer();