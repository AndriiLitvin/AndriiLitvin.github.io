<?php

function mega_html( $data, $before = '', $after = '', $echo = true )//$echo, 
{
	if ( !$data || empty( $data ))
		return;

	$r = $before . $data . $after;

	if ( $echo )
		echo $r;
	else
		return $r;
}

function mega_parse_message( $args, $message )
{
	foreach ( $args as $key => $value )
		$message = preg_replace( sprintf( '/\[%s\]?/', $key ), $value, $message );

	return $message;
}

function mega_thumb( $args = array(), $r = false )
{
	$defaults = array(
		'width'			=> '100%',
		'height'		=> '100%',
		'maxheight'		=> false,
		'custom'		=> '',
		'placeholder'	=> 'holder.js/%1$sx%2$s?bg=f9f9f9',//http://placehold.it/%1$sx%2$s/fff
		'class'			=> array(),
		'sources'		=> array( 'custom' => 1, 'featured' => 1, 'first' => 1, 'ph' => 1 )
	);

	$args['sources'] = wp_parse_args( $args['sources'], array( 'custom' => 0, 'featured' => 0, 'first' => 0, 'ph' => 0 ));

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	if ( !empty( $custom ) && $sources['custom'] )
	{
		$src = $custom;
	}
	elseif ( has_post_thumbnail() && $sources['featured'] )
	{
		$src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'full', false );
		$src = $src[0];
	}
	elseif ( $custom = get_post_meta( get_the_id(), 'thumbnail', true ))
	{
		$src = $custom;
	}
	elseif ( substr_count( get_the_content(), '<img' ) && $sources['first'] )
	{
		$doc = new DOMDocument();
		@$doc->loadHTML( get_the_content() );
		$images = simplexml_import_dom( $doc )->xpath( '//img' );
		$img = $images[0];
		$src = $img['src'];
	}
	elseif ( $sources['ph'] )
	{
		$phwidth = $width;
		$phheight = $height;

		if ( preg_match( '/%/', $width ))
			$phwidth = preg_replace( '/%/', 'p', $width );

		if ( preg_match( '/%/', $height ))
			$phheight = preg_replace( '/%/', 'p', $height );

		if ( $maxheight )
		{
			$phheight = $maxheight;

			if ( preg_match( '/px/', $phheight ))
				$phheight = preg_replace( '/px/', '', $phheight );
		}

		$phgo = 1;

		$src = sprintf( $placeholder, $phwidth, ( $phheight == 'auto' ? 250 : $phheight ));
	}

	$class = 'thumb ' . implode( ' ', $class );

	$title = empty( $custom ) ? get_the_title() : '';

	if ( $r )
		return $src;

	if ( !empty( $src ))
		printf( '<img class="%1$s" ' . ( isset( $phgo ) ? 'data-src' : 'src' ) . '="%2$s" title="%3$s" alt="%3$s" width="%4$s" height="%5$s" data-max-height="%6$s" />', $class, $src, $title, $width, $height, $maxheight );
}

function mega_register_block( $block_class )
{
	global $mega_registered_blocks, $mega_universal_blocks;

	if ( isset( $mega_registered_blocks[$block_class] ))
		return false;

	$block = new $block_class();

	//$block->init_filters();

	if ( $block->mega['args']['universal'] )
	{
		$mega_universal_blocks[] = $block_class;

		register_widget( $block_class );
	}

	$mega_registered_blocks[$block_class] = $block;
}

function mega_unregister_block( $block_class )
{
	global $mega_registered_blocks;

	if ( isset( $mega_registered_blocks[$block_class] ))
		unset( $mega_registered_blocks[$block_class] );


	$block_class = strtolower($block_class);

	foreach($aq_registered_blocks as $block) {
		if($block->id_base == $block_class)
			unset( $mega_registered_blocks[$block_class] );
	}
}

function mega_remote_data( $key )
{
	$transient = get_template() . '_remote_data';

	if ( get_transient( $transient ) === false )
		set_transient(
			$transient,
			json_decode( wp_remote_retrieve_body( wp_remote_get( 'http://www.megathemes.com/api.json' )), true ),//?theme=' . get_template()
			3600
		);

	$data = get_transient( $transient );

	if ( isset( $data[$key] ) && !empty( $data[$key] ))
		return $data[$key];

	return false;
}

