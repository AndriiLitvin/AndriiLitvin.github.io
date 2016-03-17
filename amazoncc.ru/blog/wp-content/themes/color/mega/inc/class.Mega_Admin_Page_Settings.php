<?php

$mega_s = new Mega_Admin_Page_Settings();

class Mega_Admin_Page_Settings//extends?
{
	public function __construct( $args = array() )
	{
		add_action( 'wp_ajax_' . __CLASS__, array( &$this, 'ajax' ));
		add_action( 'after_setup_theme', array( &$this, 'reSet' ));
	}

	public function page( $n )
	{
		echo '<form action="/">';

		$n->buildContent();

		echo

		'<input class="mega-button save left hide-btns" type="submit" />',

		'<input type="hidden" name="action" value="Mega_Admin_Page_Settings" />',

		'<div class="mega-reset hide-btns">',
			'<div class="mega-reset-main"></div>',
			'<a href="' . wp_nonce_url( admin_url( 'themes.php?page=mega' ), 'mega_reset', 'reset_nonce' ) . '" class="reset-open"></a>',
		'</div>',

		wp_nonce_field( 'mega_data', 'security', 1, 0 ),

		'</form>';
	}

	public function ajax()
	{
		global $mega_registered_blocks, $mega_logs;

		check_ajax_referer( 'mega_data', 'security' );

		$data = stripslashes_deep( $_POST );

		unset( $data['security'], $data['action'] );

		$mega_error = new Mega_Error();

		foreach( $data['mega'] as $id_base => $block )
		{
			$obj = $mega_registered_blocks[$id_base];

			foreach ( $block as $k => $v )
			{
				call_user_func( $obj->mega['settings_validate'][$k]['callback'], $v, $mega_error );

				$newdata['mega'][strtolower($id_base)][$k] = call_user_func( $obj->mega['settings_sanitize'][$k]['callback'], $v );
			}

			$newdata['mega'][strtolower($id_base)] = wp_parse_args( $newdata['mega'][strtolower($id_base)], $obj->mega['settings_defaults'] );
		}

		if ( !$mega_error->errors )
			$mega_error->errors = array( array(
				'type'	=> 'notice',
				'log'	=> __( 'Options Saved', 'mega' ),
				'time'	=> date( 'H:i', current_time( 'timestamp' ))
			));

		megaUpdateDB( $newdata['mega'] );

		echo json_encode( $mega_error->errors );

		$mega_logs->addLogs( $mega_error->errors );

		exit;
	}

	public function reSet()
	{
		global $mega_logs;

		if ( isset( $_GET['reset_nonce'] ) && wp_verify_nonce( $_GET['reset_nonce'], 'mega_reset' ))
		{
			megaDeleteDB();

			$mega_logs->addLogs( array( array( 'log' => __( 'Master Reset Activated', 'mega' ))));

			wp_redirect( admin_url( 'themes.php?page=mega' ));
			//$this->redirect();
		}
	}
}