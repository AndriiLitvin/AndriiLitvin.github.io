<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>><?php

echo '<div class="mega_theme_block_nav-wrapper cf auto-wrapper">';

echo '<div class="mega_theme_block_nav cf auto-width horizontal' . ( mega_option( 'show_search' ) ? ' show_search' : '' ) . ( mega_option( 'show_top_button' ) ? ' show_top_button' : '' ) . '">';

mega_widget( 'Mega_Block_Logo' );

mega_nav( array( 'theme_location' => 'menu' ));

if ( mega_option( 'show_search' ))
	get_search_form();

if ( mega_option( 'show_top_button' ))
	echo '<a target="_blank" href="' . esc_url( mega_option( 'top_button_link' )) . '" class="top-button">' . esc_html( mega_option( 'top_button_label' )) . '</a>';

echo '</div>';

echo '</div>';


mega_location( 'slider' );

get_template_part( 'theme/blocks/box_1' );