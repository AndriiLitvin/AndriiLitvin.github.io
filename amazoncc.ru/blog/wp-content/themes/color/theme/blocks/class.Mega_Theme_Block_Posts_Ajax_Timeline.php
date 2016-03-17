<?php

class Mega_Theme_Block_Posts_Ajax_Timeline extends Mega_Block_Posts_Ajax
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Timeline Posts Ajax', 'color' ), 'description' => __( 'Recent, popular &amp; random posts block', 'color' )),
			'universal'	=> true
		);

		//add_action( 'wp_ajax_nopriv_timeline_ajax', array( $this, 'ajaxRequest' ) );
		//add_action( 'wp_ajax_timeline_ajax', array( $this, 'ajaxRequest' ) );

		parent::__construct( __CLASS__, $args );
	}

	public function hookOnce()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ));
	}

	public function enqueue()
	{
		wp_enqueue_script( 'mega.jquery.posts.timeline' );
	}

	public function post()
	{
		extract( $this->mega['settings'] );

		echo '<li class="hidden">';

		echo '<i></i>';

		echo '<div class="data">';

		echo mega_parse_message( array(
			'title' =>	sprintf(
							'<a class="title" href="%1$s" title="%2$s">%3$s</a>',
							esc_url( get_permalink() ),
							esc_attr( sprintf( __( 'Permalink to %s', 'mega' ), get_the_title() )),
							esc_html( substr( get_the_title(), 0, 50 ))
						),
			'excerpt' => '<div class="excerpt">' . substr( get_the_excerpt(), 0, $length ) . '</div>',
			'meta' =>	mega_parse_message( array(
							'date'		=> $this->getMeta( 'date', $this->mega ),
							'comments'	=> $this->getMeta( 'comments', $this->mega ),
							'author'	=> $this->getMeta( 'author', $this->mega )
						), '<div class="meta">' . $meta . '</div>' )
		), $layout );

		if ( $image )
			mega_thumb( array( 'width' => $width, 'height' => $height, 'sources' => $sources ));

		echo '</div>';

		echo '<div class="data-author">';

		echo get_avatar( get_the_author_meta( 'ID' ), 65 );

		echo '</div>';

		echo '</li>';
	}
}