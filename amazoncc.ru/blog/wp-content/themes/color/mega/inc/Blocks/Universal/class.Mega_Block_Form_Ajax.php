<?php

class Mega_Block_Form_Ajax extends Mega_Walker
{
	public function __construct( $id, $args )
	{
		add_action( 'wp_ajax_mega_' . strtolower( $id ), array( &$this, 'ajaxCallback' ));
		add_action( 'wp_ajax_nopriv_mega_' . strtolower( $id ), array( &$this, 'ajaxCallback' ));

		parent::__construct( $id, $args );
	}

	public function callback()
	{
		extract( $this->mega['settings'] );

		echo $this->before();

		$this->getTitle();

		echo

		wpautop( $text ),

		'<form class="contactform ajax wide" action="/">';

			$this->block();

			echo

			'<ul class="ajaxresponse"></ul>',
			'<input type="hidden" name="action" value="mega_' . $this->mega['args']['id_base_low'] . '" />',
			'<input type="hidden" name="ins" value="' . $this->number . '" />',
			wp_nonce_field( 'contact_data', 'security', true, false ),

		'</form>';

		echo $this->after();
	}

	public function ajaxCallback()
	{
		check_ajax_referer( 'contact_data', 'security' );

		$post = stripslashes_deep( $_POST );//wp_unslash

		$this->parseWidgetSettings( $post['ins'] );

		unset( $post['security'], $post['action'], $post['ins'], $post['_wp_http_referer'] );

		$mega_error = new Mega_Error();

		foreach( $post as $po => $poval )
		{
			call_user_func( $this->megaForm['validate'][$po]['callback'], $poval, $mega_error );

			$post[$po] = call_user_func( $this->megaForm['sanitize'][$po]['callback'], $poval );
		}

		$this->validate( $post, $mega_error );

		if ( !$mega_error->errors )
		{
			//echo json_encode( $mega_error->errors );

			$this->ajax( $post );
		}
		else
		{
			foreach( $mega_error->errors as $j => $dat )
			{
				echo '<li>' . ucwords( $dat['type'] ) . ': ' . $dat['log'] . '</li>';
			}

			die();
		}

		exit;
	}

	public function validate( $post, $mega_error ) {}

	public function setForm( $args )
	{
		if ( !empty( $args['name'] ))
		{
			$this->megaForm['defaults'][$args['name']] = $args['value'];

			$this->megaForm['sanitize'][$args['name']]['callback'] = $args['sanitize'];

			$this->megaForm['validate'][$args['name']]['callback'] = $args['validate'];
		}
	}
}