<?php

class Mega_Block_Posts extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Posts', 'mega' ), 'description' => __( 'Recent, popular &amp; random posts block', 'mega' )),
			'universal'	=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Blog Posts', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Order By', 'mega' ), 'pro' => 1, 'value' => 'date', 'name' => 'order',
			'choices' => array(
				'date'			=> __( 'Date', 'mega' ),
				'rand'			=> __( 'Random', 'mega' ),
				'comment_count'	=> __( 'Comment Count', 'mega' )
			)
		));
		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Number of Results', 'mega' ), 'pro' => 1, 'value' => 3, 'name' => 'count' ));
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

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Layout', 'mega' ), 'desc' => __( 'Use [title], [excerpt] and [meta] snippets to format the layout order.<br/><br/>Title - <strong>[title]</strong><br/>Excerpt - <strong>[excerpt]</strong><br/>Meta - <strong>[meta]</strong>', 'mega' ), 'pro' => 1, 'value' => '[title][meta]', 'name' => 'layout' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Excerpt length', 'mega' ), 'value' => 40, 'name' => 'length' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Meta', 'mega' ), 'desc' => __( 'Use [date], [comments] and [author] snippets to format the meta order.<br/><br/>Date - <strong>[date]</strong><br/>Comments - <strong>[comments]</strong><br/>Author - <strong>[author]</strong>', 'mega' ), 'pro' => 1, 'value' => '[comments][date]', 'name' => 'meta' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Date Format', 'mega' ), 'value' => __( 'F jS, Y', 'mega' ), 'name' => 'date' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		$query = new WP_Query( array(
			'post_type'				=> 'post',
			'orderby'				=> $order,
			'ignore_sticky_posts'	=> 1,
			'posts_per_page'		=> $count,
			'cat'					=> $cat
		));

		echo '<ul>';

		while ( $query->have_posts() ) : $query->the_post();

		$this->post();

		endwhile; wp_reset_postdata();

		echo '</ul>';
	}

	public function post()
	{
		extract( $this->mega['settings'] );

		echo '<li>';
//print_r($sources);
		if ( $image )
			mega_thumb( array( 'width' => $width, 'height' => $height, 'sources' => $sources ));

		echo mega_parse_message( array(
			'title' =>	sprintf(
							'<a class="title" href="%1$s" title="%2$s">%3$s...</a>',
							esc_url( get_permalink() ),
							esc_attr( sprintf( __( 'Permalink to %s', 'mega' ), get_the_title() )),
							esc_html( substr( get_the_title(), 0, 40 ))
						),
			'excerpt' => '<div class="excerpt">' . esc_html( substr( get_the_excerpt(), 0, $length )) . ' ...</div>',
			'meta' =>	mega_parse_message( array(
							'date'		=> $this->getMeta( 'date', $this->mega ),
							'comments'	=> $this->getMeta( 'comments', $this->mega ),
							'author'	=> $this->getMeta( 'author', $this->mega )
						), '<div class="meta">' . $meta . '</div>' )
		), $layout );

		echo '</li>';
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