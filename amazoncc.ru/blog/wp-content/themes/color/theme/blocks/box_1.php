<?php

if ( mega_option( 'show_box_1' ) && mega_toggle( mega_option( 'box_1_location' )))
{
	echo '<div class="mega_theme_block_content-wrapper cf auto-wrapper odd">';

		echo '<div class="mega_theme_block_content cf auto-width vertical" style="padding: 100px 0;">';

			echo '<div class="mega_theme_block_heading">';

				echo '<div class="title">' . esc_html( mega_option( 'features_title' )) . '</div>';
				echo '<div class="sub-title">' . esc_html( mega_option( 'features_sub_title' )) . '</div>';

			echo '</div>';

			echo '<div class="mega_theme_block_features cf horizontal">';

				echo '<div class="mega_block_parent_vblock vertical widgetized left first" style="width: calc((100% + 110px) * 0.3333 - 110px);">';

				mega_location( 'front_box_1_1' );

				echo '</div>';

				echo '<div class="mega_block_parent_vblock vertical widgetized left" style="width: calc((100% + 110px) * 0.3333 - 110px); margin-left: 110px;">';

				mega_location( 'front_box_1_2' );

				echo '</div>';

				echo '<div class="mega_block_parent_vblock vertical widgetized left" style="width: calc((100% + 110px) * 0.3333 - 110px); margin-left: 110px;">';

				mega_location( 'front_box_1_3' );

				echo '</div>';

			echo '</div>';

		echo '</div>';

	echo '</div>';
}