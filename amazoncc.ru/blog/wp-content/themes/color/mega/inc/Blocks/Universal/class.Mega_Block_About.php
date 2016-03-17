<?php

class Mega_Block_About extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'About', 'mega' ), 'description' => __( 'About block', 'mega' )),
			'universal'	=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Title Type', 'mega' ), 'pro' => 1, 'value' => 'text', 'name' => 'title_type', 'choices' => array(
			'text'	=> __( 'Text', 'mega' ),
			'image'	=> __( 'Image', 'mega' )
		)));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'title_type', 'control_value' => 'text', 'label' => __( 'Title', 'mega' ), 'value' => __( 'About Us', 'mega' ), 'name' => 'title' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'title_type', 'control_value' => 'image', 'label' => __( 'Image', 'mega' ), 'value' => '', 'name' => 'image' ));

		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Text', 'mega' ), 'value' => __( 'Lorem ipsum dolor sit amet, id elit lorem, id morbi volutpat vitae mauris donec, porta nulla potenti varius tempor nec. mollis sed vel, massa odio interdum pretium malesuada dolornunc.', 'mega' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Read More', 'mega' ), 'value' => 1, 'name' => 'rm' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'rm', 'control_value' => 'true', 'label' => __( 'Read More URL', 'mega' ), 'value' => '#', 'name' => 'rm_link' ));
	}

	public function getTitle()
	{
		extract( $this->mega['settings'] );

		if ( $title_type === 'text' )
			parent::getTitle();
		else
			echo '<img class="logo" src="' . esc_url( $image ) . '" />';
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		if ( $rm )
			$text .= ' <a class="more" href="' . esc_url( $rm_link ) . '"><span>more ...</span><i></i></a>';

		echo wpautop( $text );
	}
}