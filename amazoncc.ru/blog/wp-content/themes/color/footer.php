<?php

echo

'<div class="mega_theme_block_footer-wrapper cf auto-wrapper even">',

	'<div class="mega_theme_block_footer auto-width horizontal">';

		if ( mega_option( 'show_footer' ))
		{
			echo '<div class="mega_block_parent_vblock vertical widgetized left first">';

			mega_location( 'footer1' );

			echo '</div>';

			echo '<div class="mega_block_parent_vblock vertical widgetized left">';

			mega_location( 'footer2' );

			echo '</div>';

			echo '<div class="mega_block_parent_vblock vertical widgetized left">';

			mega_location( 'footer3' );

			echo '</div>';
		}

	echo

	'<div class="cf"></div>',
	'<a title="Mega WordPress Themes" class="mega right" href="http://www.megathemes.com/">Mega WordPress Themes</a>',
	'</div>',

'</div>';

wp_footer();

echo '</body>';

echo '</html>';