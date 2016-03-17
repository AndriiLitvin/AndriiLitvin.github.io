<?php

class Mega_Block_Logo extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Logo', 'mega' ), 'description' => __( 'Logo block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s %3$s align_%3$s" %4$s>',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Type', 'mega' ), 'value' => 'text', 'name' => 'type',
			'choices' => array(
				'text'	=> __( 'Text', 'mega' ),
				'image'	=> __( 'Image', 'mega' )
			)
		));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'type', 'control_value' => 'image', 'label' => __( 'Image URL', 'mega' ), 'name' => 'image' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'type', 'control_value' => 'image', 'label' => __( 'Image Height (px)', 'mega' ), 'name' => 'height' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'type', 'control_value' => 'text', 'label' => __( 'Text', 'mega' ), 'value' => get_bloginfo( 'name' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Width (px)', 'mega' ), 'name' => 'width' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		echo

		'<a class="' . $type . '" href="' . esc_url( home_url( '/' )) . '" title="' . esc_attr( get_bloginfo( 'description' )) . '" style="width: ' . $width . 'px;">',
		$type == 'text' ? $text : '<img src="' . esc_url( $image ) . '" width="' . $width . '" height="' . $height . '" alt="' . esc_attr( $text ) . '" />',
		'</a>';
	}
}