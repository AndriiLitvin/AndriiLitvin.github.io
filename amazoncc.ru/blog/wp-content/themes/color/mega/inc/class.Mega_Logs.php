<?php

$mega_logs = new Mega_Logs();

class Mega_Logs
{
	public function showLogs()
	{
		echo

		'<div class="mega-logs-wrapper-a">',

			'<div class="mega-logs-wrapper megahidden">',

				'<ul class="log-list">',

					'<li class="trigger"><a class="logx"></a></li>',

					'<li><a href="#mega-logs" class="logx">' . __( 'Logs', 'mega' ) . '</a></li>',

				'</ul>',

				'<div id="mega-logsv">',

					'<ul id="mega-logs" class="logga">';

						$this->addMessages();

					echo

					'</ul>',

				'</div>',

			'</div>',

		'</div>';
	}

	public function addMessages()//doMessages
	{
		array_walk( array_reverse( self::getLogs() ), array( &$this, 'getMessage' ));//$this->messages
	}

	public function getMessage( $log, $id )
	{
		switch( $log['type'] )
		{
			case 'error' : case 'warning' :
				$log['log'] = ucwords( $log['type'] ) . ' occurred at <a href="">#' . $id . '</a> - ' . $log['log'];
			case 'error2' :
				$log['log'] = 'Error occurred - ' . $log['log'];
		}

		echo '<li id="' . $id . '" class="log ' . $log['type'] . '"><span class="date">' . $log['time'] . '</span>' . $log['log'] . '.</li>';
	}

	public function addLogs( $data )
	{
		$logs = self::getLogs();

		foreach( $data as $k => $v )
		{
			$logs[] = wp_parse_args( $v, array( 'type' => 'notice', 'log' => '', 'time' => date( 'H:i', current_time( 'timestamp' ))));
		}

		$time = 24*60*60;

		set_transient( 'mega_logs', $logs, $time );
	}

	public function getLogs()
	{
		$logs = get_transient( 'mega_logs' );

		return is_array( $logs ) ? $logs : array();
	}
}