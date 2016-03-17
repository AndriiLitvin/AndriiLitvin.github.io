<?php

if ( class_exists( 'WP_Customize_Control' )) :

	class Mega_Control_Bridge_Base extends WP_Customize_Control
	{
		public function __construct( $manager, $id, $args = array() )
		{
			global $mega_package;

			foreach ( $args as $k => $v )
				$this->$k = $v;

			//if ( $mega_package === '0' )//if enabled also enable from mega_admin
				parent::__construct( $manager, $id, $args );
		}
	}

else :

	class Mega_Control_Bridge_Base
	{
		public function __construct( $manager, $id, $args = array() )
		{
			//$keys = array_keys( get_object_vars( $this ));

			$this->id = $id;

			foreach ( $args as $key => $d )
			{
				//if ( isset( $args[$key] ))
				//{
					$this->$key = $d;
				//}
			}
		}

		public function link() {}
	}

endif;



class Mega_Control_Bridge extends Mega_Control_Bridge_Base
{
	public function __construct( $form, $args = array() )
	{
		$this->form = $form;

		$block = $form->callback[0];

		$default = array(
			'show_label'	=> 1,
			'label'			=> '',
			'name'			=> '',
			'value'			=> '',
			'placeholder'	=> '',
			'desc'			=> '',
			'class'			=> $this->type,
			'required'		=> 0,
			'use_list'		=> 0,
			'list'			=> '',
			'pro'			=> 0,
			'sanitize'		=> apply_filters( 'mega_sanitize_' . $this->type, array( $this, 'sanitize' )),
			'validate'		=> array( $this, 'validate' ),
			'priority'		=> 2,
			'control_value'	=> '',
			'transport'		=> isset( $block->mega['args']['universal'] ) && $block->mega['args']['universal'] ? 'postMessage' : 'refresh'
		);

		$args = wp_parse_args( $args, $default );

		if ( !empty( $args['name'] ) && isset( $block->filter[$args['name']] ))
			$args['value'] = $block->filter[$args['name']];

		$args['class'] .= ' ' . $block->mega['args']['id_base_low'] . '_' . $args['name'];

		$this->pro_id = $block->mega['args']['id_base_low'] . '_' . $args['name'];

		$form->add_setting( MEGA_DB_ID . '[' . $block->mega['args']['id_base_low'] . '][' . $args['name'] . ']', array(
			'sanitize_callback'		=> $args['sanitize'],
			'default'				=> $args['value'],
			'type'					=> 'option',
			'transport'				=> $args['transport']
		));

		if ( $args['use_list'] && !empty( $args['list'] ))
			$args['choices'] = apply_filters( $args['list'], array() );

		$this->set_id = MEGA_DB_ID . '[' . $block->mega['args']['id_base_low'] . '][' . $args['name'] . ']';

		if ( isset( $form->callback[1] ))
			call_user_func_array( $form->callback, array( &$args ));

		$this->block_id = $block->mega['args']['id_base_low'];

		if ( isset( $args['control'] ))
			$this->control = $block->mega['args']['id_base_low'] . '_' . $args['control'];

		$args = wp_parse_args( $args, array(
			'section'		=> $block->mega['args']['id_base_low'] . '_section',
			'settings'		=> MEGA_DB_ID . '[' . $block->mega['args']['id_base_low'] . '][' . $args['name'] . ']',
			//$block->mega['args']['id_base_low'] . '_' . $args['name'],
		));

		parent::__construct( $form, $block->mega['args']['id_base_low'] . '_' . $args['name'], $args );
	}

	public function lock( $status )
	{
		global $mega_package;

		echo $mega_package === '0' && $status ? ' data-lock="true" ' : '';
	}

	public function showLock( $status, $type = '' )
	{
		global $mega_package;

		echo $mega_package === '0' && $status ? '<a target="_blank" href="' . $this->upgradeURL('setting', $type ) . '" class="lock"></a>' : '';//lock
	}

	public function upgradeURL( $medium = '', $type = '' )
	{
		$screen = get_current_screen();

if ( isset( $screen->id ))
	$sc_id = $screen->id;
else
	$sc_id = 'widgets';

if ( $type === 'widget' && $sc_id === 'customize' )
	$sc_id = $sc_id . '_widgets';

	return wp_get_theme()->get( 'ThemeURI' ) . '?utm_source=' . wp_get_theme()->get( 'Name' ) . '&utm_medium=' . $sc_id . '_' . $medium . '&utm_content=' . $this->pro_id . '&utm_campaign=upgrade';

		//return wp_get_theme()->get( 'ThemeURI' ) . '?utm_source=' . wp_get_theme()->get( 'Name' ) . '&utm_medium=lock&utm_campaign=upgrade';
	}

