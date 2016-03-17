<?php

class Mega_Form_Manager
{
	public $type;

	public $callback;

	public function __construct( $args = array() )
	{
		if ( isset( $args['type'] ))
			$this->type = $args['type'];

		if ( isset( $args['callback'] ))
			$this->callback = $args['callback'];

		if ( isset( $args['wp_customize'] ))
			$this->wp_customize = $args['wp_customize'];
	}

	public function add_panel( $id, $args )
	{
		if ( isset( $this->wp_customize ))
		{
			$args = wp_parse_args( $args, array(
				'priority'			=> 30,
				'capability'		=> 'edit_theme_options',
				'theme_supports'	=> ''
			));

			$this->wp_customize->add_panel( $id, $args );
		}
		else
		{
			$this->panels[$id] = $args;

			$this->panels[$id]['href'] = '#' . $id;
		}
	}

	public function add_section( $id, $args )
	{
		if ( isset( $this->wp_customize ))
		{
			$args = wp_parse_args( $args, array(
				'priority' => 30
			));

			$this->wp_customize->add_section( $id, $args );
		}
		else
			$this->sections[$id] = $args;
	}

	public function add_control( $id_base, $args = array() )
	{
		if ( isset( $this->section ))
			$args['section'] = $this->section;

		if ( isset( $this->wp_customize ))
		{
			$this->wp_customize->add_control( new $id_base( $this->wp_customize, $args ));

			return;
		}

		$control = new $id_base( $this, $args );

		if ( $this->type === 'widget' )
			$control->widget();
		else if ( $this->type === 'echo' )
			$control->callback();
		else if ( $this->type === 'tabs' )
			$this->controls[$control->section][] = array( $control, 'callback' );
	}

	public function add_sub_control( $id_base, $args )
	{
		if ( $this->type === 'tabs' )
		{
			$control = new $id_base( $this, $args );

			$this->sub_controls[$control->control][$control->control_value][] = array( $control, 'callback' );
		}
		else
			$this->add_control( $id_base, $args );
	}

	public function add_setting( $id, $args )
	{
		$this->settings[$id] = $args;
	}

	public function get_setting() {}

	public function buildTabs()
	{
		foreach( $this->panels as $id => $args )
			echo '<li><a href="' . $args['href'] . '">' . $args['title'] . '</a></li>';
	}

	public function buildSubTabs( $panel )
	{
		foreach( $this->sections as $id => $args )
			if ( $args['panel'] === $panel )
				echo '<li><a href="#' . $id . '"><span>' . $args['title'] . '</span></a></li>';
	}

	public function buildContent( $content_id = '' )
	{
		foreach( $this->panels as $id => $args )
		{
			if ( !empty( $content_id ) && isset( $this->panels[$content_id] ) && $content_id !== $id )
				continue;

			echo '<div id="' . $id . '" class="mega-main1" style="float: left; width: calc(100%); max-width: 800px;">';

				if ( isset( $args['callback'] ))
				{
					call_user_func( $args['callback'] );
				}
				else
				{
					echo '<div class="template-nav">';

					echo '<ul>';

					$this->buildSubTabs( $id );

					echo '</ul>';

					echo '</div>';

					echo '<div class="mega-main block-settings">';

					foreach( $this->sections as $k => $args )
					{
						if ( $args['panel'] === $id )
						{
							echo '<div id="' . $k . '">';

							foreach( $this->controls[$k] as $callback )
							{
								call_user_func( $callback );
								//$this->loop( $callback );
							}

							echo '</div>';
						}
					}

					echo '</div>';
				}

			echo '</div>';
		}
	}

	public function loop( $callback = '' )
	{
		//echo '<div class="mega_block_form_field_wrapper' . ( $callback[0]->pro ? ' pro' : '' ) . '">';

			//call_user_func( $callback );

			if ( isset( $this->sub_controls[$callback[0]->id] ))
			{
				foreach( $this->sub_controls[$callback[0]->id] as $value => $controls )
				{
					foreach( $controls as $callback )
					{
						echo '<div class="cf sub-options sub-options-' . $value . '">';

						call_user_func( $callback );
						//$this->loop( $callback );

						echo '</div>';
					}
				}
			}

		//echo '</div>';
	}
}