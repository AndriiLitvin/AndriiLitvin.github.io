<?php

class Mega_Block_Contact extends Mega_Block_Form_Ajax
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Contact', 'mega' ), 'description' => __( 'Contact block', 'mega' )),
			'universal'		=> true
		);

		parent::__construct( __CLASS__, $args );

		$this->buildContactForm( new Mega_Form_Manager( array( 'type' => 'mega', 'callback' => array( $this, 'setForm' ))));
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Contact our team', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Email', array( 'label' => __( 'Email', 'mega' ), 'value' => get_option( 'admin_email' ), 'name' => 'email' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Text', 'mega' ), 'value' => __( 'Get in touch with our 24/7 support team regarding any issues you may have.', 'mega' ), 'name' => 'text', 'pro' => 1 ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Message', 'mega' ), 'desc' => __( 'Use the name attributes you have given to elements in your form to output the results inside your email, names must be surrounded with [], i.e [my-email-field]', 'mega' ), 'value' => str_replace( '\n', "\n", __( 'Name: [name]\nEmail: [email]\nSubject: [subject]\nMessage: [message]', 'mega' )), 'name' => 'message', 'pro' => 1 ));
	}

	public function block()
	{
		$this->buildContactForm( new Mega_Form_Manager( array( 'type' => 'echo', 'callback' => array( $this ))));
	}

	public function buildContactForm( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Name', 'mega' ), 'show_label' => 0, 'name' => 'name', 'placeholder' => __( 'enter your name', 'mega' ), 'required' => 1, 'sanitize' => 'wp_filter_nohtml_kses' ));

		$form->add_control( 'Mega_Control_Email', array( 'label' => __( 'Email', 'mega' ), 'show_label' => 0, 'name' => 'email', 'placeholder' => __( 'enter your email', 'mega' ), 'required' => 1 ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Subject', 'mega' ), 'show_label' => 0, 'name' => 'subject', 'placeholder' => __( 'enter your subject', 'mega' ), 'required' => 1, 'sanitize' => 'wp_filter_nohtml_kses' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Message', 'mega' ), 'show_label' => 0, 'name' => 'message', 'placeholder' => __( 'enter your message', 'mega' ), 'required' => 1, 'sanitize' => 'wp_filter_nohtml_kses' ));

		$form->add_control( 'Mega_Control_Submit', array( 'value' => __( 'Submit', 'mega' )));
	}

	public function ajax( $post )
	{
		global $mega_mail;

		extract( $post );

		$instance = $this->mega['settings'];

		if ( $mega_mail->do_mail(
			$instance['email'],
			$subject,
			mega_parse_message( $post, $instance['message'] ),
			$email,
			$name
		))
			echo '<li>' . __( 'Success! The administrator will contact you as soon as possible.', 'mega' ) . '</li>';
		else
			echo '<li>' . __( 'Ajax Error!', 'mega' ) . '</li>';
	}
}