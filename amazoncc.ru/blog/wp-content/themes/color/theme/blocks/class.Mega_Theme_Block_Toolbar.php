<?php

class Mega_Theme_Block_Toolbar extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Toolbar', 'mega' ), 'description' => __( 'Toolbar Block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s %3$s cf"%4$s>',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Toolbar', 'mega' ), 'value' => 1, 'name' => 'show_toolbar' ));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'show_toolbar', 'control_value' => 'true', 'label' => __( 'Show Share', 'mega' ), 'pro' => 1, 'value' => 0, 'name' => 'show_share' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Share Label', 'mega' ), 'pro' => 1, 'value' => __( 'Share', 'mega' ), 'name' => 'share_label' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		if ( !$show_toolbar )
			return;

		if ( mega_option( 'show_tags' ))
			mega_widget( 'Mega_Block_Meta_Tags' );

		if ( $show_share )
		{
			if ( !defined( 'a2a' ))
			{
				echo '<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>';

				define( 'a2a', 1 );
			}

			echo

			'<div class="mega_block_share ' . mega_float( 'right' ) . '"><a class="share a2a_dd" rel="nofollow"><i></i>' . esc_html( $share_label ) . '</a></div>',

			'<script type="text/javascript">',
				'a2a_config.linkname = "' . get_the_title() . '";',
				'a2a_config.linkurl = "' . get_permalink() . '";',
				'a2a.init("page");',
			'</script>';
		}
	}
}