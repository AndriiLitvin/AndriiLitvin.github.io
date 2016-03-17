<?php

class Mega_Block_Newsletter extends Mega_Block_Form_Ajax
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Newsletter', 'mega' ), 'description' => __( 'Newsletter block', 'mega' )),
			'universal'		=> true
		);

		parent::__construct( __CLASS__, $args );

		$this->buildNewsletterForm( new Mega_Form_Manager( array( 'type' => 'mega', 'callback' => array( $this, 'setForm' ))));

		add_filter( 'mega_form_select_lists', array( $this, 'addList' ));
		add_filter( 'mega_mc_list', array( $this, 'doList' ));
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Newsletter', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Text', 'mega' ), 'value' => __( 'Get in first on the latest news and updates by subscribing to our weekly newsletter!', 'mega' ), 'name' => 'text' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'MailChimp API Key', 'mega' ), 'value' => '', 'name' => 'mc_api_key' ));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'MailChimp List', 'mega' ), 'desc' => __( 'Please first fill in the API key above, save, and then refresh the page to see the available lists.', 'mega' ), 'value' => '', 'name' => 'mc_list', 'use_list' => 1, 'list' => 'mega_mc_list' ));
	}

	public function block()
	{
		$this->buildNewsletterForm( new Mega_Form_Manager( array( 'type' => 'echo', 'callback' => array( $this ))));
	}

	public function buildNewsletterForm( $form )
	{
		$form->add_control( 'Mega_Control_Email', array( 'label' => __( 'Email', 'mega' ), 'show_label' => 0, 'name' => 'email', 'placeholder' => __( 'enter your email', 'mega' ), 'required' => 1 ));

		$form->add_control( 'Mega_Control_Submit', array( 'value' => __( 'Submit', 'mega' )));
	}

	public function addList( $lists )
	{
		$lists['mega_mc_list'] = __( 'MailChimp List', 'mega' );

		return $lists;
	}

	public function doList()
	{
		$args = array();

		if ( isset( $this->mega['settings']['mc_api_key'] ))
		{
			$data = $this->call( 'lists', array( 'sort_field' => '' ));

			if ( isset( $data->data ))
				foreach ( $data->data as $list_obj )
					$args[$list_obj->id] = $list_obj->name . ' (' . $list_obj->stats->cleaned_count . ')';
		}

		return $args;
	}

	public function ajax( $post )
	{
		extract( $post );

		if ( $r = $this->call( 'listSubscribe', array( 'id' => $this->mega['settings']['mc_list'], 'email_address' => $email ))->error )
			echo '<li>' . sprintf( __( 'Error: %s', 'mega' ), $r->error ) . '</li>';
		else
			echo '<li>' . __( 'Subscribed - look for the confirmation email!', 'mega' ) . '</li>';

		exit;
	}

	public function call( $method, $args = array() )
	{
		$dc = 'us1';

		if ( strstr( $this->mega['settings']['mc_api_key'], '-' ))
			$key = explode( '-', $this->mega['settings']['mc_api_key'], 2 );

		if ( isset( $key[1] ))
			$dc = $key[1];

		$args['apikey'] = $this->mega['settings']['mc_api_key'];
		$args['method'] = $method;

		$response = wp_remote_retrieve_body( wp_remote_post( add_query_arg( $args, 'http://' . $dc . '.api.mailchimp.com/1.3/?output=json' )));

		return json_decode( $response );
	}
}