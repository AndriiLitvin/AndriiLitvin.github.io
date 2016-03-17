<?php

$mega_db = megaGetDB();

class Mega_Walker extends Mega_Block_WP_Widget_Bridge
{
	public $hookOnce = false;

	public $mega;

	public function __construct( $id_base = false, $block_args = array() )
	{
		global $mega_registered_blocks;

		if ( isset( $mega_registered_blocks[$id_base] ))
		{
			$this->mega = $mega_registered_blocks[$id_base]->mega;

			return;
		}

		$block_args = apply_filters( strtolower( $id_base ) . '_args', $block_args );

		$this->initParsing( $block_args );

		if ( has_filter( $this->mega['args']['id_base_low'] . '_settings' ))
			$this->filter = apply_filters( $this->mega['args']['id_base_low'] . '_settings', array() );

		//if ( is_admin() )
			//add_action( 'customize_register', array( &$this, 'registerSettings' ));
		//else
			$this->registerSettings( new Mega_Form_Manager( array( 'type' => 'build', 'callback' => array( $this, 'buildSettings' ))));

		add_action( 'wp_loaded', array( &$this, 'parsing' ));//wp_loaded//wp_enqueue_scripts

		global $mega_universal_blocks;

		$k = array_search( $this->mega['args']['id_base'], (array) $mega_universal_blocks );

		if ( $this->mega['args']['universal'] && $k !== false )
		{
			parent::__construct(
				wp_get_theme()->get( 'Name' ) . '_' . $this->mega['args']['id_base_low'],
				$k + 1 . '. ' . __( 'MegaThemes', 'mega' ) . ' - ' . $this->mega['args']['profile']['name'],
				array( 'description' => $this->mega['args']['profile']['description'], 'classname' => $this->mega['args']['id_base_low'] )
			);
		}
	}

	public function settings( $form ) {}

	public function registerSettings( $form )
	{
		$this->settings( $form );
	}

	public function buildSettings( &$args )
	{
		if ( !empty( $args['name'] ))
		{
			$this->mega['settings_defaults'][$args['name']] = $args['value'];

			$this->mega['settings_sanitize'][$args['name']]['callback'] = $args['sanitize'];

			$this->mega['settings_validate'][$args['name']]['callback'] = $args['validate'];

			if ( isset( $args['choices'] ))
				$this->mega['settings_sanitize'][$args['name']]['choices'] = $args['choices'];
		}
	}

	public function setSettings( &$args )
	{
		if ( isset( $this->mega['settings'][$args['name']] ))
			$args['value'] = $this->mega['settings'][$args['name']];

		$args['id']			= $this->mega['args']['id_base_low'] . '_' . $args['name'];
		$args['name']		= $this->getSettingsFieldName( $args['name'] );
		$args['control']	= $this->mega['args']['id_base_low'] . '_' . $args['control'];
	}

	public function hook() {}

	public function hookOnce() {}

	public function hookCallback()
	{
		global $mega_registered_blocks;

		$this->hook();

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueueCSS' ));

		if ( isset( $mega_registered_blocks[$this->mega['args']['id_base']] ) && !$mega_registered_blocks[$this->mega['args']['id_base']]->hookOnce )
		{
			$this->hookOnce();

			$mega_registered_blocks[$this->mega['args']['id_base']]->hookOnce = true;
		}
	}

	public function enqueueCSS()
	{
		$css = $this->mega['args']['enqueue']['css']['path'];

		if ( isset( $css ) && !empty( $css ) && file_exists( get_template_directory() . $css ))
			wp_enqueue_style( 'mega.css.' . $this->mega['args']['enqueue']['css']['id'], get_template_directory_uri() . $css );
	}

	public function callback()
	{
		echo $this->before();

		$this->getTitle();
		$this->block();

		echo $this->after();
	}

	public function block()
	{
		_e( 'Function Mega_Walker::block should not be accessed directly.', 'mega' );
	}

	public function initParsing( $args = array() )
	{
		$defaults = array(
			'before'			=> '',
			'after'				=> '',
			'beforeTitle'		=> '',
			'afterTitle'		=> '',
			'beforeChild'		=> '',
			'afterChild'		=> '',
			'beforeChildTitle'	=> '',
			'afterChildTitle'	=> '',
			'number'			=> false,
			'layout'			=> false,
			'profile'			=> array( 'name' => false, 'desc' => false ),
			'universal'			=> false,
			'universal_pro'		=> false,
			'pro'				=> false,
			'enqueue'			=> array( 'css' => array( 'id' => get_class( $this ), 'path' => '/theme/assets/css/class.' . get_class( $this ) . '.css' ))
		);

		$this->mega['args']					= wp_parse_args( $args, $defaults );
		$this->mega['args']['id_base']		= get_class( $this );//empty( $id_base ) ? get_class( $this ) : $id_base;
		$this->mega['args']['id_base_low']	= strtolower( $this->mega['args']['id_base'] );

		//$this->buildSettings();
		//$this->parsing();
	}

	public function parsing()
	{
		$mega = megaGetDB();

		$this->mega['settings'] = array();

		if ( isset( $this->mega['settings_defaults'] ))
			$this->mega['settings'] = $this->mega['settings_defaults'];

		if ( is_array( $mega ) && isset( $mega[$this->mega['args']['id_base_low']] ))
			$this->mega['settings'] = wp_parse_args( $mega[$this->mega['args']['id_base_low']], $this->mega['settings'] );
	}

	public function registerStaticSettings()
	{
		add_action( 'wp_loaded', array( &$this, 'parsing2' ), 11 );
	}

	public function parsing2()
	{
		if ( isset( $this->mega['new_settings'] ))
			$this->mega['settings'] = wp_parse_args( $this->mega['new_settings'], $this->mega['settings'] );
	}

	public function getSettingsFieldName( $field )
	{
		return 'mega[' . $this->mega['args']['id_base'] . '][' . $field . ']';
	}

	public function getTitle()
	{
		if ( !empty( $this->mega['args']['beforeTitle'] ) && !empty( $this->mega['settings']['title'] ))
		{
			echo $this->sprint( $this->mega['args']['beforeTitle'] );
			echo $this->mega['settings']['title'];//apply_filters( 'widget_title', 
			echo $this->sprint( $this->mega['args']['afterTitle'] );
		}
	}

	public function before()
	{
		return $this->sprint( $this->mega['args']['before'] );
	}

	public function after()
	{
		return $this->sprint( $this->mega['args']['after'] );
	}

	public function sprint( $string = '' )
	{
		extract( $this->mega['args'] );

		if ( !isset( $class ))
			$class = array();

		if ( $layout )
			$class[] = $layout;

		$class = trim( implode( ' ', $class ));

		if ( !empty( $class ))
			$class = ' ' . $class;

		$string = preg_replace( '/classholder/', $class, $string );

		return sprintf( $string, isset( $id ) ? $id : '', strtolower( $id_base ), $class, '' );
	}

	public static function getWidgetObject( $block_id )//and not a block object that is also a widget object!
	{
		global $wp_widget_factory;

		if ( !isset( $wp_widget_factory->widgets[$block_id] ))
			return false;

		$object = $wp_widget_factory->widgets[$block_id];

		if ( !is_a( $object, 'WP_Widget' ))
			return false;

		return $object;
	}

	public static function getBlockObject( $block_id )
	{
		global $mega_registered_blocks;

		if ( !isset( $mega_registered_blocks[$block_id] ))
			return false;

		$object = $mega_registered_blocks[$block_id];

		if ( !is_a( $object, 'Mega_Walker' ))
			return false;

		return $object;
	}
}