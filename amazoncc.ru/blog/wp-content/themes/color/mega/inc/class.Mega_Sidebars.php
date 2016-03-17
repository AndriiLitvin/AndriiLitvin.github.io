<?php

$mega_sidebars = new Mega_Sidebars();

class Mega_Sidebars
{
	public function __construct()
	{
		add_action( 'widgets_init', array( &$this, 'registerPostSidebars' ));
		//add_action( 'template_redirect', array( $this, 'initHooks' ));

		if ( is_admin() )
		{
			add_action( 'load-post.php', array( &$this, 'metaBoxInit' ));
	    	add_action( 'load-post-new.php', array( &$this, 'metaBoxInit' ));
		}
	}

	public function registerSidebar( $location, array $args )
	{
		global $mega_registered_sidebars;

		$args = wp_parse_args( $args, $this->getDefaultSidebarArgs() );

		if ( !empty( $location ) && !empty( $args['id'] ) && !isset( $mega_registered_sidebars[$location] ))
			$mega_registered_sidebars[$location] = $args['id'];

		return register_sidebar( $args );
	}

	public function getActiveSidebar( $location )
	{
		global $mega_registered_sidebars;

		if ( is_singular( 'post' ) || is_page() )
		{
			$post_sidebars = get_post_meta( get_the_ID(), '_mega_sidebars', true );

			if ( isset( $post_sidebars[$location] ))
			{
				if ( $post_sidebars[$location] === 'new' )
					return get_the_ID() . '_' . $location;
				else if ( !empty( $post_sidebars[$location] ))
					return $post_sidebars[$location];
			}
		}

		if ( isset( $mega_registered_sidebars[$location] ))
			return $mega_registered_sidebars[$location];
	}

	public function getDefaultSidebarArgs()
	{
		return apply_filters( 'mega_default_sidebar_args', array(
			'id'				=> '',
			'name'				=> '',
			'description'		=> '',
			'before_widget'		=> '<div id="%1$s" class="widget %2$s classholder">',//%%3$s
			'after_widget'		=> '</div>',
			'before_title'		=> '<h3>',
			'after_title'		=> '</h3>'
		));
	}

	public function registerPostSidebars()
	{
		$mega_db = megaGetDB();

		if ( isset( $mega_db['sidebars'] ))
		{
			foreach( $mega_db['sidebars'] as $post_id => $locations )
			{
				foreach( $locations as $location )
				{
					register_sidebar( wp_parse_args( array(
						'id'			=> $post_id . '_' . $location,
						'name'			=> get_the_title( $post_id ) . ' - ' . $location,
						'description'	=> sprintf(
							__( 'Widgets in this area are for the post/page %s and will appear at this location: %s', 'mega' ),
							get_the_title( $post_id ),
							$location
						)
					), $this->getDefaultSidebarArgs()));
				}
			}
		}
	}

	public function metaBoxInit()
	{
		add_action( 'add_meta_boxes', array( $this, 'addMetaBox' ));
		add_action( 'save_post', array( $this, 'saveMetaBox' ));
	}

	public function addMetaBox( $type )
	{
		if ( $type === 'dashboard' OR $type === 'link' )
			return;

		add_meta_box(
			'_mega_sidebars',
			__( 'Mega Sidebars', 'mega' ),
			array( $this, 'renderMetaBox' ),
			$type,
			'normal',
			'high'
		);
	}

	public function renderMetaBox( $post, $metabox )
	{
		wp_nonce_field( 'mega_sidebars_box', 'mega_sidebars_box_nonce' );

		$value = get_post_meta( $post->ID, '_mega_sidebars', true );

		global $wp_registered_sidebars, $mega_registered_sidebars, $mega_locations, $mega_sidebars;

	$this->mega['args']['id_base_low'] = 'msb';

		$form = new Mega_Form_Manager( array( 'type' => 'echo', 'callback' => array( $this, '_setMetaFormData' )));

		if ( $post->post_type === 'page' )
		{
			if ( get_option( 'show_on_front' ) === 'page' && get_option( 'page_on_front' ) === $post->ID )
				$hierarchy[] = 'front_page';

			if ( get_page_template_slug( $post->ID ))
				$hierarchy[] = get_page_template_slug( $post->ID );

			$hierarchy[] = 'page';
		}
		else if ( $post->post_type === 'post' )
			$hierarchy[] = 'single';

		$locations = $mega_locations->getLocations( $hierarchy );

		foreach( $wp_registered_sidebars as $sidebar )
			$sidebars[$sidebar['id']] = $sidebar['name'];

		foreach( $locations as $location )
		{
			$choices = array();
			
			$sidebar = '';

			if ( isset( $mega_registered_sidebars[$location] ))
				$sidebar = $mega_registered_sidebars[$location];

			if ( isset( $wp_registered_sidebars[$sidebar] ))
				$name = $wp_registered_sidebars[$sidebar]['name'];
			else
				$name = __( 'No sidebar (static)', 'mega' );

			$choices['']	= sprintf( __( 'Default: %s', 'mega' ), $name );
			$choices['new'] = sprintf( __( 'New: %s', 'mega' ), $post->post_title . ' - ' . $location );

			$choices = wp_parse_args( $sidebars, $choices );

			if ( !empty( $sidebar ))
				unset( $choices[$sidebar] );

			$form->add_control( 'Mega_Control_Select', array( 'label' => sprintf( __( 'Location: %s', 'mega' ), $location ), 'value' => isset( $value[$location] ) ? $value[$location] : '', 'name' => "_mega_sidebars[$location]", 'choices' => $choices ));
		}






		//$select->mega['settings']['value']		= $value;
		//$select->mega['settings']['name']		= '_mega_sidebars';
		//$select->mega['settings']['id']			= 'mega_sidebars';
	}

	public function _setMetaFormData( &$args )
	{
		//if ( isset( $this->mega['settings'][$args['name']] ))
			//$args['value'] = $this->mega['settings'][$args['name']];

		//$args['id']		= $this->get_field_id( $args['name'] );
	}

	public function saveMetaBox( $post_id )
	{
		if ( ! isset( $_POST['mega_sidebars_box_nonce'] ))
			return $post_id;

		$nonce = $_POST['mega_sidebars_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'mega_sidebars_box' ))
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'page' === $_POST['post_type'] )
		{
			if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
		}
		else
		{
			if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
		}

		$changed = false;

		$mega_db = megaGetDB();

		unset( $mega_db['sidebars'][$post_id] );

		foreach( $_POST['_mega_sidebars'] as $key => $data )
		{
			$mydata[$key] = sanitize_text_field( $data );

			if ( !empty( $mydata[$key] ))
				$changed = true;

			if ( $mydata[$key] === 'new' )
			{
				$mega_db['sidebars'][$post_id][] = $key;
			}
		}

		megaUpdateDB( $mega_db );

		if ( $changed )
			update_post_meta( $post_id, '_mega_sidebars', $mydata );
		else
			delete_post_meta( $post_id, '_mega_sidebars' );
	}
}