<?php

class Mega_Block_Tabs extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Tabs', 'mega' ), 'description' => __( 'Tabs Block', 'mega' )),
			'universal'	=> true,
			'pro'		=> true
		);

		parent::__construct( __CLASS__, $args );

		add_filter( 'mega_form_select_lists', array( $this, 'addList' ));
		add_filter( 'mega_tabs_widget_list', array( $this, 'doList' ));
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Tab 1', 'mega' ), 'value' => 1, 'name' => 'tab_1' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'tab_1', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'value' => __( 'Comments', 'mega' ), 'name' => 'title_1' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'tab_1', 'control_value' => 'true', 'label' => __( 'Widget', 'mega' ), 'pro' => 1, 'value' => 'Mega_Block_Comments', 'name' => 'widget_1', 'use_list' => 1, 'list' => 'mega_tabs_widget_list' ));


		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Tab 2', 'mega' ), 'value' => 1, 'name' => 'tab_2' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'tab_2', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'value' => __( 'Posts', 'mega' ), 'name' => 'title_2' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'tab_2', 'control_value' => 'true', 'label' => __( 'Widget', 'mega' ), 'pro' => 1, 'value' => 'Mega_Block_Posts', 'name' => 'widget_2', 'use_list' => 1, 'list' => 'mega_tabs_widget_list' ));


		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Tab 3', 'mega' ), 'pro' => 1, 'value' => 0, 'name' => 'tab_3' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'tab_3', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'value' => '', 'name' => 'title_3' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'tab_3', 'control_value' => 'true', 'label' => __( 'Widget', 'mega' ), 'pro' => 1, 'value' => '', 'name' => 'widget_3', 'use_list' => 1, 'list' => 'mega_tabs_widget_list' ));


		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Tab 4', 'mega' ), 'pro' => 1, 'value' => 0, 'name' => 'tab_4' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'tab_4', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'value' => '', 'name' => 'title_4' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'tab_4', 'control_value' => 'true', 'label' => __( 'Widget', 'mega' ), 'pro' => 1, 'value' => '', 'name' => 'widget_4', 'use_list' => 1, 'list' => 'mega_tabs_widget_list' ));
	}

	public function addList( $lists )
	{
		$lists['mega_tabs_widget_list'] = __( 'Tabs Widgets List', 'mega' );

		return $lists;
	}

	public function doList()
	{
		global $mega_registered_blocks, $mega_universal_blocks;

		foreach( $mega_universal_blocks as $k => $v )
		{
			if ( $v !== $this->mega['args']['id_base'] )
				$data[$v] = $mega_registered_blocks[$v]->mega['args']['profile']['name'];
		}

		return $data;
	}

	public function hookOnce()
	{
		add_action( is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts', array( &$this, 'enqueue' ));
	}

	public function enqueue()
	{
		wp_enqueue_script( 'jquery-ui-tabs' );
	}

	public function hook()
	{
		add_action( is_admin() ? 'admin_head' : 'wp_head', array( &$this, 'head' ));
	}

	public function head()
	{
		echo

		'<script type="text/javascript">',
			"jQuery(document).ready(function($) {",
				"$('.mega_block_tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' }});",
			'});',
		'</script>';
	}

	public function block()
	{
		echo '<div class="widgetv %2$s">';

		echo '<ul id="tab-items" class="%2$s ui-tabs cf">';

		$this->getTabs();

		echo '</ul>';

		echo '<div class="tabs-inner">';

		$this->getContent();

		echo '</div>';

		echo '</div>';
	}

	public function getTabs()
	{
		extract( $this->mega['settings'] );

		foreach( range( 1, 4 ) as $k => $v )
		{
			if ( ${'tab_' . $v} )
			{
				echo '<li><a href="#tab-' . $v . '"><i></i><span>';

				echo esc_html( ${'title_' . $v} );

				echo '</span></a></li>';
			}
		}
	}

	public function getContent()
	{
		global $mega_registered_blocks;

		extract( $this->mega['settings'] );

		foreach( range( 1, 4 ) as $k => $v )
		{
			if ( ${'tab_' . $v} )
			{
				$c = '';

				if ( isset( $mega_registered_blocks[${'widget_' . $v}]->mega['args']['id_base_low'] ))
					$c = $mega_registered_blocks[${'widget_' . $v}]->mega['args']['id_base_low'];

				echo '<div id="tab-' . $v . '" class="tab widgetv ' . $c . '">';

				if ( $this->getBlockObject( ${'widget_' . $v} ))
					$mega_registered_blocks[${'widget_' . $v}]->callback();

				echo '</div>';
			}
		}
	}
}