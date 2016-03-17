<?php

class Mega_Block_Comments extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Recent Comments', 'mega' ), 'description' => __( 'Recent Comments Block', 'mega' )),
			'universal'	=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Recent Comments', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Number of comments', 'mega' ), 'pro' => 1, 'value' => 3, 'name' => 'count' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Avatar', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'avatar' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'avatar', 'control_value' => 'true', 'label' => __( 'Avatar Size (px)', 'mega' ), 'value' => 28, 'name' => 'avatar_size' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Layout', 'mega' ), 'desc' => __( 'Use [title], [excerpt] and [meta] snippets to format the layout order.<br/><br/>Title - <strong>[title]</strong><br/>Excerpt - <strong>[excerpt]</strong><br/>Meta - <strong>[meta]</strong>', 'mega' ), 'pro' => 1, 'value' => '[title][excerpt][meta]', 'name' => 'layout' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Top', 'mega' ), 'desc' => __( 'Use [author] and [title] snippets to format the title.<br/><br/>Post author - <strong>[author]</strong><br/>Post title - <strong>[title]</strong>', 'mega' ), 'value' => __( '[author] on [title]', 'mega' ), 'name' => 'top' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Excerpt length', 'mega' ), 'value' => 40, 'name' => 'length' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Meta', 'mega' ), 'desc' => __( 'Use [date], [days] and [author] snippets to format the meta order.<br/><br/>Date - <strong>[date]</strong><br/>Days ago - <strong>[days]</strong><br/>Comment author - <strong>[author]</strong>', 'mega' ), 'pro' => 1, 'value' => '[days][author]', 'name' => 'meta' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		echo '<ul>';

		$query = get_comments( array( 'type' => 'comment', 'status' => 'approve', 'number' => $count ));

		foreach( $query as $comm ) :

			echo

			'<li>',
				$avatar ? get_avatar( $comm, $avatar_size, '', $comm->comment_author ) : '',

				mega_parse_message( array(
					'title' =>	sprintf(
									'<a class="title" href="%1$s#comment-%2$s" title="%3$s">%3$s</a>',
									esc_url( get_permalink( $comm->comment_post_ID )),
									$comm->comment_ID,
									esc_html( mega_parse_message( array( 'author' => $comm->comment_author, 'title' => get_the_title( $comm->comment_post_ID )), $top ))
								),
					'excerpt' => ( '<div class="excerpt">' . substr( get_comment_excerpt( $comm->comment_ID ), 0, $length ) . ' ...</div>' ),
					//use words and 3 dots /create function ?
					'meta' =>	mega_parse_message( array(
									'date'		=> $this->getMeta( 'date', $comm ),
									'days'		=> $this->getMeta( 'days', $comm ),
									'author'	=> $this->getMeta( 'author', $comm )
								), '<div class="meta">' . $meta . '</div>' )
				), $layout ),
			'</li>';

		endforeach;

		echo '</ul>';
	}

	public function getMeta( $item, $comm )
	{
		return mega_html( esc_html( $this->getWrap( $item, $comm )), '<span class="' . esc_attr( $item ) . '">', '</span>', false );
	}

	public function getWrap( $item, $comm )
	{
		switch( $item )
		{
			case 'author' :
				return sprintf( __( 'By %s', 'mega' ),  $comm->comment_author );

			case 'date' :
				return get_the_date();

			case 'days' :
				return sprintf( __( '%s ago', 'mega' ), human_time_diff( get_comment_date( 'U', $comm->comment_ID ), current_time( 'timestamp' )));
		}
	}
}