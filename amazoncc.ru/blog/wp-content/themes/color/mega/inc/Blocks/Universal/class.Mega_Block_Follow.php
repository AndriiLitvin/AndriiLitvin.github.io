<?php

class Mega_Block_Follow extends Mega_Walker//Social
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Follow Us', 'mega' ), 'description' => __( 'Follow Us block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s %3$s" %4$s>',
			'after'		=> '</div>',
			'universal'	=> true
		);

		$this->bookmarks = array(
			'facebook'		=> array( 'name' => __( 'Facebook', 'mega' ), 'link' => 'http://www.facebook.com/%s' ),
			'twitter'		=> array( 'name' => __( 'Twitter', 'mega' ), 'link' => 'http://twitter.com/%s' ),
			'plus'			=> array( 'name' => __( 'Google Plus', 'mega' ), 'link' => 'http://plus.google.com/%s' ),
			'youtube'		=> array( 'name' => __( 'YouTube', 'mega' ), 'link' => 'https://www.youtube.com/channel/%s' ),
			'linkedin'		=> array( 'name' => __( 'Linkedin', 'mega' ), 'link' => 'http://www.linkedin.com/pub/%s' ),
			'feedburner'	=> array( 'name' => __( 'Feedburner', 'mega' ), 'link' => 'http://feeds.feedburner.com/%s' ),
			'wordpress'		=> array( 'name' => __( 'WordPress', 'mega' ), 'link' => 'http://%s.wordpress.com/' ),
			'dribbble'		=> array( 'name' => __( 'Dribbble', 'mega' ), 'link' => 'http://dribbble.com/%s' ),
			'flickr'		=> array( 'name' => __( 'Flickr', 'mega' ), 'link' => 'http://www.flickr.com/photos/%s' ),
			'digg'			=> array( 'name' => __( 'Digg', 'mega' ), 'link' => 'http://digg.com/%s' ),
			'spotify'		=> array( 'name' => __( 'Spotify', 'mega' ), 'link' => 'http://community.spotify.com/t5/user/viewprofilepage/user-id/%s' ),
			'tumblr'		=> array( 'name' => __( 'Tumblr', 'mega' ), 'link' => 'http://%s.tumblr.com/' ),
			'rss'			=> array( 'name' => __( 'RSS', 'mega' ), 'link' => '%s' )
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Follow Us', 'mega' ), 'name' => 'title' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Facebook', 'mega' ), 'value' => ' ', 'name' => 'facebook' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Twitter', 'mega' ), 'value' => ' ', 'name' => 'twitter' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Google Plus', 'mega' ), 'value' => ' ', 'name' => 'plus' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'YouTube', 'mega' ), 'value' => ' ', 'name' => 'youtube' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'LinkedIn', 'mega' ), 'value' => '', 'name' => 'linkedin' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'FeedBurner', 'mega' ), 'value' => '', 'name' => 'feedburner' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Digg', 'mega' ), 'value' => '', 'name' => 'digg' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Dribbble', 'mega' ), 'pro' => 1, 'value' => '', 'name' => 'dribbble' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Flickr', 'mega' ), 'pro' => 1, 'value' => '', 'name' => 'flickr' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'WordPress', 'mega' ), 'value' => '', 'name' => 'wordpress' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Spotify', 'mega' ), 'value' => '', 'name' => 'spotify' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Tumblr', 'mega' ), 'value' => '', 'name' => 'tumblr' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'RSS URL', 'mega' ), 'value' => get_bloginfo( 'rss2_url' ), 'name' => 'rss' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		echo '<ul>';

		foreach ( $this->bookmarks as $key => $args )
		{
			if ( !empty( $$key ))
				printf(
					'<li class="%1$s"><a rel="nofollow"%2$stitle="%3$s" target="_blank"><i class="icon"></i><span class="name">%3$s</span></a></li>',
					$key,
					$$key === ' ' ? '' : ' href="' . esc_url( sprintf( $args['link'], $$key )) . '" ',
					$args['name']
				);
		}

		echo '</ul>';
	}
}

