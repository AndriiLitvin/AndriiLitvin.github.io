<?php

class Mega_Block_Map extends Mega_Walker
{
	public function __construct()
	{
		global $mega_package;

		$args = array(
			'profile'		=> array( 'name' => __( 'Map', 'mega' ), 'description' => __( 'Map Block', 'mega' )),
			'before'		=> '<div id="%1$s" class="%2$s %3$s widget">',//%4$s
			'after'			=> '</div>',
			'universal'		=> $mega_package > 0 ? true : false,
			'universal_pro'	=> true
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Title', 'mega' ), 'pro' => 1, 'value' => __( 'Where we are?', 'mega' ), 'name' => 'title' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Google API Key', 'mega' ), 'value' => '', 'name' => 'key' ));

		$form->add_control( 'Mega_Control_Select', array( 'label' => __( 'Type', 'mega' ), 'value' => 'address', 'name' => 'type',
			'choices' => array(
				'address'	=> __( 'Address', 'mega' ),
				'latlng'	=> __( 'Latitude / Longitude', 'mega' )
			)
		));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'type', 'control_value' => 'address', 'label' => __( 'Address', 'mega' ), 'value' => __( 'Palo Alto', 'mega' ), 'name' => 'address' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'type', 'control_value' => 'latlng', 'label' => __( 'Latitude', 'mega' ), 'value' => '59.91916', 'name' => 'lat' ));

		$form->add_sub_control( 'Mega_Control_Text', array( 'control' => 'type', 'control_value' => 'latlng', 'label' => __( 'Longitude', 'mega' ), 'value' => '30.32910', 'name' => 'lng' ));

		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Height', 'mega' ), 'value' => 300, 'name' => 'height' ));
		$form->add_control( 'Mega_Control_Number', array( 'label' => __( 'Zoom', 'mega' ), 'pro' => 1, 'value' => 16, 'name' => 'zoom' ));
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Custom Marker', 'mega' ), 'pro' => 1, 'value' => '', 'name' => 'marker' ));
	}

	public function hookOnce()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ));
	}

	public function enqueue()
	{
		wp_enqueue_script( 'mega.google.maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
		wp_enqueue_script( 'mega.jquery.map', MEGA_DIR_URI . '/assets/js/mega.jquery.map.js' );
		wp_localize_script( 'mega.jquery.map', 'megamap', array( 'msg' => __( 'Google was unable to find the address you specified, please try a different address or use the Latitude & Longitude parameters.', 'mega' )));
	}

	public function hook()
	{
		add_action( 'wp_head', array( $this, 'head' ));
	}

	public function head()
	{
		$this->mega['settings']['zoom'] = (int) $this->mega['settings']['zoom'];

		$json = json_encode( $this->mega['settings'] );//, JSON_NUMERIC_CHECK = php 5.3.3 +

		//$id = $this->mega['args']['id_base_low'] . '-' . $this->mega['args']['id'];
		$id = '#' . $this->id;

		echo "<script type='text/javascript'>jQuery(document).ready(function($){ $('$id').each(function(i, el){
			$(this).children('.g-map').megamap($json);}); });</script>";
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		echo '<div class="g-map" style="height: ' . $height . 'px;"></div>';
	}
}