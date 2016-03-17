<?php

class Mega_Block_Feature_Auto extends Mega_Block_Feature_Skeleton
{
	public function __construct()
	{
		parent::__construct( __CLASS__, array(
			'profile' => array( 'name' => __( 'Feature: Auto', 'mega' ), 'description' => __( 'Feature: Auto', 'mega' ))
		));
	}

	public function settings( $form )
	{
		parent::settings( $form );

		$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'image', 'control_value' => 'true', 'label' => __( 'Image Sources', 'mega' ), 'value' => array( 'featured' => 1, 'first' => 1, 'ph' => 1 ), 'name' => 'sources',
			'choices' => array(
				'featured'	=> __( 'Featured', 'mega' ),
				'first'		=> __( 'First', 'mega' ),
				'ph'		=> __( 'Placeholder', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Pages, Posts or Category Posts', 'mega' ), 'value' => 'posts', 'name' => 'type',
			'choices' => array(
				'cats'	=> __( 'Category Posts', 'mega' ),
				'posts'	=> __( 'Posts', 'mega' ),
				'pages'	=> __( 'Pages', 'mega' )
			)
		));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'type', 'control_value' => 'cats', 'label' => __( 'Number of Results', 'mega' ), 'value' => 1, 'name' => 'count' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'type', 'control_value' => 'cats', 'label' => __( 'Select a Category', 'mega' ), 'name' => 'cat', 'use_list' => 1, 'list' => 'mega_cat_list' ));

		//$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'type', 'control_value' => 'pages', 'label' => __( 'Random Page', 'mega' ), 'value' => 1, 'name' => 'rand_pages' ));//need 2 fix

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'type', 'control_value' => 'pages', 'label' => __( 'Select Pages', 'mega' ), 'value' => array( 0 => 1 ), 'name' => 'pages', 'use_list' => 1, 'list' => 'mega_page_list' ));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'type', 'control_value' => 'posts', 'label' => __( 'Random Post', 'mega' ), 'value' => 1, 'name' => 'rand_posts' ));

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'rand_posts', 'control_value' => 'false', 'label' => __( 'Select Posts', 'mega' ), 'value' => array( 0 => 1 ), 'name' => 'posts', 'use_list' => 1, 'list' => 'mega_post_list' ));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Order By', 'mega' ), 'value' => 'date', 'name' => 'order',
			'choices' => array(
				'date'			=> __( 'Date', 'mega' ),
				'rand'			=> __( 'Random', 'mega' ),
				'comment_count' => __( 'Comment Count', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Excerpt Character Count', 'mega' ), 'value' => 80, 'name' => 'excerpt_count' ));//110

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Title', 'mega' ), 'value' => 1, 'name' => 'show_title' ));

			$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'show_title', 'control_value' => 'true', 'label' => __( 'Title Character Count', 'mega' ), 'value' => 35, 'name' => 'title_count' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Link', 'mega' ), 'value' => 1, 'name' => 'show_link' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'show_link', 'control_value' => 'true', 'label' => __( 'Show Button', 'mega' ), 'value' => 0, 'name' => 'show_button' ));

				$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_button', 'control_value' => 'true', 'label' => __( 'Button Label', 'mega' ), 'value' => __( 'Continue reading', 'mega' ), 'name' => 'button_label' ));
	}

	public function callback()
	{
		extract( $this->mega['settings'] );

		if ( $type === 'pages' || $type === 'posts' )
		{
			$query['post_type'] = $type === 'pages' ? 'page' : 'post';

			if ( ${'rand_' . $type} && $pretty_post = mega_get_pretty_post( $excerpt_count ))
			{
				$query['post__in'][]		= $pretty_post;
				$query['posts_per_page']	= 1;
			}
			else
				$query['post__in'] = in_array( 0, array_keys( $$type, 1 )) ? 0 : array_keys( $$type, 1 );//$$type == array(0)
		}
		elseif ( $type === 'cats' )
			$query = array(
				'posts_per_page'	=> $count,
				'cat'				=> $cat,
				'post_type'			=> 'post'
			);

		$query = new WP_Query( wp_parse_args( $query, array(
			'orderby'				=> $order,
			'ignore_sticky_posts'	=> 1
		)));

		while ( $query->have_posts() ) : $query->the_post();

		echo $this->before();

		if ( $image )
			mega_thumb( array( 'width' => $width . '%', 'maxheight' => $max_height . 'px', 'sources' => $sources ));

		$this->getIcon();

		if ( $show_title )
		{
			$this->autoTagTitle( $show_link ? get_permalink() : '', mega_clean_words( $title_count, get_the_title() ));

			$this->getTitle();
		}

		$this->block();

		echo $this->after();

		endwhile; wp_reset_postdata();
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		mega_html( esc_html( mega_clean_words( $excerpt_count, get_the_excerpt() )), '<div class="text">', '</div>' );

		if ( $show_link && $show_button )
			echo mega_auto_tag( 'a', array( 'text' => '<i class="icon"></i><span>' . esc_html( $button_label ) . '</span>', 'attr' => array( 'href' => get_permalink(), 'class' => 'button' )));
	}
}