	public function link( $setting_key = 'default' )
	{
		if ( !empty( $this->class ))
			echo ' class="' . $this->class . '" ';

		if ( !empty( $this->placeholder ))
			echo ' placeholder="' . $this->placeholder . '" ';

		$this->lock( $this->pro );

		parent::link();
	}

	public function widget()
	{
		echo '<div class="mega_widget_admin ' . $this->type . '' . ( $this->pro ? ' pro' : '' ) . '" data-set-id="' . $this->set_id . '" data-control="' . $this->_id . '" ' . ( !empty( $this->control ) ? 'data-p-control="' . $this->control . '" data-p-control-v="' . $this->control_value . '"' : '' ) . '>';

$this->showLock( $this->pro, 'widget' );

		$label = '<label class="customize-control-title" data-type="' . $this->type . '" for="' . $this->id . '">' . $this->label . '</label>';

		//if ( $this->type !== 'mega_form_onoff' )
			echo $label;

		if ( !empty( $this->desc ))
			echo '<div class="description customize-control-description">' . $this->desc . '</div>';//was span

		

		$this->control( $this->name, $this->value );

		//if ( $this->type === 'mega_form_onoff' )
			//echo $label;

		echo '</div>';
	}

	public function callback()
	{
		echo '<div class="mega_block_form_field_wrapper' . ( $this->pro ? ' pro' : '' ) . '">';

		if ( $this->show_label && !empty( $this->label ))
			echo '<label for="' . $this->id . '">' . $this->label . '</label>';

		if ( !empty( $this->desc ))
			echo '<a rel="help" title="' . $this->label . '" data-content="' . esc_html( $this->desc ) . '">?</a>';

		if ( $this->type === 'textarea' )
			$this->showLock( $this->pro );

		$this->control( $this->name, $this->value );//$this->value()

		if ( $this->type !== 'textarea' )
			$this->showLock( $this->pro );

		$this->form->loop( array( $this, 'asd') );

		echo '</div>';
	}

	public function render_content()
	{
		echo '<div class="mega_block_form_field_wrapper' . ( $this->pro ? ' pro' : '' ) . '" data-control="' . $this->id . '" ' . ( !empty( $this->control ) ? 'data-p-control="' . $this->block_id . '_' . $this->control . '" data-p-control-v="' . $this->control_value . '"' : '' ) . '>';

		$this->showLock( $this->pro );

		if ( !empty( $this->label ))
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';

		if ( !empty( $this->desc ))
			echo '<span class="description customize-control-description">' . $this->desc . '</span>';

		$this->control( '_customize-' . $this->type . '-' . $this->id, $this->value() );

		echo '</div>';
	}

	public function sanitize( $value )
	{
		return $value;
	}

	public function validate( $value, $mega_error )//validateCallback
	{
		if ( $this->required && empty( $value ))
		{
			$mega_error->add_error( $this->id, sprintf( __( '%s cannot be empty! Please enter a valid value.', 'mega' ), !empty( $this->label ) ? $this->label : $this->name ));//filter?

			return false;
		}

		return $this->validateSingle( $value, $mega_error ) ? true : false;
	}

	public function validateSingle( $value, $mega_error )
	{
		return true;
	}

	public function choicesIterator( $choices, $name, $selected, $depth = 0, $echo = true )//no echo at all?
	{
		if ( $echo )
			$this->choicesIteratorBefore( $depth, $name );

		foreach ( $choices as $key => $option )
		{
			$id		= is_array( $option ) ? $option['id'] : $key;
			$label	= is_array( $option ) ? $option['label'] : $option;

			if ( $echo )
				$this->choicesIteratorSingle( $id, $label, $name, $selected, $depth );
			else if ( $r = $this->choicesIteratorCompare( $id, $selected ))
				return $r;

			if ( isset( $option['children'] ) && is_array( $option['children'] ) && count( $option['children'] ) > 0 )
			{
				if ( $echo )
					$this->choicesIterator( $option['children'], $name, $selected, $depth + 1, $echo );
				else if ( $r = $this->choicesIterator( $option['children'], $name, $selected, $depth + 1, $echo ))
					return $r;
			}
		}

		if ( $echo )
			$this->choicesIteratorAfter( $depth );
		else
			return '';
	}
}

