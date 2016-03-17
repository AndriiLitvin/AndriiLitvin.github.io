<?php

$mega_mail = new Mega_Mail();

class Mega_Mail
{
	function do_mail( $email, $subject, $message, $from, $from_name )//__construct
	{
		$this->from = $from;
		$this->from_name = $from_name;

		$this->add_filters();
		$r = wp_mail( $email, $subject, $message );
		$this->remove_filters();

		return $r;
	}

	public function add_filters()
	{
		add_filter( 'wp_mail_from', array( &$this, 'from' ));
		add_filter( 'wp_mail_from_name', array( &$this, 'from_name' ));
	}

	public function remove_filters()
	{
		remove_filter( 'wp_mail_from', array( &$this, 'from' ));
		remove_filter( 'wp_mail_from_name', array( &$this, 'from_name' ));
	}

	public function from()
	{
		return $this->from;
	}

	public function from_name()
	{
		return $this->from_name;
	}
}