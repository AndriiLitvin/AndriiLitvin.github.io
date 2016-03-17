<?php

$mega_admin = new Mega_Admin();

class Mega_Admin
{
	public function __construct( $args = array() )
	{
		global $mega_package;

		$this->package = $mega_package;

		add_action( 'admin_menu', array( &$this, 'addPage' ));
		//add_action( 'after_switch_theme', array( &$this, 'redirect_page' ));
		add_action( 'customize_register', array( &$this, 'customize' ));
		add_action( 'customize_controls_enqueue_scripts', array( &$this, 'customize_enqueue' ));
		add_action( 'customize_preview_init', array( &$this, 'customize_live' ));
	}

	public function redirect_page()
	{
		wp_redirect( admin_url( 'themes.php?page=mega' ));
	}

	public function addPage()
	{
		global $mega_package;

		$this->package = $mega_package;

		$title = $this->package === '0' ? __( 'Upgrade This Theme', 'mega' ) : sprintf( __( '%s Options', 'mega' ), wp_get_theme()->get( 'Name' ));

		$this->page_hook = add_theme_page(
			sprintf( __( 'Upgrade %s', 'mega' ), wp_get_theme()->get( 'Name' )),
			$title,
			'edit_theme_options',
			'mega',
			array( &$this, 'doPage' )
		);

		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue' ));
	}

	public function doPage()
	{
		global $mega_s, $mega_logs;

		$n = new Mega_Form_Manager( array( 'type' => 'tabs' ));

		$n->panels['tab-1'] = array( 'title' => __( 'Home', 'mega' ), 'href' => '#tab-1', 'callback' => array( $this, 'getPackage' ));

		if ( $this->package === '0' )
			$n->panels['customize'] = array( 'title' => __( 'Customize', 'mega' ), 'href' => admin_url( 'customize.php' ));
		else
			$this->customize( $n );

		//$n->panels['validate'] = array( 'title' => __( 'Validate', 'mega' ), 'href' => '#validate', 'callback' => array( $this, 'validate' ));

		echo

		'<div class="mega">',

			'<div class="left" style="width: calc(100% - 120px); max-width: 800px;">',

				'<div class="ac header">',

					'<div class="logo1"></div>',

					'<nav class="main">',

						'<ul>';

							$n->buildTabs();

						echo '</ul>';

					echo '</nav>';

					if ( $this->package === '0' )
						echo '<a class="mega-button upgrade" href="' . mega_upgrade_url( 'header' ) . '" target="_blank">' . __( 'Upgrade', 'mega' ) . '</a>';

					//<span class="validate">' . __( 'or <a href="#tab-5">validate</a>', 'mega' ) . '</span>

				echo '</div>';

				echo '<div class="mega-body cf megahome">';

					if ( $this->package !== '0' )
						$mega_s->page( $n );
					else
						$n->buildContent( 'tab-1' );

					//$this->updatePage();

					//$this->validatePage();

				echo

				'</div>';

				if ( $this->package !== '0' )
					$mega_logs->showLogs();

				echo

				'<div class="mega-footer cf">',

					'<div class="ver">' . sprintf( __( 'Framework v%1$s Theme v%2$s', 'mega' ), MEGA_VER, wp_get_theme()->get( 'Version' )) . '</div>',

				'</div>',

			'</div>',

		'</div>';
	}

	public function customize( $wp_customize )
	{
		global $mega_registered_blocks;

		$wp_customize->add_panel( 'mega_default_widget_settings', array(
			'priority'			=> 31,
			'capability'		=> 'edit_theme_options',
			'theme_supports'	=> '',
			'title'				=> __( 'Widget Default', 'mega' ),
			'description'		=> __( 'This section allows you to specify default settings for the widgets that this theme supports. Upon saving, any new widgets that you\'ll use will have the new settings in place. This doesn\'t affect current widgets that are in use.', 'mega' )
		));

		$wp_customize->add_panel( 'mega_default_widget_settings_2', array(
			'priority'			=> 31,
			'capability'		=> 'edit_theme_options',
			'theme_supports'	=> '',
			'title'				=> __( 'Static Blocks Default', 'mega' ),
			'description'		=> __( 'This section allows you to specify default settings for static blocks that this theme supports and are shown across the site. Upon theme upgrade, these blocks turn into widgets and are available for drag and drop.', 'mega' )
		));

		foreach( $mega_registered_blocks as $block )
		{
			if ( $block->mega['args']['universal'] )
				$wp_customize->add_section( $block->mega['args']['id_base_low'] . '_section', array(
					'title'		=> $block->mega['args']['profile']['name'],
					'priority'	=> 31,
					'panel'		=> 'mega_default_widget_settings'
				));
			else if ( $block->mega['args']['universal_pro'] )
				$wp_customize->add_section( $block->mega['args']['id_base_low'] . '_section', array(
					'title'		=> $block->mega['args']['profile']['name'],
					'priority'	=> 31,
					'panel'		=> 'mega_default_widget_settings_2'
				));

			if ( is_a( $wp_customize, 'Mega_Form_Manager' ))
			{
				$wp_customize->callback = array( $block, 'setSettings' );

				$block->registerSettings( $wp_customize );
			}
			else
			{
				$wp_customize->callback = array( $block );

				$block->registerSettings( new Mega_Form_Manager( array( 'wp_customize' => $wp_customize )));
			}
		}
	}

