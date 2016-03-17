<?php /* Template Name: Contact Page */

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

echo '<div class="mega_theme_block_content cf auto-width vertical">';

echo '<div class="mega_block_parent_vblock vertical widgetized" style="width: 100%; margin-bottom: 30px;">';

mega_location( 'contact_page_top' );

echo '</div>';

echo '<div class="cf horizontal">';

	echo '<div class="mega_block_parent_vblock vertical widgetized left" style="width: 48%;">';

	mega_location( 'contact_page_left' );

	echo '</div>';

	echo '<div class="mega_block_parent_vblock vertical widgetized right" style="width: 48%;">';

	mega_location( 'contact_page_right' );

	echo '</div>';

echo '</div>';

echo '</div>';

echo '</div>';

get_footer();