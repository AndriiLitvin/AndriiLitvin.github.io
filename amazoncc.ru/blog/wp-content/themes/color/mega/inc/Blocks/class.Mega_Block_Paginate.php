<?php

class Mega_Block_Paginate extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Paginate', 'mega' ), 'description' => __( 'Paginate Block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s">',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show All', 'mega' ), 'value' => 0, 'name' => 'show_all' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'show_all', 'control_value' => 'false', 'label' => __( 'Edge Size', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'end_size' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'show_all', 'control_value' => 'false', 'label' => __( 'Middle Size', 'mega' ), 'value' => 2, 'name' => 'mid_size' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Previous / Next', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'prev_next' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'prev_next', 'control_value' => 'true', 'label' => __( 'Previous', 'mega' ), 'value' => __( 'Previous', 'mega' ), 'name' => 'prev_text' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'prev_next', 'control_value' => 'true', 'label' => __( 'Next', 'mega' ), 'value' => __( 'Next', 'mega' ), 'name' => 'next_text' ));
	}

	public function callback()
	{
		$this->mega['settings']['prev_text'] = '<i></i>' . esc_html( $this->mega['settings']['prev_text'] );
		$this->mega['settings']['next_text'] .= '<i></i>';

		if ( is_singular() )
		{
			$args = array(
				'echo' => false
			);

			$paginate = paginate_comments_links( wp_parse_args( $args, $this->mega['settings'] ));
		}
		else
		{
			global $wp_query;

			$args = array(
				'base'		=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 )),
				'current'	=> max( 1, get_query_var( 'paged' )),
				'total'		=> $wp_query->max_num_pages
			);

			$paginate = paginate_links( wp_parse_args( $args, $this->mega['settings'] ));
		}

		mega_html( $paginate, $this->before(), $this->after() );
	}
}