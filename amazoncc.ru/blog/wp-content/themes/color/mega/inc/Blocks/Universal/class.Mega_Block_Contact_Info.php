<?php

class Mega_Block_Contact_Info extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Contact Info', 'mega' ), 'description' => __( 'Contact Info Block', 'mega' )),
			'universal'		=> true,
			'pro'			=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => _x( 'Contact', 'Contact Info', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_WP_Editor', array( 'label' => __( 'Text', 'mega' ), 'value' => __( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'mega' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_Checklist', array( 'label' => __( 'Info Type', 'mega' ), 'value' => array( 'address' => 1, 'phone' => 1, 'email' => 1 ), 'name' => 'types',
			'choices' => array(
				'address'	=> __( 'Address', 'mega' ),
				'phone'		=> __( 'Phone', 'mega' ),
				'email'		=> __( 'Email', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Address Label', 'mega' ), 'pro' => 1, 'value' => __( 'Address:', 'mega' ), 'name' => 'address' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Address', 'mega' ), 'value' => __( '1535 Broadway, New York', 'mega' ), 'name' => 'address_value' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Phone Label', 'mega' ), 'pro' => 1, 'value' => __( 'Phone:', 'mega' ), 'name' => 'phone' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Phone', 'mega' ), 'value' => __( '1-888-456-7890', 'mega' ), 'name' => 'phone_value' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Email Label', 'mega' ), 'pro' => 1, 'value' => __( 'Email:', 'mega' ), 'name' => 'email' ));
		$form->add_control( 'Mega_Control_Email', array( 'label' => __( 'Email', 'mega' ), 'value' => 'support@example.com', 'name' => 'email_value' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		$email_value = '<a href="mailto:' . $email_value . '">' . esc_html( $email_value ) . '</a>';

		echo wpautop( $text );

		echo '<ul>';

		foreach( $types as $type => $status )
		{
			if ( $status )
				echo '<li class="' . esc_attr( $type ) . '"><i></i>' . mega_html( esc_html( $$type ), '<span>', '</span> ', 0 ) . ${$type . '_value'} . '</li>';
		}

		echo '</ul>';
	}
}