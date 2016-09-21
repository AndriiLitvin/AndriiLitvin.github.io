<?php
/**
 * Plugin Name: Отзывы
 * Description: GoIT
 */


add_action( 'widgets_init', register_widget( 'GoItReviews' ) );



class GoItReviews extends WP_Widget {

	function GoItReviews() {
		$name = 'Отзывы GoIT';				
		$this->WP_Widget( 'GoItReviews-widget', __($name));
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$data = new stdClass;
		foreach($instance as $key => $value) {
			$data->$key = $value;
		}
		
		
		$page = (get_query_var('page')) ? get_query_var('page') : 1;


	  	$offset = 3 * ($page - 1);
		$args = array(
			'posts_per_page'   => 3,
			'offset'           => $offset,
			'category'         => 59,
			'orderby'          => 'menu_order',
			'order'            => 'ASC',
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'no_found_rows'    => false,
			'suppress_filters' => true 
		);

		// $query = new WP_Query($args);
		$get_posts = new WP_Query;
		$data->posts = $get_posts->query($args);

		// $data->posts = get_posts( $args ); 
		$data->countePosts = count($data->posts);
		$data->counter = 1;

		// var_dump($get_posts->found_posts);die;

		$isAjax = 0;

		$args_paginate = array(
			'posts_per_page' => -1,
			'category'         => 59,
			'orderby'          => 'menu_order',
			'order'            => 'ASC',
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);

		$post_paginate = get_posts( $args_paginate );
		$count_paginate = count($post_paginate);
		$total = round($count_paginate/3);
		
		
		include_once("tmpl.php");

		

	}
		  

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		foreach($new_instance as $key => $value) {
			$instance[ $key ] = $value;
		}

		return $instance;
	}

	
	function form( $instance ) {
		$inputs = array();
		
		$instance = wp_parse_args( (array) $instance ); 
		foreach($inputs as $input){?>
			<p>
				<label for="<?=$this->get_field_id( $input[0] )?>">
					<?=$input[1]?>
				</label>
				<input id="<?=$this->get_field_id( $input[0] )?>" 
					   name="<?=$this->get_field_name( $input[0] )?>" 
					   value="<?=$instance[ $input[0] ]?>" 
				style="width:100%;" />
			</p>
		<? } ?>
			<h3>У этого плагина нет настроек.</h3>
		<?
	} // end form
}

?>