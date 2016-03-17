<?php

class Mega_Block_Slider_Jssor extends Mega_Walker
{
	public function __construct( $class = __CLASS__ )
	{
		$args = array(
			'profile'		=> array( 'name' => __( 'Jssor Slider', 'mega' ), 'description' => __( 'Jssor Slider block', 'mega' )),
			'before'		=> '<div id="%1$s" class="slider %3$s %2$s" %4$s>',
			'after'			=> '</div>'
		);

		//$this->tem_id = 'slider_builder';

		//$this->sub_tem_type = true;

		parent::__construct( $class, $args );

		$this->jssor_animations = array(
			'fade_twins' => array( 'name' => 'Fade Twins', 'code' => '{ $Duration: 700, $Opacity: 2, $Brother: { $Duration: 1000, $Opacity: 2 }}' ),

			'switch' => array( 'name' => 'Switch', 'code' => '{ $Duration: 1400, $Zoom: 1.5, $FlyDirection: 1, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Zoom: $JssorEasing$.$EaseInSine }, $ScaleHorizontal: 0.25, $Opacity: 2, $ZIndex: -10, $Brother: { $Duration: 1400, $Zoom: 1.5, $FlyDirection: 2, $Easing: { $Left: $JssorEasing$.$EaseInWave, $Zoom: $JssorEasing$.$EaseInSine }, $ScaleHorizontal: 0.25, $Opacity: 2, $ZIndex: -10 } }' ),

			'doors' => array( 'name' => 'Doors', 'code' => '{ $Duration: 1500, $Cols: 2, $FlyDirection: 1, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInOutCubic }, $ScaleHorizontal: 0.5, $Opacity: 2, $Brother: { $Duration: 1500, $Opacity: 2 } }' ),

			'rotate_axis_up_overlap' => array( 'name' => 'Rotate Axis up overlap', 'code' => '{ $Duration: 1200, $Rotate: -0.1, $FlyDirection: 5, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $ScaleHorizontal: 0.25, $ScaleVertical: 0.5, $Opacity: 2, $Brother: { $Duration: 1200, $Rotate: 0.1, $FlyDirection: 10, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $ScaleHorizontal: 0.1, $ScaleVertical: 0.7, $Opacity: 2 } }' ),

			'chess_replace_tb' => array( 'name' => 'Chess Replace TB', 'code' => '{ $Duration: 1600, $Rows: 2, $FlyDirection: 1, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1600, $Rows: 2, $FlyDirection: 2, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } }' ),

			'chess_replace_lr' => array( 'name' => 'Chess Replace LR', 'code' => '{ $Duration: 1600, $Cols: 2, $FlyDirection: 8, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1600, $Cols: 2, $FlyDirection: 4, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } }' ),

			'shift_tb' => array( 'name' => 'Shift TB', 'code' => '{ $Duration: 1200, $FlyDirection: 4, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1200, $FlyDirection: 8, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } }' ),

			'shift_lr' => array( 'name' => 'Shift LR', 'code' => '{ $Duration: 1200, $FlyDirection: 1, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Brother: { $Duration: 1200, $FlyDirection: 2, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 } }' ),

			'return_lr' => array( 'name' => 'Return LR', 'code' => '{ $Duration: 1200, $Delay: 40, $Cols: 6, $FlyDirection: 1, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: { $Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $ZIndex: -10, $Brother: { $Duration: 1200, $Delay: 40, $Cols: 6, $FlyDirection: 1, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Easing: { $Top: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $ZIndex: -10, $Shift: -100 } }' ),

			'rotate_axis_down' => array( 'name' => 'Rotate Axis down', 'code' => '{ $Duration: 1500, $Rotate: 0.1, $During: { $Left: [0.6, 0.4], $Top: [0.6, 0.4], $Rotate: [0.6, 0.4] }, $FlyDirection: 10, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $ScaleHorizontal: 0.1, $ScaleVertical: 0.7, $Opacity: 2, $Brother: { $Duration: 1000, $Rotate: -0.1, $FlyDirection: 5, $Easing: { $Left: $JssorEasing$.$EaseInQuad, $Top: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $ScaleHorizontal: 0.2, $ScaleVertical: 0.5, $Opacity: 2 } }' ),

			'horizontal_fade_stripe' => array( 'name' => 'Horizontal Fade Stripe', 'code' => '{$Duration:600,$Delay:100,$Rows:7,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Opacity:2}' ),

			'vertical_fade_stripe' => array( 'name' => 'Vertical Fade Stripe', 'code' => '{$Duration:600,$Delay:100,$Cols:10,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Opacity:2}' ),

			'vertical_fly_stripe' => array( 'name' => 'Vertical Fly Stripe', 'code' => '{$Duration:800,$Delay:80,$Cols:12,$FlyDirection:4,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:513,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}' ),

			'rotate_vdouble+_in' => array( 'name' => 'Rotate VDouble+ in', 'code' => '{$Duration:1200,$Rows:2,$Zoom:11,$Rotate:true,$FlyDirection:6,$Assembly:2049,$ChessMode:{$Row:15},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad,$Rotate:$JssorEasing$.$EaseInCubic},$ScaleHorizontal:1,$ScaleVertical:2,$Opacity:2,$Round:{$Rotate:0.8}}' ),

			'rotate_zoom+_in' => array( 'name' => 'Rotate Zoom+ in', 'code' => '{$Duration:1200,$Zoom:11,$Rotate:true,$Easing:{$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad,$Rotate:$JssorEasing$.$EaseInCubic},$Opacity:2,$Round:{$Rotate:0.7}}' ),

			'rotate_zoom+_in_l' => array( 'name' => 'Rotate Zoom+ in L', 'code' => '{$Duration:1200,$Zoom:11,$Rotate:true,$FlyDirection:1,$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad,$Rotate:$JssorEasing$.$EaseInCubic},$ScaleHorizontal:4,$Opacity:2,$Round:{$Rotate:0.7}}' ),

			'parabola_stairs_in' => array( 'name' => 'Parabola Stairs in', 'code' => '{$Duration:600,$Delay:30,$Cols:8,$Rows:4,$FlyDirection:6,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInQuart,$Top:$JssorEasing$.$EaseInQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}' ),

			'parabola_stairs_out' => array( 'name' => 'Parabola Stairs out', 'code' => '{$Duration:600,$Delay:30,$Cols:8,$Rows:4,$SlideOut:true,$FlyDirection:6,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Easing:{$Left:$JssorEasing$.$EaseInQuart,$Top:$JssorEasing$.$EaseInQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}' ),

			'zoom_vdouble+_in' => array( 'name' => 'Zoom VDouble+ in', 'code' => '{$Duration:1200,$Rows:2,$Zoom:11,$FlyDirection:4,$Assembly:2049,$ChessMode:{$Row:15},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$ScaleVertical:2,$Opacity:2}' ),

			'zoom+_in' => array( 'name' => 'Zoom+ in', 'code' => '{$Duration:1000,$Zoom:11,$Easing:{$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}' ),

			'fade_square_random' => array( 'name' => 'Fade Square Random (custom)', 'code' => '{$Duration:800,$Delay:150,$Cols:6,$Rows:4,$Clip:15,$SlideOut:true,$During:{$Top:[0.5,0.5],$Clip:[0,0.35]},$Easing:{$Clip:$JssorEasing$.$EaseIn,$Opacity:$JssorEasing$.$EaseIn},$ScaleClip:0.15, $Opacity:3}' )
		);

		add_filter( 'mega_form_select_lists', array( $this, 'addList' ));
		add_filter( 'mega_jssor_anim_list', array( $this, 'doList' ));
	}

