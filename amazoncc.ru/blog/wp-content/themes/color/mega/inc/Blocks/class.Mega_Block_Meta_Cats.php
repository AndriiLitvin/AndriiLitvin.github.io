<?php

class Mega_Block_Meta_Cats extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Meta Cats', 'mega' ), 'description' => __( 'Meta Cats Block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s">',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Cat', 'mega' ), 'value' => __( 'Cats:', 'mega' ), 'name' => 'category' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Cat Sep', 'mega' ), 'value' => ', ', 'name' => 'cat_sep' ));
	}

	public function callback()
	{
		if ( !Mega_Block_Meta::getWrap( 'category', $this->mega ))
			return;

		parent::callback();
	}

	public function block()
	{
		echo '<i></i>' . Mega_Block_Meta::getWrap( 'category', $this->mega );
	}
}