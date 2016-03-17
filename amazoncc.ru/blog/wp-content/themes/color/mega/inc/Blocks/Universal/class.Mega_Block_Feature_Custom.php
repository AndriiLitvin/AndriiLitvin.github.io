<?php

class Mega_Block_Feature_Custom extends Mega_Block_Feature_Skeleton
{
	public function __construct()
	{
		parent::__construct( __CLASS__, array(
			'profile' => array( 'name' => __( 'Feature: Custom', 'mega' ), 'description' => __( 'Feature: Custom', 'mega' ))
		));
	}

	public function settings( $form )
	{
		parent::settings( $form );

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image URL', 'mega' ), 'name' => 'image_url' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Link', 'mega' ), 'value' => '#', 'name' => 'link' ));

		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Content', 'mega' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Button', 'mega' ), 'value' => 0, 'name' => 'show_button' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_button', 'control_value' => 'true', 'label' => __( 'Button Label', 'mega' ), 'value' => __( 'Continue reading', 'mega' ), 'name' => 'button_label' ));
	}

	public function callback()
	{
		extract( $this->mega['settings'] );

		echo $this->before();

		if ( $image )
			mega_thumb( array( 'custom' => $image_url, 'width' => $width . '%', 'maxheight' => $max_height . 'px', 'sources' => array( 'custom' => 1 )));

		$this->getIcon();

		$this->autoTagTitle( $link, $title );

		$this->getTitle();

		mega_html( wpautop( $text ), '<div class="text">', '</div>' );

		if ( $show_button )
			echo mega_auto_tag( 'a', array( 'text' => '<i class="icon"></i><span>' . esc_html( $button_label ) . '</span>', 'attr' => array( 'href' => $link, 'class' => 'button' )));

		echo $this->after();
	}
}