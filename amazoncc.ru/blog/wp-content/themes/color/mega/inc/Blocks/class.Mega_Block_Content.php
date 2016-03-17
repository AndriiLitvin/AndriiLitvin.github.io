<?php

		//add_shortcode( 'video', array( 'Mega_Block_Content', 'getVideoAudioFormat' ));
		//add_shortcode( 'audio', array( 'Mega_Block_Content', 'getVideoAudioFormat' ));
		
class Mega_Block_Content extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Content', 'mega' ), 'description' => __( 'Content block', 'mega' )),
			'before'	=> '<div class="entry">',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );

		$this->hookOnce();
		
		//add_shortcode( 'video', array( $this, 'getVideoAudioFormat' ));
		//add_shortcode( 'audio', array( $this, 'getVideoAudioFormat' ));
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Generate Excerpts', 'mega' ), 'pro' => 1, 'value' => 0, 'name' => 'excerpts', 'desc' => __( 'Excluding single posts & pages', 'mega' )));

			$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'excerpts', 'control_value' => 'true', 'label' => __( 'Excerpt Length (chars)', 'mega' ), 'value' => 500, 'name' => 'excerpt_length' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show comment & ping status', 'mega' ), 'value' => 1, 'name' => 'show_rules', 'desc' => __( 'Show a notice on single posts, whether comments and pings are opened or closed', 'mega' )));
	}

	public function hookOnce()
	{
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ));
	}

	public function enqueue()
	{
		wp_enqueue_script( 'mega.jquery.jplayer.min' );
		wp_enqueue_script( 'mega.jquery.jplayer.init' );
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		switch( get_post_format() )
		{
			case 'quote' :
				$this->getQuoteFormat();
			break;

			case 'status' :
				$this->getStatusFormat();
			break;

			case 'link' :
				$this->getLinkFormat();
			break;

			case 'video' : case 'audio' :
				$obj = hybrid_media_grabber(array( 'split_media' => false, 'type' => get_post_format() ));
				if ( $obj->spit )
					echo $obj->media;
				else
					echo $this->getVideoAudioFormat( $obj->media );

				//$this->getVideoAudioFormat( get_post_format() );
			break;

			default :
				if ( !is_singular() && $excerpts )
					echo mega_clean_words( $excerpt_length, get_the_excerpt() );
				else
					the_content();
		}

		edit_post_link( __( 'Edit', 'mega' ), '<p class="cf">', '</p>' );

		wp_link_pages( array(
			'before'	=> '<p class="link-pages cf">' . __( 'Pages:', 'mega' ),
			'after'		=> '</p>'
		));

		if ( is_single() && $show_rules )
			mega_html( $this->getRule(), '<p class="rules cf">', '</p>' );
	}

	public function getRule()
	{
		if ( post_password_required())
			return __( 'This post is password protected. Enter the password to view any content, comments or pings.', 'mega' );

		elseif ( !comments_open() && pings_open())
			return sprintf( __( 'Responses are currently closed, but you can <a href="%s" rel="trackback">trackback</a> from your own site.', 'mega' ), get_trackback_url());

		elseif ( comments_open() && !pings_open())
			return __( 'You can skip to the end and leave a response. Pinging is currently not allowed.', 'mega' );

		elseif ( !comments_open() && !pings_open())
			return __( 'Both comments and pings are currently closed.', 'mega' );

		return false;
	}

	public function getQuoteFormat()
	{
		$quote	= get_post_meta( get_the_ID(), 'post_quote', true );
		$author	= get_post_meta( get_the_ID(), 'post_quote_author', true );

		echo

		'<blockquote class="format-wrapper quote">',

			'<i></i>',

			$quote ? $quote : __( 'Please enter a quote using the metaboxes', 'mega' ),

		'</blockquote>';//remove -use content

		if ( $author )
			echo '<small>' . $author . '</small>';
	}

	public function getStatusFormat()
	{
		echo '<div class="format-wrapper status"><i></i>';

			the_content();

		echo '</div>';
	}

	public function getLinkFormat()
	{
		echo

		'<div class="format-wrapper link">',
			'<i></i>',
			'<div class="wrap">',
				'<a class="link" href="#">' . get_the_title() . ' &rarr;</a>',

				'<div class="desc">';
					the_content();
				echo '</div>',
			'</div>',
		'</div>';
	}

	public function getVideoAudioFormat( $val = '' )// $atts, $content = '', $name 
	{
		$post_format1 = '';

		if ( !isset( $atts['src'] ))
			$atts['src'] = $val;

		$ext = pathinfo( $atts['src'], PATHINFO_EXTENSION );


$fname = pathinfo( $atts['src'], PATHINFO_FILENAME );
$title		= get_the_title();

if ( isset( $fname ))
$title = $fname;


		switch ( $ext )
		{
			case 'mp3' : case 'ogg' : case 'm4a' :
				$post_format = 'audio';
				$poster		= '';
				$supplied[$ext] = $atts['src'];
			break;

			case 'm4v' : case 'ogv' : case 'webmv' :
				$post_format = 'video';
				$poster		= get_post_meta( get_the_ID(), 'post_video_poster', true );
				$supplied[$ext] = $atts['src'];
			break;
		}

		switch ( $post_format1 )
		{
			case 'audio' :
				//$title		= get_post_meta( get_the_ID(), 'post_audio_title', true );
				$poster		= '';
				//$enclosure	= explode( "\n", get_post_meta( get_the_ID(), 'enclosure', true ));
				$supplied	= array(
					//'mp3' => $enclosure[0],
					'mp3' => get_post_meta( get_the_ID(), 'post_audio_mp3', true ),
					'ogg' => get_post_meta( get_the_ID(), 'post_audio_ogg', true ),
					'm4a' => get_post_meta( get_the_ID(), 'post_audio_m4a', true )
				);
			break;

			case 'video' :
				//$title		= get_post_meta( get_the_ID(), 'post_video_title', true );
				$poster		= get_post_meta( get_the_ID(), 'post_video_poster', true );
				$supplied	= array(
					'm4v'	=> get_post_meta( get_the_ID(), 'post_video_m4v', true ),
					'ogv'	=> get_post_meta( get_the_ID(), 'post_video_ogv', true ),
					'webmv'	=> get_post_meta( get_the_ID(), 'post_video_webmv', true )
				);
			break;
		}

		//$empty	= true;
		$data	= array();

		foreach( $supplied as $ext => $file )
		{
			if ( !empty( $file ))
			{
				$data[] = 'data-' . $ext . '="' . $file . '"';
				//$empty = false;
			}
		}

		if ( get_post_format() !== $post_format )
		{
			return wpautop(get_the_content());	
		}
		//if ( $empty )
		//{
			//the_content();

			//return;
		//}

		//$title = $this->jpTitle( $supplied, $title );
//return ' asdasdasd ';


$poster = !empty( $poster ) ? 'data-poster="' . $poster . '"' : '';


		$r =

		'<div class="' . $post_format . '">'.

			'<div id="jquery_jplayer_' . get_the_ID() . '" class="jp-jplayer" data-title="' . $title . '" ' . $poster . ' data-container="#jp_container_' . get_the_ID() . '" ' . implode( ' ', $data ) . ' data-swf="' . MEGA_DIR_URI . '/assets/js"></div>'.

			'<div id="jp_container_' . get_the_ID() . '" class="jp-' . $post_format . '">'.

				'<div class="jp-type-single">'.

					'<div class="jp-gui' . ( $post_format === 'video' ? ' cf ' : ' ' ) . 'jp-interface">';

					if ( $post_format === 'audio' )
					{
						$r .= $this->jpControls();
						$r .= $this->jpDetails();
						$r .= $this->jpProgress();
						$r .= $this->jpVolume();
						$r .= $this->jpTime();
					}
					else if ( $post_format === 'video' )
					{
						$r .= $this->jpProgress();
						$r .= $this->jpControls();
						$r .= $this->jpVolume();
						$r .= $this->jpTime();
						$r .= $this->jpDetails();
					}

					$r .= 

					'</div>'.

				'</div>'.

			'</div>'.

		'</div>';
		return $r;
	}

	public function jpProgress()
	{
		return

		'<div class="jp-progress">' .
			'<div class="jp-seek-bar">' .
				'<div class="jp-play-bar"></div>' .
			'</div>' .
		'</div>';
	}

	public function jpControls()
	{
		return

		'<ul class="jp-controls">' .
			'<li><a href="javascript:;" class="jp-play" tabindex="1"><i class="icon-play"></i><span>play</span></a></li>' .
			'<li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="icon-pause"></i><span>pause</span></a></li>' .
		'</ul>';
	}

	public function jpVolume()
	{
		return

		'<div class="jp-volume-bar-container">'.
			'<a href="javascript:;" class="jp-mute" tabindex="1"><i class="icon-sound"></i></a>'.
			'<a href="javascript:;" class="jp-unmute" tabindex="1"><i class="icon-mute"></i></a>'.
			'<div class="jp-volume-bar">'.
				'<div class="jp-volume-bar-value"></div>'.
			'</div>'.
		'</div>';
	}

	public function jpTime()
	{
		return

		'<div class="jp-time-holder">'.
			'<div class="jp-current-time"></div>'.
			'<div class="jp-duration"></div>'.
		'</div>';
	}

	public function jpDetails()
	{
		return

		'<div class="jp-details">'.
			'<span class="jp-title"></span>'.
		'</div>';
	}

	public function jpTitle( $supplied, $title )
	{
		if ( empty( $title ))
		{
			foreach( $supplied as $ext => $file )
				if ( !empty( $file ))
					return basename( $file );
		}

		return $title;
	}
}