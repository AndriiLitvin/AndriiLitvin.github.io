<?php

if ( mega_option( 'paginate_above_posts' ))
	mega_widget( 'Mega_Block_Paginate' );

if ( have_posts() ) : while ( have_posts() ) : the_post();

echo '<div id="post-' . get_the_ID() . '" class="' . join( ' ', get_post_class() ) . '">';

	echo '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" title="' . get_the_title() . '">' . ( get_the_title() === '' ? __( 'No Title', 'color' ) : get_the_title() ) . '</a></h2>';

	mega_widget( 'Mega_Block_Meta' );

	mega_widget( 'Mega_Block_Content' );

	mega_widget( 'Mega_Theme_Block_Toolbar' );

echo '</div>';

endwhile;

else :

	echo '<div id="post-0" class="hentry">';

		echo '<div class="entry">';

			echo

			'<p>' . __( 'We are really sorry but the page you requested was not found.', 'color' ) . '</p>',

			'<p>' . __( 'It seems that the page you were trying to reach does not exist anymore or maybe it has just been moved. Try using the search form below.', 'color' ) . '</p>',

			'<p>' . __( 'Sorry for the inconvenience.', 'color' ) . '</p>';

			get_search_form();

		echo '</div>';

	echo '</div>';

endif;

if ( mega_option( 'paginate_below_posts' ))
	mega_widget( 'Mega_Block_Paginate' );