<?php

class Mega_Theme_Settings extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile' => array( 'name' => __( 'Theme Settings', 'color' ), 'description' => '' )
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_panel( 'mega_global', array( 'title' => __( 'Global', 'color' )));

			$form->add_section( 'global_settings', array( 'title' => __( 'Settings', 'color' ), 'panel' => 'mega_global' ));

			$form->add_section( 'mega_block_logo_section', array( 'title' => __( 'Logo', 'color' ), 'panel' => 'mega_global' ));

		$form->add_panel( 'mega_front', array( 'title' => __( 'Front Page', 'color' )));

			$form->add_section( 'front_settings', array( 'title' => __( 'Settings', 'color' ), 'description' => sprintf( __( '<p>To setup a custom front page, utlize the <a href="%s" target="_blank"><strong>settings > reading</strong></a> option and setup a page that has the "Front" template assigned to. Do the following steps:</p> <ol><li>Make sure you have selected a static page</li><li>Choose a page from the dropdown to act as the "Front Page"</li><li>Go to the <a href="%s" target="_blank"><strong>edit screen</strong></a> of the page which you selected previously</li><li>Locate the select box called "Template" (on the right side)</li><li>Choose "Front Page" and save the changes.</li></ol>', 'color' ), admin_url( 'options-reading.php' ), admin_url( 'edit.php?post_type=page' ) ), 'panel' => 'mega_front' ));

		$form->add_panel( 'mega_blog', array( 'title' => __( 'Blog Page', 'color' )));

			$form->add_section( 'blog_settings', array( 'title' => __( 'Settings', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_block_breadcrumbs_section', array( 'title' => __( 'Breadcrumbs', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_block_meta_section', array( 'title' => __( 'Meta', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_block_content_section', array( 'title' => __( 'Content', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_theme_block_toolbar_section', array( 'title' => __( 'Toolbar', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_block_meta_tags_section', array( 'title' => __( 'Meta Tags', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_block_paginate_section', array( 'title' => __( 'Paginate', 'color' ), 'panel' => 'mega_blog' ));

			$form->add_section( 'mega_theme_block_comments_loop_section', array( 'title' => __( 'Comments Loop', 'color' ), 'panel' => 'mega_blog' ));

		$form->add_panel( 'mega_slider', array( 'title' => __( 'Slider', 'color' )));

		$this->_global( $form );

		$this->front( $form );

		$this->blog( $form );
	}

	public function _global( $form )
	{
		$form->section = 'global_settings';

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Layout', 'color' ), 'pro' => 1, 'value' => mega_float(), 'name' => 'layout',
			'choices' => array(
				'left'			=> __( 'Left', 'color' ),
				'right'			=> __( 'Right', 'color' ),
				'fullwidth'		=> __( 'Full Width', 'color' )
			)
		));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Contact Page - Default Contact Info Text', 'color' ), 'name' => 'default_contact_info_text', 'desc' => __( 'This is the default text for the contact info block in the contact page, you can overide these by using widgets from the widgets interface.', 'color' ), 'value' => __( "Lorem ipsum dolor sit amet, id elit lorem, id morbi eu volutpat vitae mauris donec, porta nulla potenti varius tempor nec. Mollis sed vel, massa odio interdum pretium ipsum, malesuada dolor. Nunc nulla lacinia tincidunt vel, nunc proin wisi.\n\n<strong>Maecenas ullamcorper venenatis mattis.</strong>\nSed tempor augue ut arcu iaculis bibendum. Aenean nisi nunc, eleifend non mollis sed, vehicula non odio. Fusce mauris nisl, commodo id risus a, malesuada ultricies lectus.", 'color' )));

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Header', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Top Button', 'color' ), 'value' => 1, 'name' => 'show_top_button' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_top_button', 'control_value' => 'true', 'label' => __( 'Button Label', 'color' ), 'value' => __( 'Login now', 'color' ), 'name' => 'top_button_label' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_top_button', 'control_value' => 'true', 'label' => __( 'Button Link', 'color' ), 'value' => wp_login_url( home_url() ), 'name' => 'top_button_link' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Search', 'color' ), 'pro' => 1, 'value' => 1, 'name' => 'show_search' ));

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Footer', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Footer', 'color' ), 'pro' => 1, 'value' => 1, 'name' => 'show_footer' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Hook Footer (JS)', 'color' ), 'name' => 'hook_footer', 'desc' => __( 'This hook will be automatically added to the footer. It can only contain javascript code and should be wrapped around "script" tags.', 'color' ), 'sanitize' => 'mega_wp_kses_js' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Custom CSS', 'color' ), 'name' => 'custom_css', 'desc' => __( 'Add your custom CSS in this box, it will be applied to the theme. No need to wrap it inside "style" tags.', 'color' ), 'sanitize' => 'wp_strip_all_tags' ));
	}

	public function front( $form )
	{
		global $mega_package;

		$form->section = 'front_settings';

		if ( $mega_package > 0 )
			$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Front Page', 'color' ), 'pro' => 1, 'desc' => __( 'This setting will overwrite the display > reading behavior, to setup a front page, utlize the display > reading option and setup a page that has the "Front" template assigned to.', 'color' ), 'value' => 0, 'name' => 'show_front' ));

//		$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Features', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Box 1 (Features)', 'color' ), 'value' => 1, 'name' => 'show_box_1' ));

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'show_box_1', 'control_value' => 'true', 'label' => __( 'Box 1 Location', 'color' ), 'value' => array( 'template-home.php' => 1 ), 'name' => 'box_1_location', 'use_list' => 1, 'list' => 'mega_template_2_list' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_1', 'control_value' => 'true', 'label' => __( 'Title', 'color' ), 'value' => __( 'Just a few random posts', 'color' ), 'name' => 'features_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_1', 'control_value' => 'true', 'label' => __( 'Sub Title', 'color' ), 'value' => __( 'Few random posts from our blog to get you started being curious! Comment, share and subscribe if you like what you see.', 'color' ), 'name' => 'features_sub_title' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Box 2 (CTA)', 'color' ), 'value' => 1, 'pro' => 1, 'name' => 'show_box_2' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_2', 'control_value' => 'true', 'label' => __( 'Icon', 'color' ), 'value' => 'ion-bag', 'name' => 'front_cta_icon' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_2', 'control_value' => 'true', 'label' => __( 'Icon Color', 'color' ), 'value' => '#71A5F4', 'name' => 'front_cta_icon_color' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Box 3 (Features)', 'color' ), 'value' => 1, 'name' => 'show_box_3' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_3', 'control_value' => 'true', 'label' => __( 'Title', 'color' ), 'value' => __( 'Just a few random posts', 'color' ), 'name' => 'features2_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_3', 'control_value' => 'true', 'label' => __( 'Sub Title', 'color' ), 'value' => __( 'Few random posts from our blog to get you started being curious! Comment, share and subscribe if you like what you see.', 'color' ), 'name' => 'features2_sub_title' ));

