<?php

class Mega_Block_Breadcrumbs extends Mega_Walker
{
	public function __construct()
	{
		$args = array(
			'profile'	=> array( 'name' => __( 'Breadcrumbs', 'mega' ), 'description' => __( 'Breadcrumbs block', 'mega' )),
			'before'	=> '<nav id="%1$s" class="%2$s %3$s" %4$s>',
			'after'		=> '</nav>'
		);

		parent::__construct( __CLASS__, $args );
	}

	public function settings( $form )
	{
		$form->add_control( 'Mega_Control_Text', array( 'label' => __( 'Label', 'mega' ), 'value' => '', 'name' => 'label', 'pro' => 1 ));
		$form->add_control( 'Mega_Control_onOff', array( 'label' => __( 'Show Only Last Crumb', 'mega' ), 'value' => 1, 'name' => 'end_leaf' ));
	}

	public function getAncestors( $leaf, $current )
	{
		if ( !$this->end_leaf )
			foreach ( array_reverse( get_ancestors( $current, $leaf )) as $key => $id )
				$this->getLeaf( $leaf, $id );

		$this->getLeaf( $leaf, $current );
	}

	public function block()
	{
		echo $this->mega['settings']['label'];

		$abc = array_reverse( mega_hierarchy() );

		$this->end_leaf = $this->mega['settings']['end_leaf'];

		if ( $this->mega['settings']['end_leaf'] )
			$abc = array( end( $abc ));

		foreach ( $abc as $leaf )
		{
			if ( strpos( $leaf, 'template-' ) !== false )//work it
				$leaf = 'page';

			switch ( $leaf )
			{
				case 'tag' :
					mega_html( __( 'Tags', 'mega' ), '<span>', '</span>' );
					$this->getLeaf( $leaf );
				break;

				case 'category' :
					mega_html( __( 'Categories', 'mega' ), '<span>', '</span>' );

				case 'page' : case 'category' :
					global $post, $wp_query;

					$current = $leaf == 'page' ? $post->ID : $wp_query->get_queried_object()->term_id;

					$this->getAncestors( $leaf, $current );
				break;

				case 'single' ://post
					if ( !$this->mega['settings']['end_leaf'] )
					{
						$cat = get_the_category();
						$this->getAncestors( 'category', $cat[0]->term_id );
					}

					$this->getLeaf( 'post' );
				break;

				case 'day' :
					$this->getLeaf( 'year' );
					$this->getLeaf( 'month' );
					$this->getLeaf( 'day' );
				break;

				case 'month' :
					$this->getLeaf( 'year' );
					$this->getLeaf( 'month' );
				break;

				case 'home' : case 'front_page' :
					//if ( !is_front_page())
					//{
						$this->getLeaf( 'home' );

						if ( $this->mega['settings']['end_leaf'] )
							$this->getLeaf( 'desc' );
					//}
				break;

				default :
					$this->getLeaf( $leaf );
			}
		}
	}

	public function getLeaf( $leaf, $id = '' )
	{
		mega_html( $this->doLeaf( $leaf, $id ), '<span>', '</span>' );
	}

	public function doLeaf( $context, $id = '' )
	{
		switch( $context )
		{
			case 'index' :
				return sprintf( is_front_page() ? '%2$s' : '<a href="%1$s">%2$s</a>', esc_url( home_url( '/' )), __( 'Home', 'mega' ));

			case 'home' :
				return __( 'Blog', 'mega' );

			case 'desc' :
				return esc_html( get_bloginfo( 'description' ));

			case 'page' :
				global $post;
				return sprintf( $post->ID === $id ? '%2$s' : '<a href="%1$s">%2$s</a>', esc_url( get_permalink( $id )), esc_html( get_the_title( $id )));

			case 'post' :
				return esc_html( get_the_title());

			case 'search' :
				return sprintf( __( 'Search Results for: %s', 'mega' ), esc_html( get_search_query() ));

			case 'tag' :
				return sprintf( __( '%s', 'mega' ), single_tag_title( '', false ));//seperate?// sprintf( __( 'Tag Archives: %s', 'mega' ), single_tag_title( '', false ));

			case 'category' :
				global $wp_query;

				return sprintf(
					$wp_query->get_queried_object()->term_id === $id ? '%2$s' : '<a href="%1$s">%2$s</a>',
					esc_url( get_category_link( $id )),
					get_the_category_by_id( $id )
				);

			//Archive by category
			//Category Archives: %s
			//seperate? Categories // title

			case 'author' :
				global $author;
				return sprintf( __( 'Author Archives: %s', 'mega' ), get_userdata( $author )->get( 'display_name' ));

			case '404' :
				return __( 'Error 404', 'mega' );

			case 'archive' :
				return 'Archives';//wp_title( '', false );  ///Category Archives

			case 'day' :
				return get_the_date( 'd' );// Home > Archives > 2012 > November > 06

			case 'month' :
				$month = is_month() ? '%2$s' : '<a href="%1$s">%2$s</a>';
				return sprintf( $month, esc_url( get_month_link( get_the_date( 'Y' ), get_the_date( 'm' ))), get_the_date( 'F' ));

			case 'year' :
				$year = is_year() ? '%2$s' : '<a href="%1$s">%2$s</a>';
				return sprintf( $year, esc_url( get_year_link( get_the_date( 'Y' ))), get_the_date( 'Y' ));
		}
	}
}