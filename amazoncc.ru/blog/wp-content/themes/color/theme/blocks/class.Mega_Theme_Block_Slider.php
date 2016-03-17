<?php

class Mega_Theme_Block_Slider extends Mega_Block_Slider_Jssor
{
	public function __construct()
	{
		parent::__construct( __CLASS__ );
	}

	public function block( $k = '' )
	{
		extract( $this->mega['settings'] );

		if ( $source === 'auto' )
		{
			$this->auto();

			return;
		}
//height: ' . $height . 'px;
		echo '<div class="slide_wrap clear" style="width: 100%; background-image: url(' . ${'custom_' . $k . '_bg_image_url'} . ');">';

		echo '<div class="slide-inner">';

		echo mega_auto_tag( 'h2', array( 'text' => mega_auto_tag( 'a', array( 'text' => esc_html( ${'custom_' . $k . '_title'} ), 'attr' => array( 'href' => ${'custom_' . $k . '_link'} )))));

		echo '<div class="text">' . wpautop( ${'custom_' . $k . '_text'} ) . '</div>';

		echo !empty( ${'custom_' . $k . '_link'} ) ? '<a class="mega_button slider_button btn" href="' . esc_url( ${'custom_' . $k . '_link'} ) . '">' . esc_html( ${'custom_' . $k . '_button_label'} ) . '</a>' : '';

		echo '</div>';

		if ( ${'custom_' . $k . '_image'} )
		{
			$thumb = mega_thumb( array( 'width' => ${'custom_' . $k . '_width'}, 'height' => ${'custom_' . $k . '_height'}, 'custom' => ${'custom_' . $k . '_image_url'}, 'sources' => array( 'custom' => 1, 'ph' => ${'custom_' . $k . '_show_placeholder'} )), 1 );

			$thumb = '<img src="' . esc_url( $thumb ) . '" class="thumb" />';

			echo '<div class="thumb">' . mega_auto_tag( 'a', array( 'text' => $thumb, 'attr' => array( 'href' => ${'custom_' . $k . '_link'} ))) . '</div>';
		}

//, 'placeholder' => 'http://placehold.it/%1$sx%2$s/fff'

		echo '</div>';
	}

	public function auto()
	{
		extract( $this->mega['settings'] );

		echo '<div class="slide_wrap clear" style="width: 100%;">';//height: ' . $height . 'px;

		echo '<div class="slide-inner">';

		echo mega_auto_tag( 'h2',
			array(
				'text' => mega_auto_tag( 'a',
					array(
						'text' => $show_title ? esc_html( mega_clean_words( $title_count, get_the_title() )) : '',
						'attr' => array( 'href' => $show_link ? get_permalink() : '' )
					)
				)
			)
		);

		echo '<div class="text">' . wpautop( esc_html( mega_clean_words( $excerpt_count, get_the_excerpt() ))) . '</div>';

		echo $show_link ? '<a class="mega_button slider_button btn" href="' . esc_url( get_permalink() ) . '">' . _x( 'Continue', 'Slider', 'color' ) . '</a>' : '';

		echo '</div>';

		if ( $auto_image )
		{
			$thumb = mega_thumb( array( 'width' => $auto_image_width, 'height' => $auto_image_height, 'sources' => $auto_image_sources ), 1 );

			$thumb = '<img src="' . esc_url( $thumb ) . '" class="thumb" />';

			echo '<div class="thumb">' . mega_auto_tag( 'a', array( 'text' => $thumb, 'attr' => array( 'href' => $show_link ? get_permalink() : '' ))) . '</div>';
		}

		echo '</div>';
	}
}