class Mega_Control_Checklist extends Mega_Control_Bridge
{
	public $type = 'checklist';

	public function render_content()
	{
		if ( empty( $this->choices ))
			return;

		parent::render_content();
	}

	public function enqueue()
	{
		//wp_enqueue_script( 'mega.jquery.control.checklist', MEGA_DIR_URI . '/assets/js/mega.jquery.control.checklist.js', array( 'jquery' ));
	}

	public function control( $name, $value )
	{
		$this->choicesIterator( $this->choices, $name, $value );

		echo '<input type="hidden" '; $this->link(); echo ' name="' . esc_attr( $name ) . '" value="' . esc_attr( json_encode( $value )) . '" />';
	}

	public function choicesIteratorBefore()
	{
		echo '<ul class="mega_cl">';
	}

	public function choicesIteratorAfter()
	{
		echo '</ul>';
	}

	public function choicesIteratorSingle( $key, $label, $name, $selected, $depth )
	{
		echo '<li class="cf">';

		echo '<label>';
//$selected = array();
			//echo '<input type="hidden" value="0" name="' . esc_attr( $name . '[' . $key . ']' ) . '" />';

			echo '<input data-key="' . $key . '" type="checkbox" value="1" name="' . esc_attr( $name . '[' . $key . ']' ) . '" ' . checked( isset( $selected[$key] ) ? $selected[$key] : 0, 1, 0 ) . ' />';

			echo esc_html( $label ) . '<br />';

		echo '</label>';

		echo '</li>';
	}

	public function sanitize( $value )
	{
		if ( !is_array( $value ))
			$value = json_decode( html_entity_decode( $value ), true );

		$this->clean = array();

		$this->choicesIterator( $this->choices, '', $value, 0, 0 );

		return $this->clean;
	}

	public function choicesIteratorCompare( $id, $selected )
	{
		$this->clean[$id] = isset( $selected[$id] ) && ( $selected[$id] === 1 OR $selected[$id] === '1' ) ? 1 : 0;

		//return $clean;
	}
}

class Mega_Control_Checkbox extends Mega_Control_Bridge
{
	public $type = 'checkbox';

	public function control( $name, $value )
	{
		global $mega_package;

		echo '<input type="hidden" value="' . ( $mega_package === '0' && $this->pro && $value == 1 ? 1 : 0 ) . '" name="' . esc_attr( $name ) . '" />';

		echo '<input type="checkbox" id="' . $this->id . '" value="1" name="' . esc_attr( $name ) . '" ' . checked( $value, 1, 0 ); $this->link(); echo ' />';
	}

	public function sanitize( $value )
	{
		return isset( $value ) && $value == 1 ? 1 : 0;
	}
}

class Mega_Control_onOff extends Mega_Control_Checkbox
{
	public $type = 'mega_form_onoff';
}

class Mega_Control_WP_Select_Cats extends Mega_Control_Bridge
{
	public $type = 'wp_select_cats';

	public function control( $name, $value )
	{
		wp_dropdown_categories( array(
			'show_option_all'	=> __( 'All', 'mega' ),
			'hierarchical'		=> 1,
			'orderby'			=> 'count',
			'order'				=> 'DESC',
			'show_count'		=> 1,
			'name'				=> $name,
			'id'				=> $this->id,
			'class'				=> $this->class,
			'selected'			=> $value
		));
	}
}

class Mega_Control_WP_Select_Pages extends Mega_Control_Bridge
{
	public $type = 'wp_select_pages';

	public function control( $name, $value )
	{
		wp_dropdown_pages( array(
			'show_option_none'		=> __( 'All', 'mega' ),
			'option_none_value'		=> 0,
			'name'					=> $name,
			'id'					=> $this->id,
			'selected'				=> $value
		));
	}
}

class Mega_Control_Text extends Mega_Control_Bridge
{
	public $type = 'mega_block_form_text';

	public function control( $name, $value )
	{
		echo '<input type="text" id="' . $this->id . '" value="' . $value . '" name="' . esc_attr( $name ) . '" '; $this->link(); echo ' />';
	}

