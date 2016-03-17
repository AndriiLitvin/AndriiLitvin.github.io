<?php

define( 'MEGA_THEME_IMG_DIR_URI', get_template_directory_uri() . '/theme/assets/images' );
define( 'MEGA_THEME_SKIN_DIR_URI', MEGA_THEME_IMG_DIR_URI . '/skin0' );

$content_width = mega_option( 'layout' ) === 'fullwidth' ? 1172 : 766;


load_theme_textdomain( 'color', get_template_directory() . '/theme/lang' );

require_once get_template_directory() . '/theme/blocks/class.Mega_Theme_Settings.php';
require_once get_template_directory() . '/theme/blocks/class.Mega_Theme_Block_Toolbar.php';
require_once get_template_directory() . '/theme/blocks/class.Mega_Theme_Block_Slider.php';
require_once get_template_directory() . '/theme/blocks/class.Mega_Theme_Block_Comments_Loop.php';
require_once get_template_directory() . '/theme/blocks/class.Mega_Theme_Block_Posts_Ajax_Timeline.php';

new Mega_Theme();

class Mega_Theme
{
	public function __construct()
	{
		add_action( 'after_setup_theme', array( &$this, 'init' ));
		add_action( 'widgets_init', array( &$this, 'register_blocks' ));
		add_action( 'widgets_init', array( &$this, 'sidebars' ));


		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue' ));
		add_filter( 'use_default_gallery_style', '__return_false' );
		add_filter( 'the_content', array( &$this, 'content' ));
		add_filter( 'get_comment_text', array( &$this, 'content' ));
		add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ));


		add_filter( 'mega_block_logo_settings', array( &$this, 'mega_block_logo_settings' ));
		add_filter( 'mega_block_meta_settings', array( &$this, 'mega_block_meta_settings' ));
		add_filter( 'mega_block_meta_tags_settings', array( &$this, 'mega_block_meta_tags_settings' ));
		add_filter( 'mega_block_meta_cats_settings', array( &$this, 'mega_block_meta_cats_settings' ));
		add_filter( 'mega_block_posts_settings', array( &$this, 'mega_block_posts_settings' ));
		add_filter( 'mega_theme_block_posts_ajax_timeline_settings', array( &$this, 'mega_block_posts_ajax_settings' ));
		add_filter( 'mega_block_comments_settings', array( &$this, 'mega_block_comments_settings' ));
		add_filter( 'mega_block_comments_loop_settings', array( &$this, 'mega_block_comments_loop_settings' ));
		add_filter( 'mega_theme_block_slider_settings', array( &$this, 'mega_theme_block_slider_settings' ));

		add_filter( 'mega_block_404_args', array( &$this, 'mega_block_404_args' ));
	}

	public function init()
	{
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'quote', 'link', 'status', 'audio', 'video' ));

		register_nav_menu( 'menu', __( 'Top Menu', 'color' ));
	}

	public function register_blocks()
	{
		global $mega_package;

		//Register Universal Blocks
			
			mega_register_block( 'Mega_Block_Copyright' );
			mega_register_block( 'Mega_Block_Posts' );
			mega_register_block( 'Mega_Theme_Block_Posts_Ajax_Timeline' );
			mega_register_block( 'Mega_Block_Comments' );
			mega_register_block( 'Mega_Block_Follow' );
			
			mega_register_block( 'Mega_Block_About' );
			mega_register_block( 'Mega_Block_Contact_Info' );
			
			mega_register_block( 'Mega_Block_Tabs' );

			//Register Skeleton Blocks
//				mega_register_block( 'Mega_Block_Tabbs' );
//				mega_register_block( 'Mega_Block_Accordionn' );
//				mega_register_block( 'Mega_Block_Menu' );
//				mega_register_block( 'Mega_Block_Carousel_Defaults' );
//				mega_register_block( 'Mega_Block_Carousel_Showcases' );
				

				mega_register_block( 'Mega_Block_Map' );

				if ( $mega_package > 0 )
				{
					mega_register_block( 'Mega_Block_Newsletter' );
					mega_register_block( 'Mega_Block_Login' );
					mega_register_block( 'Mega_Block_Follow_Counter' );
					mega_register_block( 'Mega_Block_Register' );
					mega_register_block( 'Mega_Block_Contact' );
					mega_register_block( 'Mega_Block_Ads' );

					mega_register_block( 'Mega_Block_Feature_Custom' );
				}

				

		//Register Blocks
//			mega_register_block( 'Mega_Block_Parent_vBlock' );

			mega_register_block( 'Mega_Block_CTA' );
//			mega_register_block( 'Mega_Block_Thumbs_Custom' );
			mega_register_block( 'Mega_Block_Logo' );
//			mega_register_block( 'Mega_Block_Share' );
//			mega_register_block( 'Mega_Block_Title' );
//			mega_register_block( 'Mega_Block_Term_Desc' );
//			mega_register_block( 'Mega_Block_Parent_Posts_Loop' );
//			mega_register_block( 'Mega_Block_Parent_Post' );
			mega_register_block( 'Mega_Block_Meta' );
			mega_register_block( 'Mega_Block_Meta_Tags' );
			mega_register_block( 'Mega_Block_Meta_Cats' );
			mega_register_block( 'Mega_Block_Content' );
			mega_register_block( 'Mega_Block_Paginate' );
			mega_register_block( 'Mega_Theme_Block_Comments_Loop' );
			mega_register_block( 'Mega_Block_Comments_Form' );
//			mega_register_block( 'Mega_Block_404' );
			mega_register_block( 'Mega_Block_Breadcrumbs' );
//			mega_register_block( 'Mega_Block_Author_Info' );
//			mega_register_block( 'Mega_Block_Tables' );
			mega_register_block( 'Mega_Theme_Block_Toolbar' );
//			mega_register_block( 'Mega_Block_Post_Ads' );

			//mega_register_block( 'Mega_Block_Thumbs' );

			mega_register_block( 'Mega_Theme_Block_Slider' );


			mega_register_block( 'Mega_Block_Feature_Auto' );
			mega_register_block( 'Mega_Theme_Settings' );
	}

	public function sidebars()
	{
		mega_register_location( array(
			'id'		=> 'slider',
			'name'		=> __( 'Slider', 'color' ),
			'pages'		=> true,
			'sidebar'	=> false,
			'statics'	=> array( $this, 'slider_statics' )
		));

		mega_register_location( array(
			'id'		=> 'front_box_1_1',
			'name'		=> __( 'Front Page Box 1 Column 1', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 1, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-email-outline', 'color' => '#fa7960' ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_1_2',
			'name'		=> __( 'Front Page Box 1 Column 2', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 2, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-pricetags-outline', 'color' => '#84cbc5' ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_1_3',
			'name'		=> __( 'Front Page Box 1 Column 3', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 3, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-gear-outline', 'color' => '#FFC400' ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_2',
			'name'		=> __( 'Front Page Box 2 (CTA)', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 4, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'excerpt_count' => 350, 'show_button' => 1, 'alignment' => mega_float() ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_3_1',
			'name'		=> __( 'Front Page Box 3 Column 1', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 6, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-monitor-outline' )),
				array( 'id' => 7, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-lightbulb-outline' ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_3_2',
			'name'		=> __( 'Front Page Box 3 Column 2', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 8, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-gear-outline' )),
				array( 'id' => 9, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-alarm-outline' ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_3_3',
			'name'		=> __( 'Front Page Box 3 Column 3', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 10, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-color-wand-outline' )),
				array( 'id' => 11, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-photos-outline' ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_4',
			'name'		=> __( 'Front Page Box 4 (Blog)', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 0, 'id_base' => 'Mega_Theme_Block_Posts_Ajax_Timeline', 'settings' => array( 'image' => 0, 'length' => 100 ))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_5',
			'name'		=> __( 'Front Page Box 5 (CTA)', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 0, 'id_base' => 'Mega_Block_CTA', 'settings' => array( 'title' => __( 'Not sure which plan is right for your Business? Get a free 30 day trial today.', 'color' )))
			)
		));

		mega_register_location( array(
			'id'		=> 'front_box_6',
			'name'		=> __( 'Front Page Box 6', 'color' ),
			'pages'		=> array( 'front_page', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 5, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'icon2' => 'ion-ios-email-outline', 'color' => '#b4c9e6', 'excerpt_count' => 270 ))
			)
		));

		mega_register_location( array(
			'id'		=> 'r-sidebar',
			'name'		=> __( 'Right Location', 'color' ),
			'pages'		=> true,//array( 'index' ),
			'exclude'	=> array( mega_option( 'show_front' ) ? 'front_page' : '', 'template-home.php' ),
			'statics'	=> array(
				array( 'id' => 0, 'id_base' => 'WP_Widget_Search' ),
				array( 'id' => 0, 'id_base' => 'WP_Widget_Archives' ),
				array( 'id' => 0, 'id_base' => 'Mega_Block_Feature_Auto', 'settings' => array( 'show_button' => 1, 'image' => 1 ))
			)
		));

		mega_register_location( array(
			'id'		=> 'footer1',
			'name'		=> __( 'Footer Column 1', 'color' ),
			'pages'		=> true,//array( 'front_page', 'template-home.php', 'template-onecolumn.php', 'template-contact.php', 'index' ),
			'statics'	=> array( $this, 'footer1_statics' )
		));

		mega_register_location( array(
			'id'		=> 'footer2',
			'name'		=> __( 'Footer Column 2', 'color' ),
			'pages'		=> true,//array( 'front_page', 'template-home.php', 'template-onecolumn.php', 'template-contact.php', 'index' ),
			'statics'	=> array( $this, 'footer2_statics' )
		));

		mega_register_location( array(
			'id'		=> 'footer3',
			'name'		=> __( 'Footer Column 3', 'color' ),
			'pages'		=> true,//array( 'front_page', 'template-home.php', 'template-onecolumn.php', 'template-contact.php', 'index' ),
			'statics'	=> array( $this, 'footer3_statics' )
		));

		mega_register_location( array(
			'id'		=> 'contact_page_left',
			'name'		=> __( 'Contact Page Left Column', 'color' ),
			'pages'		=> array( 'template-contact.php' ),
			'statics'	=> array(
				array( 'id' => 0, 'id_base' => 'Mega_Block_Contact' )
			)
		));

		mega_register_location( array(
			'id'		=> 'contact_page_right',
			'name'		=> __( 'Contact Page Right Column', 'color' ),
			'pages'		=> array( 'template-contact.php' ),
			'statics'	=> array( $this, 'contact_page_right_statics' )
		));

		mega_register_location( array(
			'id'		=> 'contact_page_top',
			'name'		=> __( 'Contact Page Top Column', 'color' ),
			'sidebar'	=> false,
			'pages'		=> array( 'template-contact.php' ),
			'statics'	=> array(
				array( 'id' => 0, 'id_base' => 'Mega_Block_Map' )
			)
		));
	}

	public function slider_statics( $location )
	{
		$location->addStatic( 0, 'Mega_Theme_Block_Slider' );
	}

	public function footer1_statics( $location )
	{
		if ( mega_option( 'show_footer' ))
		{
			$location->addStatic( 0, 'Mega_Block_About' );
			$location->addStatic( 0, 'Mega_Block_Follow', array( 'title' => '' ));
		}
	}

	public function footer2_statics( $location )
	{
		if ( mega_option( 'show_footer' ))
		{
			$location->addStatic( 0, 'Mega_Block_Contact_Info' );
		}
	}

	public function footer3_statics( $location )
	{
		if ( mega_option( 'show_footer' ))
		{
			$location->addStatic( 0, 'WP_Widget_Search', array( 'title' => __( 'Search', 'color' )));
			$location->addStatic( 0, 'Mega_Block_Copyright' );
		}
	}

	public function contact_page_right_statics( $location )
	{
		$location->addStatic( 0, 'Mega_Block_Contact_Info', array( 'text' => mega_option( 'default_contact_info_text' )));
	}

	public function mega_block_logo_settings()
	{
		// image width is 100% always?
		// should be auto

		return array(
			'width'		=> 195,
			'height'	=> 40,
			'type'		=> 'image',
			'image'		=> MEGA_THEME_SKIN_DIR_URI . '/logo.png'
		);
	}

	public function mega_block_meta_settings()
	{
		return array(
			'meta'			=> '[date][author]',
			'category'		=> __( 'Cats:', 'color' ),
			'cat_sep'		=> '',
			'author'		=> '',
			'tag'			=> __( 'Tags:', 'color' ),
			'tag_sep'		=> '',
			'date'			=> '',
			'time'			=> ''
		);
	}

	public function mega_block_meta_tags_settings()
	{
		return array(
			'tag_sep'	=> ''
		);
	}

	public function mega_block_meta_cats_settings()
	{
		return array(
			'cat_sep' => ''
		);
	}

	public function mega_block_posts_settings()
	{
		return array(
			'layout'	=> '[title][meta]',
			'meta'		=> '[date]',
			'width'		=> 40,
			'height'	=> 40
		);
	}

	public function mega_block_posts_ajax_settings()
	{
		return array(
			'image'		=> 0,
			//'width'	=> 70,
			//'height'	=> 70,
			//'length'	=> 180
		);
	}

	public function mega_block_comments_settings()
	{
		return array(
			'avatar_size'	=> 40,
			'layout'		=> '[meta][title][excerpt]',
			'meta'			=> '[date]'
		);
	}

	public function mega_block_comments_loop_settings()
	{
		return array(
			'avatar_size' => 70
		);
	}

	public function mega_theme_block_slider_settings()
	{
		return array(
			'source'				=> 'custom',
			'auto_image_width'		=> 1100,
			'auto_image_height'		=> 400,
			'excerpt_count'			=> 180,

			'custom_1'				=> 1,
			'custom_1_width'		=> 1100,
			'custom_1_height'		=> 400,
			'custom_1_title'		=> __( 'Innovative Engineering', 'color' ),
			'custom_1_text'			=> __( 'Lorem ipsum dolor sit amet, vivendum voluptatum qui id. His evertitur interpretaris et voluptua adipis magna <strong>vehicula ullamcorper</strong> id at arcu. Etiam rhoncus velit vel tristique. Cras ac ornare est.
Etiam rhoncus velit vel. honcus velit <strong>vel tristique</strong>. honcus velit vel.', 'color' ),
			'custom_1_button_label'	=> __( 'Continue', 'color' ),
			'custom_1_bg_image_url'	=> MEGA_THEME_IMG_DIR_URI . '/bridge.png',
			'custom_1_image_url'	=> MEGA_THEME_IMG_DIR_URI . '/slider.gif'
		);
	}

	public function mega_block_404_args( $args )
	{
		$args['before']		= '<article id="%1$s" class="%2$s %3$s"><div class="hentry-body">';
		$args['after']		= '</div></article>';

		return $args;
	}

	public function enqueue()
	{
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'mega.bootstrap.tooltip.min' );
		wp_enqueue_script( 'mega.holder' );
		wp_enqueue_script( 'mega.theme.scripts', get_template_directory_uri() . '/theme/assets/scripts.js' );
		wp_enqueue_style( 'mega.reset' );
		wp_enqueue_style( 'mega.fontawesome' );
		wp_enqueue_style( 'mega.theme.font', '//fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic' );


		wp_enqueue_style( 'mega.theme.style.2', get_template_directory_uri() . '/theme/assets/css/style.css' );
		wp_enqueue_style( 'mega.theme.block', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block.css' );
		wp_enqueue_style( 'mega.theme.structure', get_template_directory_uri() . '/theme/assets/css/structure.css' );
		wp_enqueue_style( 'mega.theme.content', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Content.css' );
		wp_enqueue_style( 'mega.theme.comments', get_template_directory_uri() . '/theme/assets/css/comments.css' );
		wp_enqueue_style( 'mega.theme.WP_Widget_Search', get_template_directory_uri() . '/theme/assets/css/class.WP_Widget_Search.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Breadcrumbs', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Breadcrumbs.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Logo', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Logo.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Meta', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Meta.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Menu', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Menu.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Paginate', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Paginate.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Posts_Comments', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Posts_Comments.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Share', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Share.css' );
		wp_enqueue_style( 'mega.theme.Mega_Block_Slider', get_template_directory_uri() . '/theme/assets/css/class.Mega_Block_Slider.css' );
		wp_enqueue_style( 'mega.theme.Mega_Theme_Block_Timeline', get_template_directory_uri() . '/theme/assets/css/class.Mega_Theme_Block_Timeline.css' );

		wp_enqueue_style( 'mega.theme.style', get_stylesheet_uri() );


		wp_enqueue_style( 'mega.bootstrap.tooltip.min' );
		wp_enqueue_style( 'mega.jquery.prettyPhoto' );
	}

	public function content( $content )
	{
		$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto"$6>$7</a>';

		return preg_replace_callback( '|<pre.*>(.*)</pre|isU', array( $this, 'match' ), preg_replace( $pattern, $replacement, $content ));

		//return preg_replace( '~(<pre\b[^>]*>)(.*?)(</pre>)~ise', '"$1" . esc_attr( "$2" ) . "$3"', preg_replace( $pattern, $replacement, $content ));
	}

	public function match( $matches )
	{
		return str_replace( $matches[1], htmlentities( $matches[1] ), $matches[0] );
	}

	public function pre_get_posts( $query )
	{
		if ( $query->is_home() && $query->is_main_query() )
		{
			$query->set( 'cat', mega_option( 'cat' ));//implode( ',', mega_option( 'cat' ))
			$query->set( 'offset', mega_option( 'offset' ));
		}
	}
}







function mega_nav( $args = array() )//run as filter? wp_nav_menu_args
{
	wp_nav_menu( wp_parse_args( $args, array( 'container_class' => 'widget_nav_menu', 'show_home' => true )));
}