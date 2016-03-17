<?php

class Mega_Block_Login extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Login', 'mega' ), 'description' => __( 'Login block', 'mega' )),
			'universal'		=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Login', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Text', 'mega' ), 'desc' => __( '<strong>[lost_password]</strong> is the lost password URL.', 'mega' ), 'value' => __( 'If you have an account with us, you can safely login below. <a href="[lost_password]">Forgot your password?</a>', 'mega' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Text Alt', 'mega' ), 'desc' => __( '<strong>[logout]</strong> is the logout URL.', 'mega' ), 'value' => __( 'You are already logged in. <a href="[logout]">Log out?</a>', 'mega' ), 'name' => 'text_alt' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		if ( is_user_logged_in() )
		{
			echo wpautop( preg_replace( '/\[?logout\]?/', esc_url( wp_logout_url( home_url() )), $text_alt ));
		}
		else
		{
			echo wpautop( preg_replace( '/\[?lost_password\]?/', esc_url( wp_lostpassword_url( home_url() )), $text ));

			wp_login_form();
		}
	}
}