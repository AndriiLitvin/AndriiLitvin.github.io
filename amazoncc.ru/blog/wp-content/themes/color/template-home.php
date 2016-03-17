<?php /* Template Name: Front Page */

get_header();

if ( mega_option( 'show_box_2' ))
{
	echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper even">';

		echo '<div class="mega_theme_block_content cf auto-width vertical" style="padding: 100px 0;">';

			echo '<div class="mega_theme_block_cta2 mega_theme_block_front_box cf horizontal">';

				echo '<div class="mega_block_parent_vblock vertical widgetized left first" style="width: calc((100% + 110px) * 0.666 - 110px);">';

				mega_location( 'front_box_2' );

				echo '</div>';

				echo '<i class="' . esc_attr( mega_option( 'front_cta_icon' )) . ' right first" style="width: calc((100% + 110px) * 0.333 - 110px); color: ' . esc_html( mega_option( 'front_cta_icon_color' )) . '; font-size: 300px;"></i>';

			echo '</div>';

		echo '</div>';

	echo '</div>';
}

if ( mega_option( 'show_box_3' ))
{
	echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper odd">';

		echo '<div class="mega_theme_block_content cf auto-width vertical" style="padding: 100px 0;">';

			echo '<div class="mega_theme_block_heading">';

				echo '<div class="title">' . esc_html( mega_option( 'features2_title' )) . '</div>';
				echo '<div class="sub-title">' . esc_html( mega_option( 'features2_sub_title' )) . '</div>';

			echo '</div>';

			echo '<div class="mega_theme_block_features cf horizontal">';

				echo '<div class="mega_block_parent_vblock vertical widgetized left first" style="width: calc((100% + 110px) * 0.3333 - 110px);">';

				mega_location( 'front_box_3_1' );

				echo '</div>';

				echo '<div class="mega_block_parent_vblock vertical widgetized left" style="width: calc((100% + 110px) * 0.3333 - 110px); margin-left: 110px;">';

				mega_location( 'front_box_3_2' );

				echo '</div>';

				echo '<div class="mega_block_parent_vblock vertical widgetized left" style="width: calc((100% + 110px) * 0.3333 - 110px); margin-left: 110px;">';

				mega_location( 'front_box_3_3' );

				echo '</div>';

			echo '</div>';

		echo '</div>';

	echo '</div>';
}

if ( mega_option( 'show_box_4' ))
{
	echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper even">';

		echo '<div class="mega_theme_block_content mega_theme_block_enteries cf auto-width vertical">';

			echo '<div class="mega_theme_block_heading">';

				echo '<div class="title">' . esc_html( mega_option( 'enteries_title' )) . '</div>';
				echo '<div class="sub-title">' . esc_html( mega_option( 'enteries_sub_title' )) . '</div>';

			echo '</div>';

			echo '<div class="mega_block_parent_vblock vertical widgetized">';

			mega_location( 'front_box_4' );

			echo '</div>';

		echo '</div>';

	echo '</div>';
}

if ( mega_option( 'show_box_5' ))
{
	echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper even">';

		echo '<div class="mega_theme_block_content cf auto-width vertical" style="padding: 44px 0;">';

			echo '<div class="mega_block_parent_vblock vertical widgetized">';

			mega_location( 'front_box_5' );

			echo '</div>';

		echo '</div>';

	echo '</div>';
}

if ( mega_option( 'show_box_6' ))
{
	echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper odd">';

		echo '<div class="mega_theme_block_content cf auto-width vertical center-inside mega_theme_block_front_box" style="padding: 100px 0;">';

			echo '<div class="mega_block_parent_vblock vertical widgetized">';

			mega_location( 'front_box_6' );

			echo '</div>';

		echo '</div>';

	echo '</div>';
}

get_footer();