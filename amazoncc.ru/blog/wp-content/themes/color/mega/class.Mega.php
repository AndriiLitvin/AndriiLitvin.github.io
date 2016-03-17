<?php

define( 'MEGA_VER', '1.0' );
define( 'MEGA_DIR', get_template_directory() . '/mega' );
define( 'MEGA_DIR_URI', get_template_directory_uri() . '/mega' );

define( 'MEGA_DB_ID', wp_get_theme()->get( 'Name' ) . '_mega_db' );

load_theme_textdomain( 'mega', MEGA_DIR . '/lang' );



//Require
	require_once( MEGA_DIR . '/inc/class-media-grabber.php' );
	require_once( MEGA_DIR . '/inc/functions.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Block_WP_Widget_Bridge.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Block.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Forms.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Form_Manager.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Mail.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Error.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Locations.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Sidebars.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Lists.php' );
	require_once( MEGA_DIR . '/inc/class.Mega_Logs.php' );


//Require Template Blocks
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Logo.php' );
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Breadcrumbs.php' );
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Paginate.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_404.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Toolbar.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Share.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Source_Auto.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Source_Custom.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Source_Custom_Jssor.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Term_Desc.php' );
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Meta.php' );
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Meta_Tags.php' );
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Meta_Cats.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Title.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Author_Info.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Thumbs.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Thumbs_Custom.php' );
	require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Content.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Parent_Posts_Loop.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Parent_Post.php' );
//	require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Parent_vBlock.php' );*/

	//Require Comments Blocks
//		require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Parent_Comments.php' );
//		require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Comments_Loop.php' );
		require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Comments_Form.php' );

	//Require Universal Blocks
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Feature_Skeleton.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Feature_Auto.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Feature_Custom.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Form_Ajax.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Login.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Copyright.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Posts.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Posts_Ajax.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Comments.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Follow.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_About.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Contact_Info.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Map.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Ads.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Tabs.php' );
		require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_CTA.php' );

		//Require Skeleton Blocks
//			require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Element_Skeleton.php' );
//			require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Tabs.php' );
//			require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Accordion.php' );
//			require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Menu.php' );
//			require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Tables.php' );
			require_once( MEGA_DIR . '/inc/Blocks/class.Mega_Block_Slider_Jssor.php' );
//			require_once( MEGA_DIR . '/inc/Builders/Templates/Blocks/class.Mega_Block_Carousel.php' );
			require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Register.php' );
			require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Contact.php' );
			require_once( MEGA_DIR . '/inc/Blocks/Universal/class.Mega_Block_Newsletter.php' );





require_once( MEGA_DIR . '/inc/class.Mega_Admin.php' );
require_once( MEGA_DIR . '/inc/class.Mega_Admin_Page_Settings.php' );


new Mega();

class Mega
{
	public function __construct()
	{
		new Mega_Lists();

		add_action( 'after_setup_theme', array( &$this, 'init' ));
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_scripts' ));
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_scripts' ));
		add_filter( 'excerpt_length', array( &$this, 'excerpt_length' ), 100 );
		add_filter( 'excerpt_more', array( &$this, 'excerpt_more' ));
	}

	public function init()
	{
		megaSetPackage();

		add_theme_support( 'title-tag' );
		add_editor_style( 'mega/assets/admin/editor-style.css' );
		add_filter( 'body_class', array( &$this, 'addBodyClass' ));
		add_action( 'wp_head', array( &$this, 'head' ));
		add_action( 'wp_footer', array( &$this, 'footer' ));
	}

	public function head()
	{
		mega_html( mega_option( 'custom_css' ), '<style type="text/css">', '</style>' );
	}

	public function footer()
	{
		mega_option( 'hook_footer', 1 );
	}

	static function addBodyClass( $classes )
	{
		global $mega_package;

		if ( is_admin() )
			$classes = explode( ' ', $classes );

		$classes[] = 'package-' . $mega_package;

		if ( !is_rtl() )
			$classes[] = 'ltr';

		return is_admin() ? trim( implode( ' ', $classes )) : $classes;
	}

	public function register_scripts()
	{
		wp_register_script( 'mega.jquery.jplayer.min', MEGA_DIR_URI . '/assets/js/jquery.jplayer.min.js' );
		wp_register_script( 'mega.jquery.jplayer.init', MEGA_DIR_URI . '/assets/js/mega.jquery.jplayer.init.js' );
		wp_register_script( 'mega.holder', MEGA_DIR_URI . '/assets/js/holder.js' );
		wp_register_script( 'mega.jquery.posts.timeline', MEGA_DIR_URI . '/assets/js/mega.jquery.posts.timeline.js' );

		wp_register_script( 'mega.jquery.prettyPhoto', MEGA_DIR_URI . '/assets/js/jquery.prettyPhoto.js' );
		wp_register_style( 'mega.jquery.prettyPhoto', MEGA_DIR_URI . '/assets/css/jquery.prettyPhoto.css' );

		wp_register_script( 'mega.bootstrap.tooltip.min', MEGA_DIR_URI . '/assets/js/bootstrap.tooltip.min.js' );
		wp_register_style( 'mega.bootstrap.tooltip.min', MEGA_DIR_URI . '/assets/css/bootstrap.tooltip.min.css' );

		wp_register_style( 'mega.fontawesome', MEGA_DIR_URI . '/assets/css/font-awesome.css' );
		wp_register_style( 'mega.ionicons', MEGA_DIR_URI . '/assets/css/ionicons.css' );

		wp_register_style( 'mega.reset', MEGA_DIR_URI . '/assets/css/reset.css' );

		wp_localize_script( 'jquery', 'mega', array( 'ajax' => admin_url( 'admin-ajax.php' )));
	}

	public function excerpt_length( $length )
	{
		return 250;
	}

	public function excerpt_more( $more )
	{
		return '';
	}
}