//combine into a global object? ->AuthorURI{'Author URI'}

//price/themes-price/gold-price/silver-price



function mega_auto_tag( $tag, array $args )
{
	$args = wp_parse_args( $args, array(
		'text'	=> '',
		'attr'	=> array()
	));

	extract( $args );

	$attr_mapping = array(
		'h' => array(
			'id'		=> true,
			'class'		=> true,
			'style'		=> true
		),
		'a' => array(
			'id'		=> true,
			'class'		=> true,
			'style'		=> true,
			'href'		=> true
		)
	);

	if ( empty( $text ))
		return;

	switch( $tag )
	{
		case 'h1' : case 'h2' :	case 'h3' :	case 'h4' :	case 'h5' :	case 'h6' :
			$attr = array_intersect_key( (array) $attr, $attr_mapping['h'] );

			return "<$tag" . mega_auto_attr( $attr ) . ">$text</$tag>";

			//return "<$tag>$text</$tag>";

		case 'a' :
			$attr = array_intersect_key( (array) $attr, $attr_mapping[$tag] );

			//$class = isset( $class ) ? ' class="' . $class . '" ' : '';

			if ( empty( $attr['href'] ))
				return $text;

			$attr['href'] = esc_url( $attr['href'] );

			return '<a' . mega_auto_attr( $attr ) . ">$text</a>";

			//return empty( $attr['href'] ) ? $text : '<a' . mega_auto_attr( $attr ) . '>' . $text . '</a>';
	}
}

function mega_auto_attr( array $attrs )
{
	$r = '';

	foreach( $attrs as $attr => $value )
		if ( !empty( $value ))
			$r .= ' ' . $attr . '="' . $value . '" ';

	return $r;//implode by space
}

function mega_option( $key = '', $echo = false )
{
	global $mega_registered_blocks;

	$output = isset( $mega_registered_blocks['Mega_Theme_Settings']->mega['settings'][$key] ) ? $mega_registered_blocks['Mega_Theme_Settings']->mega['settings'][$key] : false;

	if ( $echo == true )
		echo $output;
	else
		return $output;
}







function megaGetDB()
{
	return get_option( MEGA_DB_ID );
}

function megaUpdateDB( $mega_db )
{
	return update_option( MEGA_DB_ID, $mega_db );
}

function megaDeleteDB()
{
	return delete_option( MEGA_DB_ID );
}

function megaSetPackage( $package = '0' )
{
	global $mega_package;

	if ( !isset( $mega_package ))
		$mega_package = get_option( MEGA_DB_ID . '_package', null );

	if ( $package <= $mega_package )
		return false;

	$mega_package = $package;

	update_option( MEGA_DB_ID . '_package', $mega_package );
}


function mega_widget( $id_base, $settings = array() )
{
	if ( !Mega_Walker::getBlockObject( $id_base ) && !Mega_Walker::getWidgetObject( $id_base ))
		return;

	if ( $obj = Mega_Walker::getWidgetObject( $id_base ))
	{
		if ( $object = Mega_Walker::getBlockObject( $id_base ))
			$settings = wp_parse_args( $settings, $object->mega['settings'] );

		the_widget( $id_base, $settings, array(
			'before_widget'		=> sprintf( '<div class="widget %s">', $obj->widget_options['classname'] ),
			'after_widget'		=> '</div>',
			'before_title'		=> '<h3>',
			'after_title'		=> '</h3>'
		));
	}
	else
	{
		$newobject = new $id_base;

		$newobject->mega['settings'] = wp_parse_args( $settings, $newobject->mega['settings'] );

		$newobject->callback();
	}
}