	public function sanitize( $value )
	{
		return wp_kses_data( $value );
	}
}

class Mega_Control_Email extends Mega_Control_Bridge
{
	public $type = 'mega_control_email';

	public function control( $name, $value )
	{
		echo '<input type="email" id="' . $this->id . '" value="' . $value . '" name="' . esc_attr( $name ) . '" '; $this->link(); echo ' />';
	}

	public function sanitize( $value )
	{
		return sanitize_email( $value );
	}

	public function validateSingle( $value, $mega_error )
	{
		if ( is_email( $value ))
			return true;

		$mega_error->add_error( $this->id, __( 'Email address is invalid.', 'mega' ));

		return false;
	}
}

class Mega_Control_Number extends Mega_Control_Bridge
{
	public $type = 'mega_block_form_number';

	public function control( $name, $value )
	{
		echo '<input type="number" id="' . $this->id . '" value="' . $value . '" name="' . esc_attr( $name ) . '" '; $this->link(); echo ' />';
	}

	public function sanitize( $value )
	{
		return intval( $value );
	}

	public function validateSingle( $value, $mega_error )
	{
		if ( is_numeric( intval( $value )))
			return true;

		$mega_error->add_error( $this->id, __( 'Expecting a Numeric value!', 'mega' ));

		return false;
	}
}

class Mega_Control_Textarea extends Mega_Control_Bridge
{
	public $type = 'textarea';

	public function control( $name, $value )
	{
		echo '<textarea rows="8" id="' . $this->id . '" name="' . esc_attr( $name ) . '" '; $this->link(); echo '>' . esc_html( $value ) . '</textarea>';
	}

	public function sanitize( $value )
	{
		return wp_kses_data( $value );
	}
}

class Mega_Control_WP_Editor extends Mega_Control_Bridge
{
	public $type = 'wp_editor';

	public function __construct( $form, $args = array() )
	{
		if ( class_exists( 'WP_Customize_Control' ))
			$this->type = 'textarea';

		parent::__construct( $form, $args );
	}

	public function control( $name, $value )
	{
		if ( class_exists( 'WP_Customize_Control' ))
		{
			echo '<textarea rows="8" id="' . $this->id . '" name="' . esc_attr( $name ) . '" '; $this->link(); echo '>' . esc_html( $value ) . '</textarea>';
			//Mega_Control_Textarea::control( $name, $value );
		}
		else
			wp_editor( $value, $this->id, array( 'textarea_name' => $name, 'editor_class' => '', 'tinymce' => 0, 'media_buttons' => false ));
	}

	public function sanitize( $value )
	{
		return wp_kses_post( $value );
	}
}

class Mega_Control_Select extends Mega_Control_Bridge
{
	public $type = 'select';

	public function control( $name, $value )
	{
		$this->choicesIterator( $this->choices, $name, $value );
	}

	public function choicesIteratorBefore( $depth, $name )//'<optgroup label="' . $option . '">';
	{
		if ( $depth === 0 )
		{
			echo '<select id="' . $this->id . '" name="' . esc_attr( $name ) . '" '; $this->link(); echo '>';
		}
	}

	public function choicesIteratorAfter( $depth )
	{
		if ( $depth === 0 )
			echo '</select>';
	}

	public function choicesIteratorSingle( $key, $label, $name, $selected, $depth )
	{
		echo '<option value="' . $key . '"' . selected( $selected, $key, 0 ) . '>' . str_repeat( "&nbsp;", $depth * 3 ) . $label . '</option>';
	}

	public function sanitize( $value )
	{
		$this->clean = '';

		$this->choicesIterator( $this->choices, '', $value, 0, 0 );

		return $this->clean;
	}

	public function choicesIteratorCompare( $id, $selected )
	{
		if ( isset( $selected ) && $selected === $id )
		{
			$this->clean = $id;

			return true;
		}

		//$this->clean = isset( $selected ) && $selected === $id ? $id : '';
	}
}

class Mega_Control_Submit extends Mega_Control_Bridge
{
	public $type = 'mega_control_submit';

	public function control( $name, $value )
	{
		echo '<input type="submit" id="' . $this->id . '" value="' . $value . '" '; $this->link(); echo ' />';
	}
}












class Mega_Forms
{
	public function Mega_Form_Heading()
	{
		echo mega_html( '<h2>', '</h2>', $this->mega['settings']['value'] );
	}
}