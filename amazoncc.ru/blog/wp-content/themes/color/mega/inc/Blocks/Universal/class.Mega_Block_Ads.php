<?php

class Mega_Block_Ads extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Ads', 'mega' ), 'description' => __( 'Ads block', 'mega' )),//Ad Manager? Ad?
			'universal'	=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Alignment', 'mega' ), 'value' => 'center', 'name' => 'align',
			'choices' => array(
				'left'		=> __( 'Left', 'mega' ),
				'center'	=> __( 'Center', 'mega' ),
				'right'		=> __( 'Right', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Ad Size', 'mega' ), 'desc' => __( 'Enter size as (width)x(height), i.e 100x100', 'mega' ), 'value' => '120x240', 'name' => 'size',
			'choices' => array(
				'120x240'	=> __( '120 x 240', 'mega' ),
				'120x600'	=> __( '120 x 600', 'mega' ),
				'160x600'	=> __( '160 x 600', 'mega' ),

				'125x125'	=> __( '125 x 125', 'mega' ),
				'180x150'	=> __( '180 x 150', 'mega' ),
				'200x200'	=> __( '200 x 200', 'mega' ),
				'250x250'	=> __( '250 x 250', 'mega' ),
				'300x250'	=> __( '300 x 250', 'mega' ),

				'234x60'	=> __( '234 x 60', 'mega' ),
				'320x50'	=> __( '320 x 50', 'mega' ),
				'468x60'	=> __( '468 x 60', 'mega' ),
				'728x90'	=> __( '728 x 90', 'mega' )
			)
		));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Link', 'mega' ), 'name' => 'link' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Image', 'mega' ), 'name' => 'image' ));

		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Custom Code', 'mega' ), 'desc' => __( 'Use the following snippets of code to output the necessary information:<br/><br/>Link - <strong>[link]</strong><br/>Image - <strong>[image]</strong><br/>Width - <strong>[width]</strong><br/>Height - <strong>[height]</strong>', 'mega' ), 'value' => '<a href="[link]" target="_blank"><img src="[image]" width="[width]" height="[height]" /></a>', 'name' => 'code' ));
	}

	public function block()//add adsense support // type: image & link or addsense
	{
		extract( $this->mega['settings'] );

		$size = explode( 'x', $size );

		$image = empty( $image ) ? sprintf( 'http://placehold.it/%sx%s/fff', $size[0], $size[1] ) : $image;

		echo '<div class="mega_ads ' . esc_attr( $align ) . '" style="width: ' . $size[0] . 'px;">';

		echo mega_parse_message( array( 'link' => $link, 'image' => $image, 'width' => $size[0], 'height' => $size[1] ), $code );

		echo '</div>';
	}
}

class Mega_Block_Post_Ads extends Mega_Walker//Mega_Block_Ads
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Post Ads', 'mega' ), 'description' => __( 'Post Ads block', 'mega' )),//Post_Ad_Capture
			'whitelist' => array( 'Mega_Block_Ads' )
		);

		parent::__construct( __CLASS__, $args );

		$this->addTemplate( array(
			$this->addChild( 'Mega_Block_Form_Select', array( 'label' => __( 'Loop Position Type', 'mega' ), 'value' => 'after', 'name' => 'loop_pos_type',
				'options' => array(
					'after' => __( 'After (x) Post Number', 'mega' ),
					'every' => __( 'Every Post Number', 'mega' )
				)
			),
			array(
				$this->addChild( 'Mega_Block_Form_Sub_Field_Wrapper', array( 'value' => 'after' ), array(
					$this->addChild( 'Mega_Block_Form_Number', array( 'label' => __( 'After Post Number', 'mega' ), 'value' => 2, 'name' => 'loop_pos_after' ))
				)),
				$this->addChild( 'Mega_Block_Form_Sub_Field_Wrapper', array( 'value' => 'every' ), array(
					$this->addChild( 'Mega_Block_Form_Number', array( 'label' => __( 'Every Post Number', 'mega' ), 'value' => 3, 'name' => 'loop_pos_every' ))
				))
			)
			)
		));
	}

	public function callback()
	{
		extract( $this->mega['settings'] );

		global $wp_query;

		$i = $wp_query->current_post;

		if ( $i !== -1 )
			if (
				$loop_pos_type === 'after' && $i !== $loop_pos_after OR
				$loop_pos_type === 'every' && $i % $loop_pos_every
			)
				return;

		parent::callback();
	}
}