function mega_hierarchy()
{
	if ( is_front_page())
		$hierarchy[] = 'front_page';

	if ( is_day())
		$hierarchy[] = 'day';

	if ( is_month())
		$hierarchy[] = 'month';

	if ( is_year())
		$hierarchy[] = 'year';

	if ( is_date())
		$hierarchy[] = 'date';

	if ( is_author())
		$hierarchy[] = 'author';

	if ( is_category())
		$hierarchy[] = 'category';

	if ( is_tag())
		$hierarchy[] = 'tag';

	if ( is_tax())
		$hierarchy[] = 'taxonomy';

	if ( is_archive())
		$hierarchy[] = 'archive';

	if ( is_search())
		$hierarchy[] = 'search';

	if ( is_404())
		$hierarchy[] = '404';

	if ( is_attachment())
		$hierarchy[] = 'attachment'; //is image

	if ( is_singular( 'post' )) //is_single
		$hierarchy[] = 'single';

	if ( is_page())
	{
		$slug = get_page_template_slug( get_the_ID() );

		if ( !empty( $slug ))
			$hierarchy[] = $slug;

		$hierarchy[] = 'page';
	}

	//if ( is_singular()) //custom post type //but not post or page?
		//$hierarchy[] = get_post_type();

	if ( is_home())
		$hierarchy[] = 'home';

	$hierarchy[] = 'index';

	return $hierarchy;
}

function mega_toggle( $location = array() )
{
	$location1 = wp_parse_args( $location, array(//remove cause it conflicts
		'front_page'				=> 0,
		'category'					=> 0,
		'archive'					=> 0,
		'search'					=> 0,
		'post'						=> 0,
		'template-home.php'			=> 0,
		'template-onecolumn.php'	=> 0,
		'template-login.php'		=> 0,
		'template-contact.php'		=> 0,
		'page'						=> 0,
		'home'						=> 0
	));

	$hierarchy = mega_hierarchy();

	foreach( $hierarchy as $page )
	{
		if ( !isset( $location[$page] ))
			continue;

		if ( $location[$page] )
			return true;
		else
			return false;
	}
}

function mega_clean_words( $count, $data )
{
	if ( strlen( $data ) > $count )
		return preg_replace('/\s+?(\S+)?$/', '', substr($data, 0, $count));
	else
		return $data;

/*
//http://stackoverflow.com/questions/79960/how-to-truncate-a-string-in-php-to-the-word-closest-to-a-certain-number-of-charac/79986#79986

	$pos = strpos( $data, ' ', $count );

	if ( $pos !== false )
		return substr( $data, 0, ( $count + $pos ));
	else
		return $data;
		*/
}

function mega_wp_kses_js( $value )//wp_kses is no good - it converts < ' > entities
{
	//strip_tags( $value, '<script>' );//
	return html_entity_decode( wp_kses( $value, array( 'script' => array( 'type' => array(), 'src' => array() ))));
}

function mega_upgrade_url( $medium = '' )
{
	$screen = get_current_screen();

	return wp_get_theme()->get( 'ThemeURI' ) . '?utm_source=' . wp_get_theme()->get( 'Name' ) . '&utm_medium=' . $screen->id . '_' . $medium . '&utm_campaign=upgrade';
}




function mega_register_location( $args )
{
	$location = new Mega_Location();

	$location->registerLocation( $args );
}

function mega_location( $location )
{
	global $mega_locations;

	$mega_locations->getLocation( $location );
}


function mega_float( $float = 'left' )
{
	if ( $float === 'left' )
	{
		return is_rtl() ? 'right' : $float;
	}
	else if ( $float === 'right' )
	{
		return is_rtl() ? 'left' : $float;
	}
	else
		return false;
}






add_filter( 'posts_where', 'mega_pretty_post_filter', 10, 2 );

function mega_pretty_post_filter( $where, &$wp_query )
{
	global $wpdb;

	if ( $wp_query->get( 'exclude_empty_titles' ))
	{
		$where .= ' AND CHAR_LENGTH(' . $wpdb->posts . '.post_title) > 0';
	}

	if ( $wp_query->get( 'min_excerpt_length' ) > 0 )
	{
		$where .= ' AND CHAR_LENGTH(' . $wpdb->posts . '.post_content) > ' . $wp_query->get( 'min_excerpt_length' );
	}

	return $where;
}

function mega_get_pretty_post( $count, $i = 0 )
{
	$posts = get_posts( array(
		'posts_per_page'		=> 1,
		'orderby'				=> 'rand',
		'suppress_filters'		=> false,
		'exclude_empty_titles'	=> true,
		'min_excerpt_length'	=> $count
	));

	foreach ( $posts as $post )
	{
		setup_postdata( $post );

		$excerpt = get_the_excerpt();

		wp_reset_postdata();

		if ( $count <= strlen( $excerpt ))
			return $post->ID;
		else if ( $i < 2 )
			return mega_get_pretty_post( $count, ++$i );
		else
			return '-1';
	}
}