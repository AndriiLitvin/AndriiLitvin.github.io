<?php

class Mega_Block_WP_Widget_Bridge extends WP_Widget
{
	public function form( $instance )
	{
		global $mega_package;

		if ( $mega_package === '0' && $this->mega['args']['pro'] )
		{
			printf( __( '[Pro] Use <a href="%s">theme options panel</a> to configure this widget. Upgrade the theme to have the settings appear here as well.', 'mega' ), admin_url( 'customize.php' ));

			return 'noform';
		}

		$this->mega['settings'] = wp_parse_args( $instance, $this->mega['settings'] );

		$this->settings( new Mega_Form_Manager( array( 'type' => 'widget', 'callback' => array( $this, '_setFormData' ))));
	}

	public function parseWidgetSettings( $number )
	{
		global $wp_widget_factory;

		$options = get_option( $wp_widget_factory->widgets[$this->mega['args']['id_base']]->option_name );

		if ( isset( $options[$number] ))
			$this->mega['settings'] = wp_parse_args( $options[$number], $this->mega['settings'] );//_defaults
	}

	public function _setFormData( &$args )
	{
		if ( isset( $this->mega['settings'][$args['name']] ))
			$args['value'] = $this->mega['settings'][$args['name']];

		$args['id']		= $this->get_field_id( $args['name'] );
		$args['_id']	= $args['id'];

		if ( !empty( $args['control'] ))
			$args['control'] = $this->get_field_id( $args['control'] );

		$args['name']	= $this->get_field_name( $args['name'] );
		$args['class'] .= ' widefat ';
	}

	public function widget( $args, $instance )
	{
		$this->mega['settings']				= wp_parse_args( $instance, $this->mega['settings'] );
		$this->mega['args']['before']		= $args['before_widget'];
		$this->mega['args']['after']		= $args['after_widget'];
		$this->mega['args']['beforeTitle']	= $args['before_title'];
		$this->mega['args']['afterTitle']	= $args['after_title'];

		$this->callback();
	}

	public function update( $new, $old )
	{
		foreach( $new as $key => $value )
		{
			$new[$key] = call_user_func( $this->mega['settings_sanitize'][$key]['callback'], $value );
		}

		return wp_parse_args( $new, $this->mega['settings_defaults'] );
	}
}