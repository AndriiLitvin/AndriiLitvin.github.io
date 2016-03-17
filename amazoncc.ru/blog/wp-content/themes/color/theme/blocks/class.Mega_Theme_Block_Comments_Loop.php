<?php

class Mega_Theme_Block_Comments_Loop extends Mega_Walker
{
	public function __construct()
	{
		parent::__construct( __CLASS__ );

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ));
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Avatar Size (px)', 'color' ), 'value' => 50, 'name' => 'avatar_size' ));
	}

	public function enqueue()
	{
		if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
			wp_enqueue_script( 'comment-reply' );
	}

	public function callback()
	{
		echo '<div id="comments">';
		
		if ( post_password_required() )
		{
			echo '<p>' . __( 'This post is password protected. Enter the password to view any comments.', 'color' ) . '</p></div>';
		
			return;
		}

		if ( have_comments() )
		{
			echo '<div class="heading">';

			echo '<h2>';

			comments_number( __( 'No Comments', 'color' ), __( '1 Comment', 'color' ), __( '% Comments', 'color' ));

			echo '</h2>';

			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) && mega_option( 'paginate_above_comms' ))
				mega_widget( 'Mega_Block_Paginate' );

			echo '</div>';

			echo '<ul class="commentlist">';

			$this->block();

			echo '</ul>';

			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) && mega_option( 'paginate_below_comms' ))
				mega_widget( 'Mega_Block_Paginate' );
		}

		mega_widget( 'Mega_Block_Comments_Form' );

		echo '</div>';
	}

	public function block()
	{
		wp_list_comments( array( 'avatar_size' => $this->mega['settings']['avatar_size'], 'callback' => array( &$this, 'comment' )));
	}

	public function comment( $comment, $args, $depth )
	{
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type )
		{
			case 'pingback' : case 'trackback' ://comment-<?php comment_ID();

				echo '<li class="ping">', sprintf( __( 'Pingback: %s', 'color' ), get_comment_author_link() );
				edit_comment_link( __( '(Edit)', 'color' ), ' ' );

			break;

			default :
				?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
     <?php echo get_avatar( $comment, $args['avatar_size'], 'http://i.imgur.com/rysNZj0.png', $comment->comment_author );//MEGA_THEME_IMG_DIR_URI . '/icons/user.png ?>
     <div class="left" style="width: calc( 100% - 25px - 30px - <?php echo $depth * 25 .'px - ' . $args['avatar_size'] ?>px );">
     <div class="author"><?php comment_author(); ?></div>
     <div class="date"><?php comment_date( 'j/n/Y' ); ?></div>
     <?php comment_reply_link( wp_parse_args( $args, array( 'depth' => $depth ))); ?>
     <div id="comment-<?php comment_ID(); ?>" class="text"><?php comment_text(); ?></div>
     <div class="links"><?php
	 	if ( $comment->comment_approved == '0' )
			echo '<em>' . __( 'Your comment is awaiting moderation.', 'color' ) . '</em>';

		edit_comment_link( __( 'Edit', 'color' )); ?></div></div><?php

			break;
		}
	}
}