class Mega_Block_Follow_Counter extends Mega_Walker
{
	public $bookmarks;

	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Follow Us Counter', 'mega' ), 'description' => __( 'Follow Us Counter block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s %3$s" %4$s>',
			'after'		=> '</div>',
			'universal'	=> true,
			'pro'		=> true
		);

		$this->bookmarks = array(
			'facebook' => array(
				'name'	=> __( 'Facebook', 'mega' ),
				'link'	=> 'http://www.facebook.com/%s',
				'api'	=> array(
					'type'	=> 'json',//only json?
					'data'	=> 'https://graph.facebook.com/%1$s?access_token=%2$s|%3$s',
					'key'	=> 'likes'
				)
			),
/*			'twitter' => array(
				'name'	=> __( 'Twitter', 'mega' ),
				'link'	=> 'http://twitter.com/%s',
				'api'	=> array(
					'type'	=> 'json',
					'data'	=> 'http://api.twitter.com/1/users/show.json?skip_status=1&screen_name=%s',
					'key'	=> 'followers_count'
				)
			),*/
			'dribbble' => array(
				'name'	=> __( 'Dribbble', 'mega' ),
				'link'	=> 'http://dribbble.com/%s',
				'api'	=> array(
					'type'	=> 'json',
					'data'	=> 'http://api.dribbble.com/%s',
					'key'	=> 'followers_count'
				)
			)
		);

		parent::__construct( __CLASS__, $args );

		add_filter( 'mega_block_follow_counter_args', array( &$this, 'mega_block_follow_args' ));
	}

	public function mega_block_follow_args( $args )
	{
		$args['enqueue']['css'] = array( 'id' => 'Mega_Block_Follow', 'path' => '/theme/assets/css/class.Mega_Block_Follow.css' );

		return $args;
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'value' => __( 'Follow Us', 'mega' ), 'name' => 'title' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Facebook', 'mega' ), 'value' => '.', 'name' => 'facebook' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Facebook App ID', 'mega' ), 'value' => '', 'name' => 'facebook_app' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Facebook App Secret', 'mega' ), 'value' => '', 'name' => 'facebook_app_secret' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Facebook Meta', 'mega' ), 'pro' => 1, 'desc' => __( 'Use the following snippets of code to output the necessary information:<br/><br/>Number - <strong>[number]</strong><br/>', 'mega' ), 'value' => __( '[number] Fans', 'mega' ), 'name' => 'facebook_meta' ));
		//$this->addChild( 'Mega_Block_Form_Text', array( 'label' => __( 'Twitter', 'mega' ), 'value' => '.', 'name' => 'twitter' )),
		//$this->addChild( 'Mega_Block_Form_Text', array( 'label' => __( 'Twitter Meta', 'mega' ), 'pro' => 1, 'value' => __( '%s Followers', 'mega' ), 'name' => 'twitter_meta' )),
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Dribbble', 'mega' ), 'value' => '.', 'name' => 'dribbble' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Dribbble Meta', 'mega' ), 'pro' => 1, 'desc' => __( 'Use the following snippets of code to output the necessary information:<br/><br/>Number - <strong>[number]</strong><br/>', 'mega' ), 'value' => __( '[number] Followers', 'mega' ), 'name' => 'dribbble_meta' ));
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		echo '<ul>';

		foreach ( $this->bookmarks as $key => $args )
		{
			if ( !empty( $$key ) && ( $counter = $this->getCounter( $key, $args['api'], $$key )))
				printf(
					'<li class="%1$s"><a rel="nofollow" href="%2$s" title="%4$s" target="_blank"><i class="icon"></i><span class="name">%3$s</span></a></li>',
					$key,
					esc_url( sprintf( $args['link'], $$key )),
					mega_parse_message( array( 'number' => '<span class="count">' . number_format( $counter ) . '</span>' ), ${$key . '_meta'} ),
					mega_parse_message( array( 'number' => number_format( $counter )), ${$key . '_meta'} )
				);
		}

		echo '</ul>';
	}

	public function getCounter( $id, $args, $user )
	{
		if ( $counter = get_transient( $id . '_counter' ))
			return $counter;

		if ( !$user || empty( $user ))
			return false;


		if ( isset( $this->mega['settings'][$id . '_app'] ) && isset( $this->mega['settings'][$id . '_app_secret'] ))
			$new = sprintf( $args['data'], $user, $this->mega['settings'][$id . '_app'], $this->mega['settings'][$id . '_app_secret'] );
		else
			$new = sprintf( $args['data'], $user );

		$data = json_decode( wp_remote_retrieve_body( wp_remote_get( $new )));

		if ( isset( $data->$args['key'] ))
			$data1 = $data->$args['key'];

		if ( !isset( $data1 ) || empty( $data1 ))
			return false;

		set_transient( $id . '_counter', $data1, 3600 );

		return $data1;
	}
}