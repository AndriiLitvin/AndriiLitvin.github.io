<?php

class Mega_Block_CTA extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Call to action', 'mega' ), 'description' => __( 'Call to action block', 'mega' )),
			'universal'		=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Call to action title goes here', 'mega' ), 'name' => 'title' ));
		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Content', 'mega' ), 'name' => 'text' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Button Label', 'mega' ), 'value' => __( 'Detail', 'mega' ), 'pro' => 1, 'name' => 'button_label' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Link', 'mega' ), 'value' => '#', 'name' => 'link' ));
	}

	public function callback()
	{
		echo $this->before();

		extract( $this->mega['settings'] );

		echo

		'<div class="content">',

			mega_html( esc_html( $title ), '<h2>', '</h2>', 0 ),

			mega_html( wpautop( $text ), '<div class="text">', '</div>', 0 ),

		'</div>',

		'<a class="button" href="' . esc_url( $link ) . '"><i class="icon"></i><span>' . esc_html( $button_label ) . '</span></a>';

		echo $this->after();
	}
}