//		$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Enteries', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Box 4 (Latest Enteries)', 'color' ), 'value' => 1, 'name' => 'show_box_4' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_4', 'control_value' => 'true', 'label' => __( 'Title', 'color' ), 'value' => __( 'Latest Enteries', 'color' ), 'name' => 'enteries_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'show_box_4', 'control_value' => 'true', 'label' => __( 'Sub Title', 'color' ), 'value' => __( 'Come and join us with interesting tips and tricks posted every week on our blog.', 'color' ), 'name' => 'enteries_sub_title' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Box 5 (CTA)', 'color' ), 'value' => 1, 'name' => 'show_box_5' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Box 6', 'color' ), 'value' => 1, 'name' => 'show_box_6' ));
	}

	public function blog( $form )
	{
		$form->section = 'blog_settings';

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Post Loop', 'color' )));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Pull Posts From Categories', 'color' ), 'pro' => 1, 'value' => 0, 'name' => 'cat', 'use_list' => 1, 'list' => 'mega_cat_list' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Offset Posts', 'color' ), 'desc' => __( "Enter a number to hide your newest posts, if you'll enter 2 in here, your 2 newest posts won't be shown.", 'color' ), 'pro' => 1, 'value' => 0, 'name' => 'offset', 'min' => 0 ));

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Call To Action Button', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Call To Action Button', 'color' ), 'value' => 1, 'name' => 'cta_button' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'cta_button', 'control_value' => 'true', 'label' => __( 'Button Label', 'color' ), 'value' => __( 'Register Now', 'color' ), 'name' => 'cta_button_label' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'cta_button', 'control_value' => 'true', 'label' => __( 'Button Link', 'color' ), 'value' => '#', 'name' => 'cta_button_url' ));

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'cta_button', 'control_value' => 'true', 'label' => __( 'Button Location', 'color' ), 'value' => array( 'front_page' => 1, 'template-home.php' => 1, 'category' => 1, 'archive' => 1, 'post' => 1, 'template-contact.php' => 1, 'page' => 1, 'home' => 1 ), 'name' => 'cta_button_location', 'use_list' => 1, 'list' => 'mega_template_list' ));

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Meta', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Tags', 'color' ), 'value' => 1, 'name' => 'show_tags' ));

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Pagination Links', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Pagination', 'color' ), 'value' => 1, 'name' => 'show_pagination' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'show_pagination', 'control_value' => 'true', 'label' => __( 'Above Posts', 'color' ), 'pro' => 1, 'value' => 0, 'name' => 'paginate_above_posts' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'show_pagination', 'control_value' => 'true', 'label' => __( 'Below Posts', 'color' ), 'value' => 1, 'name' => 'paginate_below_posts' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'show_pagination', 'control_value' => 'true', 'label' => __( 'Above Comments', 'color' ), 'pro' => 1, 'value' => 0, 'name' => 'paginate_above_comms' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'show_pagination', 'control_value' => 'true', 'label' => __( 'Below Comments', 'color' ), 'value' => 1, 'name' => 'paginate_below_comms' ));

		//$this->add_control( 'Mega_Form_Heading', array( 'value' => __( 'Post Comments', 'color' )));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Comments', 'color' ), 'pro' => 1, 'value' => 1, 'name' => 'show_comments' ));
	}
}