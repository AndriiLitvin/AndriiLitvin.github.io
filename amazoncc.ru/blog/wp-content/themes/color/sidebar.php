<?php

if ( mega_option( 'layout' ) !== 'fullwidth' ) :

echo '<div style="width: 26%;" class="mega_block_parent_vblock vertical widgetized ' . ( mega_option( 'layout' ) === 'left' ? 'right' : 'left' ) . '">';

mega_location( 'r-sidebar' );

echo '</div>';

endif;