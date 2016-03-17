<?php

class Mega_Block_Posts_Ajax extends Mega_Walker
{
	public function __construct( $id, $args )
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Posts Ajax', 'mega' ), 'description' => __( 'Recent, popular &amp; random posts block', 'mega' )),
			'universal'	=> true
		);

		add_action( 'wp_ajax_nopriv_timeline_ajax', array( $this, 'ajaxRequest' ));
		add_action( 'wp_ajax_timeline_ajax', array( $this, 'ajaxRequest' ));

		parent::__construct( $id, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Order By', 'mega' ), 'value' => 'date', 'name' => 'order',
			'choices' => array(
				'date'			=> __( 'Date', 'mega' ),
				'rand'			=> __( 'Random', 'mega' ),
				'comment_count'	=> __( 'Comment Count', 'mega' )
			)
		));
		//$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Number of Results', 'mega' ), 'value' => 3, 'name' => 'count' ));
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Select a Category', 'mega' ), 'name' => 'cat', 'use_list' => 1, 'list' => 'mega_cat_list' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Image', 'mega' ), 'value' => 1, 'name' => 'image' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image Width (px)', 'mega' ), 'value' => 28, 'name' => 'width' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image Height (px)', 'mega' ), 'value' => 28, 'name' => 'height' ));

		$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image Sources', 'mega' ), 'value' => array( 'featured' => 1, 'first' => 1, 'ph' => 1 ), 'name' => 'sources',
			'choices' => array(
				'featured'	=> __( 'Featured', 'mega' ),
				'first'		=> __( 'First', 'mega' ),
				'ph'		=> __( 'Placeholder', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Layout', 'mega' ), 'desc' => __( 'Use [title], [excerpt] and [meta] snippets to format the layout order.<br/><br/>Title - <strong>[title]</strong><br/>Excerpt - <strong>[excerpt]</strong><br/>Meta - <strong>[meta]</strong>', 'mega' ), 'value' => '[title][excerpt]', 'name' => 'layout' ));
		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Excerpt length', 'mega' ), 'value' => 40, 'name' => 'length' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Meta', 'mega' ), 'desc' => __( 'Use [date], [comments] and [author] snippets to format the meta order.<br/><br/>Date - <strong>[date]</strong><br/>Comments - <strong>[comments]</strong><br/>Author - <strong>[author]</strong>', 'mega' ), 'value' => '[comments][date]', 'name' => 'meta' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Date Format', 'mega' ), 'value' => __( 'F jS, Y', 'mega' ), 'name' => 'date' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		$query = new WP_Query( array(
			'post_type'				=> 'post',
			'orderby'				=> $order,
			//'ignore_sticky_posts'	=> 1,
			//'posts_per_page'		=> $count,
			'cat'					=> $cat,
			'paged'					=> $page
		));

		echo '<ul class="cf">';

		while ( $query->have_posts() ) : $query->the_post();

		$this->post();

		endwhile;

		echo '</ul>';

		echo '<a data-nounce="' . wp_create_nonce( 'security' ) . '" data-page="' . ( $page + 1 ) . '" data-instance="' . $this->number . '" class="button more center' . ( $query->max_num_pages > 1 ? '' : ' disabled' ) . '">' . __( 'Load more', 'mega' ) . '</a>';

		wp_reset_postdata();
	}

	public function post()
	{
		extract( $this->mega['settings'] );

		echo '<li>';

		echo '<i></i>';

		if ( $image )
			mega_thumb( array( 'width' => $width, 'height' => $height, 'sources' => $sources ));

		echo '<div class="data">';

		echo mega_parse_message( array(
			'title' =>	sprintf(
							'<a class="title" href="%1$s" title="%2$s">%3$s</a>',
							esc_url( get_permalink() ),
							esc_attr( sprintf( __( 'Permalink to %s', 'mega' ), get_the_title() )),
							esc_html( substr( get_the_title(), 0, 50 ))
						),
			'excerpt' => '<div class="excerpt">' . esc_html( substr( get_the_excerpt(), 0, $length )) . '</div>',
			'meta' =>	mega_parse_message( array(
							'date'		=> $this->getMeta( 'date', $this->mega ),
							'comments'	=> $this->getMeta( 'comments', $this->mega ),
							'author'	=> $this->getMeta( 'author', $this->mega )
						), '<div class="meta">' . $meta . '</div>' )
		), $layout );

		echo '</div>';

		echo '</li>';
	}

	public function ajaxRequest()
	{
		check_ajax_referer( 'security', 'nounce' );

		$post = wp_unslash( $_POST );

		$this->parseWidgetSettings( $post['instance'] );

		extract( $this->mega['settings'] );

		$args = array(
			'post_type'		=> 'post',
			'orderby'		=> $order,
			'cat'			=> $cat,
			'paged'			=> $post['page']
		);

		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();

		$this->post();

		endwhile;

		wp_reset_postdata();

		exit;
	}

	public function getMeta( $item, $instance )
	{
		return mega_html( esc_html( $this->getWrap( $item, $instance )), '<span class="' . $item . '">', '</span>', false );
	}

	public function getWrap( $item, $instance )
	{
		extract( $instance['settings'] );

		switch( $item )
		{
			case 'date' :
				return get_the_date( $date );

			case 'comments' :
				return !post_password_required() ? sprintf( __( '%s Comments', 'mega' ), get_comments_number() ) : '';

			case 'author' :
				return sprintf( __( 'By %s', 'mega' ), get_the_author() );
		}
	}
}