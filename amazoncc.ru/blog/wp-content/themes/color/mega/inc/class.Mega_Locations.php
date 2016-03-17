<?php

$mega_locations = new Mega_Location_Manager();

class Mega_Location
{
	public $pages = array(
		'front_page',
		'category',
		'archive',
		'search',
		'404',
		'single',
		'template-home.php',
		'template-onecolumn.php',
		'template-login.php',
		'template-contact.php',
		'page',
		'home'
	);

	public function __construct()
	{
		$this->pages = apply_filters( 'mega_pages', $this->pages );
	}

	public function registerLocation( array $args )
	{
		global $mega_sidebars;

		$args = apply_filters( 'mega_location_' . $args['id'], $args );

		if ( !isset( $args['sidebar'] ) || $args['sidebar'] !== false )
			$mega_sidebars->registerSidebar( $args['id'], array( 'id' => $args['id'], 'name' => $args['name'] ));

		$this->args = $args;

		add_action( 'wp_loaded', array( $this, 'register' ));
	}

	public function register()
	{
		$args = $this->args;

		global $mega_registered_pages, $mega_registered_locations, $mega_registered_statics, $mega_sidebars;

		if ( isset( $args['id'] ) && !empty( $args['id'] ) && !isset( $mega_registered_locations[$args['id']] ))
		{
			$mega_registered_locations[$args['id']] = $args;

			unset( $mega_registered_locations[$args['id']]['statics'] );
		}

		if ( isset( $args['statics'] ))
		{
			if ( !is_array( $args['statics'][0] ) && is_callable( $args['statics'] ))
				call_user_func( $args['statics'], $this );
			else
				foreach( $args['statics'] as $static )
				{
					$static_id = $args['id'] . '-' . $static['id_base'] . '-' . $static['id'];

					if ( !isset( $mega_registered_statics[$static_id] ))
					{
						$mega_registered_statics[$static_id] = $static;

						$mega_registered_locations[$args['id']]['statics'][] = $static_id;
					}
				}
		}

		if ( isset( $args['pages'] ))
		{
			if ( $args['pages'] === true )
				$args['pages'] = $this->pages;

			foreach( $args['pages'] as $page )
				if ( !isset( $mega_registered_pages['include'][$page] ) || !in_array( $args['id'], $mega_registered_pages['include'][$page] ))
					$mega_registered_pages['include'][$page][] = $args['id'];
		}

		if ( isset( $args['exclude'] ))
		{
			foreach( $args['exclude'] as $page )
				if ( !isset( $mega_registered_pages['exclude'][$page] ) || !in_array( $args['id'], $mega_registered_pages['exclude'][$page] ))
					$mega_registered_pages['exclude'][$page][] = $args['id'];
		}
	}

	public function addStatic( $id, $id_base, $settings = array() )
	{
		global $mega_registered_statics, $mega_registered_locations;

		$static_id = $this->args['id'] . '-' . $id_base . '-' . $id;

		if ( !isset( $mega_registered_statics[$static_id] ))
		{
			$mega_registered_statics[$static_id] = array( 'id' => $id, 'id_base' => $id_base, 'settings' => $settings );

			$mega_registered_locations[$this->args['id']]['statics'][] = $static_id;
		}
	}
}


class Mega_Location_Manager
{
	public function __construct()
	{
		add_action( 'template_redirect', array( $this, 'initHooks' ));
	}

	public function getLocations( $hierarchy )
	{
		global $mega_registered_pages;

$r = array();

		$hierarchy[] = 'index';

		foreach( $hierarchy as $key => $value )
		{
			if ( isset( $mega_registered_pages['include'][$value] ))
				$r = $mega_registered_pages['include'][$value];

			if ( isset( $r ))
			{
				if ( isset( $mega_registered_pages['exclude'][$value] ))
					$r = array_diff( $r, $mega_registered_pages['exclude'][$value] );
			}

			return $r;
			//run exclude
		}
	}

	public function registerStatic()
	{
		
	}

