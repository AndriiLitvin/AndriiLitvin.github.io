<?php

class Mega_Block_Parent_Posts_Loop extends Mega_Parent_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Posts Loop', 'mega' ), 'description' => __( 'Posts Loop Block', 'mega' )),
			'before'		=> '<article id="%1$s" class="%2$s %3$s">',
			'after'			=> '</article>',
			//'templates'	=> array( 'singular' ),//all templates, even front-page
			'whitelist'		=> array( 'Mega_Block_Post_Ads', 'Mega_Block_Single_Nav', 'Mega_Block_Parent_Post' )//'title', 'entry', 'toolbar',
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Pull Posts From Categories', 'mega' ), 'value' => 0, 'name' => 'cat', 'use_list' => 1, 'list' => 'mega_cat_list' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Offset Posts', 'mega' ), 'desc' => __( "Enter a number to hide your newest posts, if you'll enter 2 in here, your 2 newest posts won't be shown.", 'mega' ), 'value' => 0, 'name' => 'offset', 'min' => 0 ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'No Posts Title', 'mega' ), 'value' => __( 'No Posts Matched', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'No Posts Message', 'mega' ), 'value' => __( "No posts were found during this query, Try using the search form below.\n\nSorry for the inconvenience.", 'mega' ), 'name' => 'text' ));
	}

	public function hookOnce()
	{
		//add_action( 'pre_get_posts', array( &$this, 'action' ));
	}

	public function action( $query )
	{
		extract( $this->mega['settings'] );

		if ( $query->is_home() && $query->is_main_query() )
		{
			$query->set( 'cat', implode( ',', $cat ));
			$query->set( 'offset', $offset );
		}
	}

	public function before()
	{
		$this->mega['args']['id'] = 'post-' . get_the_ID();
		$this->mega['args']['id_base'] = join( ' ', get_post_class() );

		return parent::before();
	}

	public function callback()
	{
		if ( have_posts() ) : while ( have_posts() ) : the_post();

		parent::callback();

		endwhile; else :

		Mega_Block_404::callback();

		endif;
	}
}