	public function getPackage()
	{
		echo '<div class="mega-main">';

		$upgrade_url = mega_upgrade_url( 'body' );

		switch( $this->package )
		{
			case '0' :
				echo '<h2>';
					echo '<a target="_blank" href="' . mega_upgrade_url( 'body_title' ) . '">' . __( 'Upgrade this theme.', 'mega' ) . '</a>';
				echo '</h2>';
				echo '<a target="_blank" href="' . $upgrade_url . '" class="block upgrade">' . sprintf( __( 'Upgrade this theme today for just %s and get access to extra features.', 'mega' ), '<span class="price">' . mega_remote_data( 'price' ) . '</span>' ) . '</a>';
				echo '<ul>';
					echo '<li><a target="_blank" href="' . $upgrade_url . '">' . __( 'Get access to extra features and settings', 'mega' ) . '</a></li>';
					echo '<li><a target="_blank" href="' . $upgrade_url . '">' . __( 'Full access to all themes available', 'mega' ) . '</a></li>';
					echo '<li><a target="_blank" href="' . $upgrade_url . '">' . __( 'Unlimited email and forum support', 'mega' ) . '</a></li>';
					echo '<li><a target="_blank" href="' . $upgrade_url . '">' . __( 'Template, forms, tables & other element builders', 'mega' ) . '</a></li>';
				echo '</ul>';
				echo '<div class="cta cf">';
					echo '<div class="left">';
						echo '<h3 class="cta_title">' . __( '<strong>Act now,</strong> don\'t miss your chance!', 'mega' ) . '</h3>';
						echo '<span>' . __( 'don\'t wait too long or the offer might end soon...', 'mega' ) . '</span>';
					echo '</div>';
					echo '<a class="right" href="' . mega_upgrade_url( 'body_btn' ) . '">' . __( 'Upgrade', 'mega' ) . '</a>';
				echo '</div>';

				break;

			case '1' :
				echo '<h2>' . __( 'Thank you for upgrading.', 'mega' ) . '</h2>' . __( 'Thank you for upgrading, you are now running the full loaded & <strong>professional</strong> version and you have full access to our support.', 'mega' );

				break;

			case '1.1' :
				echo '<h2>' . __( 'Dear ThemeForest users,', 'mega' ) . '</h2>' . sprintf( __( 'Thank you for trying this amazing theme powered by MegaThemes, please sign up at %s to get support.', 'mega' ), '<a target="_blank" href="http://www.megathemes.com/members/?ref=tf">megathemes.com</a>' );
		}

		echo '</div>';
	}

	public function customize_enqueue()
	{
		wp_localize_script( 'jquery', 'mega_package', array(
			'id'		=> $this->package,
			'label'		=> __( 'Upgrade this theme.', 'mega' ),
			'link'		=> mega_upgrade_url( 'header' )
		));

		wp_enqueue_script( 'mega.jquery.lock', MEGA_DIR_URI . '/assets/js/mega.jquery.lock.js', array(), false, true );
		wp_enqueue_script( 'mega.jquery.customizer', MEGA_DIR_URI . '/assets/admin/customizer.js', array( 'jquery' ), false, true );
	}

	public function customize_live()
	{
		wp_enqueue_script( 
			'mega-live-customizer',
			MEGA_DIR_URI . '/assets/admin/customizer-live.js',
			array( 'jquery', 'customize-preview' ),
			'',
			true
		);
	}

	public function enqueue( $page )
	{
		global $mega_admin;

		if ( $mega_admin->page_hook != $page )
		{
			if ( $page === 'widgets.php' OR $page === 'customize.php' )
			{
		wp_localize_script( 'jquery', 'mega_package', array(
			'id'		=> $this->package,
			'label'		=> __( 'Upgrade this theme.', 'mega' ),
			'link'		=> mega_upgrade_url( 'header' )
		));

				wp_enqueue_script( 'mega.jquery.lock', MEGA_DIR_URI . '/assets/js/mega.jquery.lock.js', array(), false, true );
				wp_enqueue_script( 'mega.jquery.customizer', MEGA_DIR_URI . '/assets/admin/customizer.js', array( 'jquery' ), false, true );

				wp_enqueue_style( 'mega.fontawesome' );
				wp_enqueue_style( 'mega.ionicons' );

				wp_enqueue_style( 'mega.admin.style', MEGA_DIR_URI . '/assets/admin/style-widgets.css' );
				wp_enqueue_script( 'mega.jquery.control.checklist', MEGA_DIR_URI . '/assets/js/mega.jquery.control.checklist.js', array( 'jquery' ), false, true);
			}

			return false;
		}

		//if ( $this->page_hook != $this->sub_page() )
			//return false;

		if ( $this->package !== '0' )
			wp_enqueue_script( 'jquery-ui-tabs' );

		wp_enqueue_script( 'swfobject' );
		//wp_enqueue_script( 'mega.bootstrap.tooltip.min' );


		wp_enqueue_script( 'mega.bootstrap.tooltip.min', MEGA_DIR_URI . '/assets/js/bootstrap.tooltip.min.js' );
		wp_enqueue_style( 'mega.bootstrap.tooltip.min', MEGA_DIR_URI . '/assets/css/bootstrap.tooltip.min.css' );

		wp_enqueue_script( 'mega.admin.scripts', MEGA_DIR_URI . '/assets/admin/scripts.js' );

wp_enqueue_style( 'mega.fontawesome' );
wp_enqueue_style( 'mega.ionicons' );

		wp_enqueue_style( 'mega.admin.style', MEGA_DIR_URI . '/assets/admin/style.css' );

		add_filter( 'admin_body_class', array( 'Mega', 'addBodyClass' ));

		wp_localize_script( 'jquery', 'mega_package', array( 'id' => $this->package ));
	}
}