	public function getLocation( $location )
	{
		if ( in_array( $location, $this->getActiveLocations() ))
		{
			global $mega_sidebars;

			$sidebar = $mega_sidebars->getActiveSidebar( $location );

			if ( $sidebar && is_active_sidebar( $sidebar ))
				dynamic_sidebar( $sidebar );
			else
			{
				global $mega_registered_statics, $mega_registered_locations;

				if ( $sidebar != false && $location !== $sidebar )
					$location = $sidebar;
//echo $location;

				if ( !isset( $mega_registered_locations[$location]['statics'] ) || !is_array( $mega_registered_locations[$location]['statics'] ))
					return;

				$statics = $mega_registered_locations[$location]['statics'];

				foreach( $statics as $static_id )
				{
					$static = $mega_registered_statics[$static_id];

					if ( !isset( $static['settings'] ))
						$static['settings'] = array();

					if ( !Mega_Walker::getBlockObject( $static['id_base'] ) && !Mega_Walker::getWidgetObject( $static['id_base'] ))
						continue;

					if ( $obj = Mega_Walker::getWidgetObject( $static['id_base'] ))
					{
						if ( $object = Mega_Walker::getBlockObject( $static['id_base'] ))
							$static['settings'] = wp_parse_args( $static['settings'], $object->mega['settings'] );

						$args = $mega_sidebars->getDefaultSidebarArgs();

						$args['before_widget'] = sprintf( $args['before_widget'], $static_id, $obj->widget_options['classname'], '%3$s' );

						the_widget( $static['id_base'], $static['settings'], $args );
					}
					else
					{
						if ( isset( $mega_registered_statics[$static_id] ))
						{
							$mega_registered_statics[$static_id]['callback']->callback();
						}
					}
				}
			}
		}
	}

	public function getActiveLocations()
	{
		global $mega_registered_pages;

		$hierarchy = mega_hierarchy();

		$active = array();

$value = $hierarchy[0];

		//foreach( $hierarchy as $key => $value )
		//{
			if ( $value === 'page' && $slug = get_page_template_slug( get_the_ID() ))
				if ( isset( $mega_registered_pages['include'][$slug] ))
					$value = $slug;
					//return $mega_registered_pages[$slug];

			if ( isset( $mega_registered_pages['include'][$value] ))
			{
				$active = $mega_registered_pages['include'][$value];
			}

			if ( isset( $mega_registered_pages['include']['index'] ))
			{
				foreach( $mega_registered_pages['include']['index'] as $key )
					if ( !in_array( $key, $active ))
						$active[] = $key;
			}

			if ( isset( $mega_registered_pages['exclude'][$value] ))
				foreach( $mega_registered_pages['exclude'][$value] as $key )
					if (( $k = array_search( $key, $active )) !== false )
						unset( $active[$k] );
		//}

		return $active;
	}





	public function initHooks()//hook
	{
		global $mega_registered_blocks, $mega_registered_locations, $mega_registered_statics, $mega_sidebars;

		foreach( $this->getActiveLocations() as $location )
		{
			$sidebar = $mega_sidebars->getActiveSidebar( $location );

			if ( isset( $sidebar ) && is_active_sidebar( $sidebar ))
			{
				global $wp_registered_widgets;

				$sidebars_widgets = wp_get_sidebars_widgets();

				foreach( $sidebars_widgets[$sidebar] as $number => $widget )
				{
					if ( isset( $wp_registered_widgets[$widget] ) && is_a( $callback = $wp_registered_widgets[$widget]['callback'][0], 'Mega_Walker' ))
					{
						$callback->parseWidgetSettings( $wp_registered_widgets[$widget]['params'][0]['number'] );

						//$callback->hookCallback();

							$class = get_class( $callback );

							$newobject = new $class( $class );

							$newobject->parseWidgetSettings( $wp_registered_widgets[$widget]['params'][0]['number'] );

							$newobject->mega['new_settings'] = $newobject->mega['settings'];

							$newobject->mega['args']['id'] = $wp_registered_widgets[$widget]['id'];
							$newobject->mega['args']['beforeTitle'] = '<h3>';
							$newobject->mega['args']['afterTitle'] = '</h3>';

							$newobject->id = $wp_registered_widgets[$widget]['id'];

							add_action( 'template_redirect', array( $newobject, 'parsing' ), 11 );
							add_action( 'template_redirect', array( $newobject, 'parsing2' ), 11 );

							$newobject->hookCallback();
					}
				}
			}
			else
			{
				$statics = $mega_registered_locations[$location]['statics'];

				if ( isset( $statics ))
					foreach( $statics as $static_id )
					{
						$widget = $mega_registered_statics[$static_id];

						$id_base = $widget['id_base'];

						if ( !Mega_Walker::getBlockObject( $id_base ) && !Mega_Walker::getWidgetObject( $id_base ))
							continue;

						if ( $obj = Mega_Walker::getBlockObject( $id_base ))
						{
							$newobject = new $id_base( $id_base );

							if ( isset( $widget['settings'] ))
								$newobject->mega['new_settings'] = $widget['settings'];

							$newobject->mega['args']['id'] = $static_id;
							$newobject->mega['args']['beforeTitle'] = '<h3>';
							$newobject->mega['args']['afterTitle'] = '</h3>';

							$newobject->id = $static_id;

							add_action( 'template_redirect', array( $newobject, 'parsing' ), 11 );
							add_action( 'template_redirect', array( $newobject, 'parsing2' ), 11 );

							$mega_registered_statics[$static_id]['callback'] = $newobject;

							$newobject->hookCallback();
						}
					}
			}
		}
	}
}