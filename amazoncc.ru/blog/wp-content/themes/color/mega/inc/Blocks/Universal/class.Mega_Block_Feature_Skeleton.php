<?php

class Mega_Block_Feature_Skeleton extends Mega_Walker
{
	public function __construct( $id_base = __CLASS__, $args = array() )
	{
		$args = wp_parse_args( $args, array(
			'before'		=> '<div id="%1$s" class="%2$s %3$s widget">',
			'after'			=> '</div>',
			'universal'		=> true
		));

		add_filter( 'mega_block_feature_custom_args', array( &$this, 'mega_block_feature_args' ));
		add_filter( 'mega_block_feature_auto_args', array( &$this, 'mega_block_feature_args' ));

		parent::__construct( $id_base, $args );
	}

	public function mega_block_feature_args( $args )
	{
		$args['enqueue']['css'] = array( 'id' => 'mega_block_feature', 'path' => '/theme/assets/css/class.Mega_Block_Feature.css' );

		return $args;
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Alignment', 'mega' ), 'value' => 'center', 'name' => 'alignment',
			'choices' => array(
				'left'		=> __( 'Left', 'mega' ),
				'center'	=> __( 'Center', 'mega' ),
				'right'		=> __( 'Right', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Icon List', 'mega' ), 'value' => 'ion', 'name' => 'icon_list',
			'choices' => array(
				'ion'	=> __( 'Ionicons', 'mega' ),
				'fa'	=> __( 'Font awesome', 'mega' )
			)
		));

			$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'icon_list', 'control_value' => 'fa', 'label' => __( 'Fa Icon', 'mega' ), 'value' => '', 'name' => 'icon', 'use_list' => 1, 'list' => 'mega_fa_icon_list' ));

			$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'icon_list', 'control_value' => 'ion', 'label' => __( 'Ion Icon', 'mega' ), 'value' => '', 'name' => 'icon2', 'use_list' => 1, 'list' => 'mega_ion_icon_list' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Icon Color', 'mega' ), 'name' => 'color' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Image', 'mega' ), 'name' => 'image' ));

			$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image Width (%)', 'mega' ), 'value' => 100, 'name' => 'width' ));

			$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image Max Height (px)', 'mega' ), 'value' => 130, 'name' => 'max_height' ));
	}

	public function before()
	{
		$this->mega['args']['class'][0] = 'align-' . $this->mega['settings']['alignment'];

		return parent::before();
	}

	public function hook()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ));
	}

	public function enqueue()
	{
		extract( $this->mega['settings'] );

		if ( $icon_list === 'fa' && !empty( $icon ))
			wp_enqueue_style( 'mega.fontawesome' );
		else if ( $icon_list === 'ion' && !empty( $icon2 ))
			wp_enqueue_style( 'mega.ionicons' );
	}

	public function getIcon()
	{
		extract( $this->mega['settings'] );

		if ( $icon_list === 'fa' && !empty( $icon ))
			echo '<i class="fa ' . esc_attr( $icon ) . '" style="color: ' . $color . ';"></i>';
		else if ( $icon_list === 'ion' && !empty( $icon2 ))
			echo '<i class="ion ' . esc_attr( $icon2 ) . '" style="color: ' . $color . ';"></i>';
	}

	public function autoTagTitle( $link, $text )
	{
		$this->mega['settings']['title'] = mega_auto_tag( 'a', array(
			'text' => $text,
			'attr' => array( 'href' => $link )
		));
	}

	public function getButton( $link, $label )
	{
		return mega_auto_tag( 'a', array( 'text' => '<i class="icon"></i><span>' . esc_html( $label ) . '</span>', 'attr' => array( 'href' => $link, 'class' => 'button' )));
	}
}