	public function settings( $form )
	{
		$form->add_section( 'mega_theme_block_slider_section', array( 'title' => __( 'Settings', 'mega' ), 'panel' => 'mega_slider' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Slider', 'mega' ), 'value' => 1, 'name' => 'show_slider' ));

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'show_slider', 'control_value' => 'true', 'label' => __( 'Slider Location', 'mega' ), 'value' => array( 'template-home.php' => 1, 'category' => 0, 'archive' => 0, 'post' => 0, 'template-contact.php' => 0, 'page' => 0 ), 'name' => 'location', 'use_list' => 1, 'list' => 'mega_template_2_list' ));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Auto Pull or Custom', 'color' ), 'value' => 'auto', 'name' => 'source',
			'choices' => array(
				'auto'		=> __( 'Auto Pull', 'color' ),
				'custom'	=> __( 'Custom', 'color' )
			)
		));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Jssor Animation', 'mega' ), 'value' => 'fade_twins', 'name' => 'auto_animation', 'use_list' => 1, 'list' => 'mega_jssor_anim_list' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Pages, Posts or Category Posts', 'color' ), 'value' => 'posts', 'name' => 'type',
			'choices' => array(
				'cats'	=> __( 'Category Posts', 'color' ),
				'posts'	=> __( 'Posts', 'color' ),
				'pages'	=> __( 'Pages', 'color' )
			)
		));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'type', 'control_value' => 'cats', 'label' => __( 'Category Posts - Number of Results', 'color' ), 'value' => 1, 'name' => 'count' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'type', 'control_value' => 'cats', 'label' => __( 'Select a Category', 'color' ), 'name' => 'cat', 'use_list' => 1, 'list' => 'mega_cat_list' ));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'type', 'control_value' => 'pages', 'label' => __( 'Random Page', 'color' ), 'value' => 1, 'name' => 'rand_pages' ));

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'rand_pages', 'control_value' => 'false', 'label' => __( 'Select Pages', 'color' ), 'value' => array( 0 => 1 ), 'name' => 'pages', 'use_list' => 1, 'list' => 'mega_page_list' ));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'type', 'control_value' => 'posts', 'label' => __( 'Random Post', 'color' ), 'value' => 1, 'name' => 'rand_posts' ));

			$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'rand_posts', 'control_value' => 'false', 'label' => __( 'Select Posts', 'color' ), 'value' => array( 0 => 1 ), 'name' => 'posts', 'use_list' => 1, 'list' => 'mega_post_list' ));

		$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Order By', 'color' ), 'value' => 'date', 'name' => 'order',
			'choices' => array(
				'date'			=> __( 'Date', 'color' ),
				'rand'			=> __( 'Random', 'color' ),
				'comment_count' => __( 'Comment Count', 'color' )
			)
		));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Title', 'color' ), 'value' => 1, 'name' => 'show_title' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'show_title', 'control_value' => 'true', 'label' => __( 'Title Character Count', 'color' ), 'value' => 35, 'name' => 'title_count' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Excerpt Character Count', 'color' ), 'value' => 110, 'name' => 'excerpt_count' ));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Image', 'mega' ), 'value' => 1, 'name' => 'auto_image' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'auto_image', 'control_value' => 'true', 'label' => __( 'Image Width (px)', 'mega' ), 'name' => 'auto_image_width' ));

		$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'auto_image', 'control_value' => 'true', 'label' => __( 'Image Height (px)', 'mega' ), 'name' => 'auto_image_height' ));

		$form->add_sub_control( 'Mega_Control_Checklist', array( 'control' => 'auto_image', 'control_value' => 'true', 'label' => __( 'Image Sources', 'mega' ), 'value' => array( 'featured' => 1, 'first' => 1, 'ph' => 1 ), 'name' => 'auto_image_sources',
			'choices' => array(
				'featured'	=> __( 'Featured', 'mega' ),
				'first'		=> __( 'First', 'mega' ),
				'ph'		=> __( 'Placeholder', 'mega' )
			)
		));

		$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'source', 'control_value' => 'auto', 'label' => __( 'Link', 'color' ), 'value' => 1, 'name' => 'show_link' ));







		$form->add_section( 'mega_block_slider_custom_1_section', array( 'title' => __( 'Custom 1', 'mega' ), 'panel' => 'mega_slider' ));

		$form->section = 'mega_block_slider_custom_1_section';

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Custom 1', 'mega' ), 'value' => 0, 'name' => 'custom_1' ));

			$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Jssor Animation', 'mega' ), 'pro' => 1, 'value' => 'fade_twins', 'name' => 'custom_1_animation', 'use_list' => 1, 'list' => 'mega_jssor_anim_list' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Background Image URL', 'mega' ), 'name' => 'custom_1_bg_image_url' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Image', 'mega' ), 'value' => 1, 'name' => 'custom_1_image' ));

				$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_1_image', 'control_value' => 'true', 'label' => __( 'Image URL', 'mega' ), 'name' => 'custom_1_image_url' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_1_image', 'control_value' => 'true', 'label' => __( 'Image Width (px)', 'mega' ), 'name' => 'custom_1_width' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_1_image', 'control_value' => 'true', 'label' => __( 'Image Height (px)', 'mega' ), 'name' => 'custom_1_height' ));
				
				$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_1_image', 'control_value' => 'true', 'label' => __( 'Show Placeholder', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'custom_1_show_placeholder' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'name' => 'custom_1_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Link', 'mega' ), 'value' => '#', 'name' => 'custom_1_link' ));

			$form->add_sub_control( 'Mega_Control_WP_Editor', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Content', 'mega' ), 'tinymce' => 1, 'name' => 'custom_1_text' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_1', 'control_value' => 'true', 'label' => __( 'Button label', 'mega' ), 'name' => 'custom_1_button_label' ));



		$form->add_section( 'mega_block_slider_custom_2_section', array( 'title' => __( 'Custom 2', 'mega' ), 'panel' => 'mega_slider' ));

		$form->section = 'mega_block_slider_custom_2_section';

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Custom 2', 'mega' ), 'value' => 0, 'name' => 'custom_2' ));

			$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Jssor Animation', 'mega' ), 'pro' => 1, 'value' => 'fade_twins', 'name' => 'custom_2_animation', 'use_list' => 1, 'list' => 'mega_jssor_anim_list' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Background Image URL', 'mega' ), 'name' => 'custom_2_bg_image_url' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Image', 'mega' ), 'value' => 1, 'name' => 'custom_2_image' ));

				$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_2_image', 'control_value' => 'true', 'label' => __( 'Image URL', 'mega' ), 'name' => 'custom_2_image_url' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_2_image', 'control_value' => 'true', 'label' => __( 'Image Width (px)', 'mega' ), 'name' => 'custom_2_width' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_2_image', 'control_value' => 'true', 'label' => __( 'Image Height (px)', 'mega' ), 'name' => 'custom_2_height' ));
				
				$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_2_image', 'control_value' => 'true', 'label' => __( 'Show Placeholder', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'custom_2_show_placeholder' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'name' => 'custom_2_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Link', 'mega' ), 'value' => '#', 'name' => 'custom_2_link' ));

			$form->add_sub_control( 'Mega_Control_WP_Editor', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Content', 'mega' ), 'tinymce' => 1, 'name' => 'custom_2_text' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_2', 'control_value' => 'true', 'label' => __( 'Button label', 'mega' ), 'name' => 'custom_2_button_label' ));



		$form->add_section( 'mega_block_slider_custom_3_section', array( 'title' => __( 'Custom 3', 'mega' ), 'panel' => 'mega_slider' ));

		$form->section = 'mega_block_slider_custom_3_section';

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Custom 3', 'mega' ), 'value' => 0, 'name' => 'custom_3' ));

			$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Jssor Animation', 'mega' ), 'pro' => 1, 'value' => 'fade_twins', 'name' => 'custom_3_animation', 'use_list' => 1, 'list' => 'mega_jssor_anim_list' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Background Image URL', 'mega' ), 'name' => 'custom_3_bg_image_url' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Image', 'mega' ), 'value' => 1, 'name' => 'custom_3_image' ));

				$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_3_image', 'control_value' => 'true', 'label' => __( 'Image URL', 'mega' ), 'name' => 'custom_3_image_url' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_3_image', 'control_value' => 'true', 'label' => __( 'Image Width (px)', 'mega' ), 'name' => 'custom_3_width' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_3_image', 'control_value' => 'true', 'label' => __( 'Image Height (px)', 'mega' ), 'name' => 'custom_3_height' ));
				
				$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_3_image', 'control_value' => 'true', 'label' => __( 'Show Placeholder', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'custom_3_show_placeholder' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'name' => 'custom_3_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Link', 'mega' ), 'value' => '#', 'name' => 'custom_3_link' ));

			$form->add_sub_control( 'Mega_Control_WP_Editor', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Content', 'mega' ), 'tinymce' => 1, 'name' => 'custom_3_text' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_3', 'control_value' => 'true', 'label' => __( 'Button label', 'mega' ), 'name' => 'custom_3_button_label' ));



		$form->add_section( 'mega_block_slider_custom_4_section', array( 'title' => __( 'Custom 4', 'mega' ), 'panel' => 'mega_slider' ));

		$form->section = 'mega_block_slider_custom_4_section';

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Custom 4', 'mega' ), 'value' => 0, 'name' => 'custom_4' ));

			$form->add_sub_control( 'Mega_Control_Select', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Jssor Animation', 'mega' ), 'pro' => 1, 'value' => 'fade_twins', 'name' => 'custom_4_animation', 'use_list' => 1, 'list' => 'mega_jssor_anim_list' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Background Image URL', 'mega' ), 'name' => 'custom_4_bg_image_url' ));

			$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Image', 'mega' ), 'value' => 1, 'name' => 'custom_4_image' ));

				$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_4_image', 'control_value' => 'true', 'label' => __( 'Image URL', 'mega' ), 'name' => 'custom_4_image_url' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_4_image', 'control_value' => 'true', 'label' => __( 'Image Width (px)', 'mega' ), 'name' => 'custom_4_width' ));

				$form->add_sub_control( 'Mega_Control_Number', array( 'control' => 'custom_4_image', 'control_value' => 'true', 'label' => __( 'Image Height (px)', 'mega' ), 'name' => 'custom_4_height' ));
				
				$form->add_sub_control( 'Mega_Control_onOff', array( 'control' => 'custom_4_image', 'control_value' => 'true', 'label' => __( 'Show Placeholder', 'mega' ), 'pro' => 1, 'value' => 1, 'name' => 'custom_4_show_placeholder' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Title', 'mega' ), 'name' => 'custom_4_title' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Link', 'mega' ), 'value' => '#', 'name' => 'custom_4_link' ));

			$form->add_sub_control( 'Mega_Control_WP_Editor', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Content', 'mega' ), 'tinymce' => 1, 'name' => 'custom_4_text' ));

			$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'custom_4', 'control_value' => 'true', 'label' => __( 'Button label', 'mega' ), 'name' => 'custom_4_button_label' ));



		unset( $form->section );
	}

	public function addList( $lists )
	{
		$lists['mega_jssor_anim_list'] = __( 'Jssor Animation List', 'mega' );

		return $lists;
	}

	public function doList()
	{
		$data['random'] = 'Random';

		foreach( $this->jssor_animations as $key => $value )
			$data[$key] = $value['name'];

		return $data;
	}

	public function hookOnce()
	{
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ));
	}

	public function enqueue()
	{
		if ( !$this->mega['settings']['show_slider'] || !mega_toggle( $this->mega['settings']['location'] ))
			return;

		wp_enqueue_script( 'mega.jquery.jssor', MEGA_DIR_URI . '/assets/js/jssor.slider.min.js' );
	}








	public function hook()
	{
		add_action( 'wp_head', array( &$this, 'head' ));
	}

	public function head()
	{
		if ( !$this->mega['settings']['show_slider'] || !mega_toggle( $this->mega['settings']['location'] ))
			return;

		extract( $this->mega['settings'] );

		$json = json_encode( array(
		));
?>

   <script>
        jQuery(document).ready(function ($) {

$('.slides').css('width', document.body.clientWidth);

//jssor_slider1_starter = function (containerId) {
	
            var _SlideshowTransitions = [
<?php

$this->getAnimations();

?>
			
            ];
			
			
            var options = {

                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },
                $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                },
                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 10,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },
                $AutoPlay: true,                //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $SlideDuration: 800,             //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
            };




            var jssor_slider1 = new $JssorSlider$('slider1_container', options);


            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            //ScaleSlider();

            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                //$(window).bind('resize', ScaleSlider);
            }
	
	//};
    
	});
    </script>
    <?php
		/*echo "<script>new $JssorSlider$('slider1_container', $json1);</script>";*/
	}

	public function getAnimations()
	{
		extract( $this->mega['settings'] );

		if ( $source === 'auto' )
		{
			if ( $this->mega['settings']['auto_animation'] == 'random' )
				echo $this->jssor_animations[array_rand( $this->jssor_animations )]['code'] . ',';
			else
				echo $this->jssor_animations[$this->mega['settings']['auto_animation']]['code'] . ',';
		}
		else
			foreach ( range( 1, 4 ) as $k => $v )
			{
				if ( ${"custom_$v"} )
				{
					if ( $this->mega['settings']['custom_' . $v . '_animation'] == 'random' )
						echo $this->jssor_animations[array_rand( $this->jssor_animations )]['code'] . ',';
					else
						echo $this->jssor_animations[$this->mega['settings']['custom_' . $v . '_animation']]['code'] . ',';
				}
			}
	}

	public function callback()
	{
		if ( !$this->mega['settings']['show_slider'] || !mega_toggle( $this->mega['settings']['location'] ))
			return;

echo '<div class="mega_theme_block_slider-wrapper cf auto-wrapper">';

	echo '<div id="slider1_container" class="mega_theme_block_slider slider cf auto-width1" style="overflow: visible; height: 845px;">';

		echo '<div class="slides" u="slides" style="position: absolute; cursor: move; overflow: hidden; left: 0px; top: 0px; height: 845px;">';

		$this->getSlides();

		echo '</div>';

?>

        <div class="controls-wrap jssor-controls-wrap">
        <div u="navigator" class="jssorb03 controls">
            <div u="prototype"><NumberTemplate></NumberTemplate></div>
        </div>
        
        <div class="slide-nav-wrapper">
        
        <span u="arrowleft" class="prevS jssora03l"></span>
        <span u="arrowright" class="nextS jssora03r"></span>
        
        </div>
        </div>
        
<?php

	echo '</div>';

echo '</div>';

	}

	public function getSlides()
	{
		extract( $this->mega['settings'] );

		if ( $source === 'auto' )
		{
			if ( $type === 'pages' || $type === 'posts' )
			{
				$query['post_type'] = $type === 'pages' ? 'page' : 'post';

				if ( ${'rand_' . $type} && $pretty_post = mega_get_pretty_post( $excerpt_count ))
				{
					$query['post__in'][]		= $pretty_post;
					$query['posts_per_page']	= 1;
				}
				else
					$query['post__in'] = in_array( 0, array_keys( $$type, 1 )) ? 0 : array_keys( $$type, 1 );//$$type == array(0) ? 0 : $$type;
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
	
			//echo $this->before();
	
			$this->block();
	
			//echo $this->after();
	
			endwhile; wp_reset_postdata();
		}
		else
			foreach ( range( 1, 4 ) as $k => $v )
			{
				if ( ${"custom_$v"} )
				{
					$this->block( $v );
				}
			}
	}
}