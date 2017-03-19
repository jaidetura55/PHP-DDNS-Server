<?php
error_reporting(E_ALL);

require "loader.php";

$config = new \yswery\DNS\MySQLConfigProvider();

$c = new mysqli($config->host, $config->user, $config->password, $config->database);

$q = $c->query("SELECT * FROM 
		NSUser
	WHERE 
		NSUserName = '".$c->real_escape_string(filter_input(INPUT_GET, "username"))."' 
		AND NSUserPassword = '".$c->real_escape_string(sha1(filter_input(INPUT_GET, "password")))."' 
		AND NSUserDomain = '".$c->real_escape_string(filter_input(INPUT_GET, "domain"))."'");

$t = $q->fetch_object();
if(!$t){
	header("HTTP/1.0 401 Unauthorized");
	die();
}

$q = $c->query("
	UPDATE 
		NSEntry 
	SET 
		NSEntryData = '".$c->real_escape_string(filter_input(INPUT_GET, "ip"))."'
	WHERE 
		NSEntryType = 'A' 
		AND NSEntryDomain = '".$c->real_escape_string(filter_input(INPUT_GET, "domain"))."'");