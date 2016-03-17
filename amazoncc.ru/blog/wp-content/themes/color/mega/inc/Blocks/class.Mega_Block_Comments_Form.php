<?php

class Mega_Block_Comments_Form extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile' => array( 'name' => __( 'Comments Form', 'mega' ), 'description' => __( 'Comments Form block', 'mega' ))
		);

		parent::__construct( __CLASS__, $args );

		$this->hookCallback();
	}

	public function hookOnce()
	{
		add_action( 'comment_form_comments_closed', array( &$this, 'comments_closed' ));
	}

	public function comments_closed()
	{
		if ( !is_page() )
			echo '<p>' . __( 'Comments are closed.', 'mega' ) . '</p>';
	}

	public function block()
	{
		if ( !isset( $req ))
			$req = false;

		$fields = array(
			'author'	=> '<p><input type="text" name="author" value="" placeholder="' . __( 'Name', 'mega' ) . ( $req ? ' *' : '' ) . '" tabindex="1" /></p>',
			'email'		=> '<p><input type="text" name="email" value="" placeholder="' . __( 'Email Address', 'mega' ) . ( $req ? ' *' : '' ) . '" tabindex="2" /></p>',
			'url'		=> '<p><input type="text" name="url" value="" placeholder="' . __( 'Website URL', 'mega' ) . '" tabindex="3" /></p>'
		);
		comment_form( array(
			'fields'				=> apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'			=> '<p><textarea id="comment" name="comment" placeholder="' . __( 'Type your comment...', 'mega' ) . '" tabindex="4"></textarea></p>',
			'comment_notes_after'	=> '',
			'cancel_reply_link'		=> __( '/ Cancel', 'mega' ),
			'label_submit'			=> __( 'Submit', 'mega' )
		));
	}
}