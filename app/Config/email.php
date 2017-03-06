<?php
require_once(APP.'Config'.DS.'deployment.php');
class EmailConfig {
	public $default = array(
		'transport' => 'Smtp',
		'host'      => MAIL_HOST,
		'port'      => MAIL_PORT,
		'username'  => MAIL_INFO_USER,
		'password'  => MAIL_INFO_PASS,
	);
	// temprary ssh forwarding to the old server
	public $local_smtp = array(
		'transport' => 'Smtp',
		'host' => '127.0.0.1',
		'port' => 2525,
	);
}
