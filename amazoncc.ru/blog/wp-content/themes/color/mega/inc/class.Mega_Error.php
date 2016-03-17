<?php

class Mega_Error
{
	public $errors = false;

	public function add_error( $id, $error )
	{
		$this->errors[] = array( 'time' => date( 'H:i', current_time( 'timestamp' )), 'log' => $error, 'type' => 'error' );//$id
	}
}