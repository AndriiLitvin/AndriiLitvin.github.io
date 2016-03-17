<?php

class Mega_Block_Copyright extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Copyright', 'mega' ), 'description' => __( 'Copyright block', 'mega' )),
			'before'		=> '<div id="%1$s" class="%2$s %3$s" %4$s>',
			'after'			=> '</div>',
			'universal'		=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Copyright', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Text', 'mega' ), 'desc' => __( '[date] is Year, [link] is Homelink', 'mega' ), 'value' => __( 'This site uses valid HTML 5.0 and CSS 3.0. All content Copyright &copy; [date] [link]. All Rights Reserved.', 'mega' ), 'name' => 'text' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		$link = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', esc_url( home_url()), esc_attr( get_bloginfo( 'description' )), esc_html( get_bloginfo( 'name' )));

		echo wpautop( mega_parse_message( array( 'date' => date( 'Y' ), 'link' => $link ), $text ));
	}
}