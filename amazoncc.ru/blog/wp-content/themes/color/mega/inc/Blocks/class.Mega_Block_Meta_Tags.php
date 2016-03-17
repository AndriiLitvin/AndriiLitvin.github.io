<?php

class Mega_Block_Meta_Tags extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Meta Tags', 'mega' ), 'description' => __( 'Meta Tags Block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s">',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Tag', 'mega' ), 'pro' => 1, 'value' => __( 'Tags:', 'mega' ), 'name' => 'tag' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Tag Sep', 'mega' ), 'value' => ', ', 'name' => 'tag_sep' ));
	}

	public function callback()
	{
		if ( get_the_tag_list() )
			parent::callback();
	}

	public function block()
	{
		echo '<i></i>' . Mega_Block_Meta::getWrap( 'tag', $this->mega );
	}
}