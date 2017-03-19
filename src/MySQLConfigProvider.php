<?php
namespace yswery\DNS;

class MySQLConfigProvider {
	public $host = "localhost";
	public $user = "phpddns";
	public $password = "tkwu0xrrF0JqMShc";
	public $database = "phpddns";
	
	function __construct($host = null, $user = null, $password = null, $database = null) {
		if($host)
			$this->host = $host;
		
		if($user)
			$this->user = $user;
		
		if($password)
			$this->password = $password;
		
		if($database)
			$this->database = $database;
	}
}