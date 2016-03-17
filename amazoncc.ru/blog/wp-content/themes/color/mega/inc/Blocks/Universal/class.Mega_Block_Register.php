<?php

class Mega_Block_Register extends Mega_Block_Form_Ajax
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Register', 'mega' ), 'description' => __( 'Register block', 'mega' )),
			'universal'	=> true
		);

		parent::__construct( __CLASS__, $args );

		$this->buildRegisterForm( new Mega_Form_Manager( array( 'type' => 'mega', 'callback' => array( $this, 'setForm' ))));
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Registration', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Text', 'mega' ), 'pro' => 1, 'value' => __( 'If you don\'t have an account yet, you can register below.', 'mega' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Text Alt', 'mega' ), 'value' => __( 'Registration is currently closed.', 'mega' ), 'name' => 'text_alt' ));

		$form->add_control( 'Mega_Control_Email', array( 'label' => __( 'Email From Address', 'mega' ), 'pro' => 1, 'value' => get_option( 'admin_email' ), 'name' => 'email' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Email From Name', 'mega' ), 'value' => get_bloginfo( 'name' ), 'name' => 'name' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Email Subject', 'mega' ), 'pro' => 1, 'desc' => __( 'Use the following snippets of code to output the necessary information:<br/><br/>Site name - <strong>[site_name]</strong><br/>Site URL - <strong>[site_url]</strong><br/>', 'mega' ), 'value' => __( 'Your password for [site_name] at [site_url]', 'mega' ), 'name' => 'subject' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Email Message', 'mega' ), 'desc' => __( 'Use the name attributes you have given to elements in your form to output the results inside your email, names must be surrounded with [], i.e [my-email-field], in addition you have few custom names that you can use: [site_name], [site_url] and [user_pass]', 'mega' ), 'value' => str_replace( '\n', "\n", __( 'Thank you for registering with [site_name], you can find your login information below.\n\nUsername: [user_name]\nPassword: [user_pass]', 'mega' )), 'name' => 'message' ));
	}

	public function callback()
	{
		if ( get_option( 'users_can_register' ))
			parent::callback();
		else
			echo wpautop( $this->mega['settings']['text_alt'] );
	}

	public function block()
	{
		$this->buildRegisterForm( new Mega_Form_Manager( array( 'type' => 'echo', 'callback' => array( $this ))));
	}

	public function buildRegisterForm( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Username', 'mega' ), 'show_label' => 0, 'name' => 'user_name', 'placeholder' => __( 'enter your username', 'mega' ), 'required' => 1, 'sanitize' => 'sanitize_user' ));

		$form->add_control( 'Mega_Control_Email', array( 'label' => __( 'Email', 'mega' ), 'show_label' => 0, 'name' => 'user_email', 'placeholder' => __( 'enter your email', 'mega' ), 'required' => 1 ));

		$form->add_control( 'Mega_Control_Submit', array( 'value' => __( 'Submit', 'mega' )));
	}

	public function ajax( $post )
	{
		if ( wp_create_user( $post['user_name'], ( $post['user_pass'] = wp_generate_password() ), $post['user_email'] ))
		{
			global $mega_mail;

			extract( $this->mega['settings'] );

			$post['site_name']	= get_bloginfo( 'name' );
			$post['site_url']	= site_url();

			if ( $mega_mail->do_mail(
				$post['user_email'],
				mega_parse_message( array( 'site_name' => get_bloginfo( 'name' ), 'site_url' => site_url() ), $subject ),
				mega_parse_message( $post, $message ),
				$email,
				$name
			))
				echo '<li>' . __( 'Success! Check your email for the password.', 'mega' ) . '</li>';
			else
				echo '<li>' . __( 'Sorry but there was a problem sending your login credentials to your email address.', 'mega' ) . '</li>';
		}
		else
			echo '<li>' . __( 'Ajax Error!', 'mega' ) . '</li>';
	}

	public function validate( $post, $mega_response )
	{
		if ( !validate_username( $post['user_name'] ))
		{
			$mega_response->add_error( $id, __( 'Username is invalid.', 'mega' ));
		}
		elseif ( username_exists( $post['user_name'] ))
		{
			$mega_response->add_error( $id, __( 'Username already exists.', 'mega' ));
		}

		if ( is_email( $post['user_email'] ) && email_exists( $post['user_email'] ))
			$mega_response->add_error( $id, __( 'Email address already exists.', 'mega' ));
	}
}