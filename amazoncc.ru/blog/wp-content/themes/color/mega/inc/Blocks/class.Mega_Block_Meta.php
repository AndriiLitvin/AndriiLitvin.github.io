<?php

class Mega_Block_Meta extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Meta', 'mega' ), 'description' => __( 'Meta block', 'mega' )),
			'before'	=> '<div id="%1$s" class="%2$s %3$s" %4$s>',
			'after'		=> '</div>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Textarea', array( 'label' => __( 'Meta', 'mega' ), 'desc' => __( 'Use [author], [date], [time], [category] and [tag] snippets to format the meta.', 'mega' ), 'pro' => 1, 'value' => __( 'Posted [author][category]', 'mega' ), 'name' => 'meta' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Author Label', 'mega' ), 'desc' => __( 'Example values:<br/><br/><strong>by<br/>Author:</strong>', 'mega' ), 'value' => __( 'by', 'mega' ), 'name' => 'author' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Date Label', 'mega' ), 'desc' => __( 'Example values:<br/><br/><strong>on<br/>Date:</strong>', 'mega' ), 'value' => __( 'on', 'mega' ), 'name' => 'date' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Date Format', 'mega' ), 'desc' => __( 'Customize how your date looks like, more info on <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Customizing the Time and Date</a>.', 'mega' ), 'pro' => 1, 'value' => 'j/n/Y', 'name' => 'date_format' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Time Label', 'mega' ), 'desc' => __( 'Example values:<br/><br/><strong>at<br/>Time:</strong>', 'mega' ), 'value' => __( 'at', 'mega' ), 'name' => 'time' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Category Label', 'mega' ), 'desc' => __( 'Example values:<br/><br/><strong>in<br/>Category:</strong>', 'mega' ), 'pro' => 1, 'value' => __( 'in', 'mega' ), 'name' => 'category' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Category Separator', 'mega' ), 'value' => ', ', 'name' => 'cat_sep' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Tag Label', 'mega' ), 'desc' => __( 'Example values:<br/><br/><strong>and tagged with<br/>Tags:</strong>', 'mega' ), 'value' => __( 'and tagged with', 'mega' ), 'name' => 'tag' ));

		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Tag Separator', 'mega' ), 'value' => ', ', 'name' => 'tag_sep' ));

		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Icons', 'mega' ), 'value' => 1, 'name' => 'show_icons' ));
	}

	public function callback()
	{
		if ( empty( $this->mega['settings']['meta'] ))
			return;

		parent::callback();
	}

	public function block()
	{
		extract( $this->mega['settings'] );

		foreach ( array( 'author', 'date', 'time', 'category', 'tag' ) as $name )
		{
			$meta = preg_replace( sprintf( '/\[%s\]/', $name ), $this->getMeta( $name, $this->mega ), $meta );
		}

		echo $meta;
	}

	public function getMeta( $item, $instance )
	{
		$class[] = $item;

		if ( !$instance['settings']['show_icons'] )
			$class[] = 'no-icons';

		return mega_html( $this->getWrap( $item, $instance ), '<span class="' . esc_attr( implode( ' ', $class )) . '"><i></i>', '</span>', false );
	}

	public static function getWrap( $item, $instance )
	{
		extract( $instance['settings'] );

		$$item = ( !empty( $$item ) ? '<label>' . esc_html( $$item ) . '</label> ' : '' ) . '%s ';

		switch( $item )
		{
			case 'author' :
				return sprintf( $author, '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ))) . '" rel="author">' . get_the_author() . '</a>' );

			case 'category' :
				return !is_page() && has_category() ? sprintf( $category, get_the_category_list( $cat_sep )) : false;

			case 'tag' :
				return has_tag() ? sprintf( $tag, get_the_tag_list( '', $tag_sep )) : false;

			case 'date' :
				return sprintf( $date, get_the_date( $date_format ));

			case 'time' :
				return sprintf( $time, get_the_time());
		}
	}
}