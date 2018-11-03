<?php
error_reporting(E_ALL);

$username = filter_input(INPUT_GET, "username");
if(isset($_SERVER['PHP_AUTH_USER']))
	$username = $_SERVER['PHP_AUTH_USER'];

$password = filter_input(INPUT_GET, "password");
if(isset($_SERVER['PHP_AUTH_PW']))
	$password = $_SERVER['PHP_AUTH_PW'];

$domain = filter_input(INPUT_GET, "domain");
if(filter_input(INPUT_GET, "hostname"))
	$domain = filter_input(INPUT_GET, "hostname");

$ip = filter_input(INPUT_GET, "ip");
if(filter_input(INPUT_GET, "myip"))
	$ip = filter_input(INPUT_GET, "myip");

require "loader.php";

$config = new \yswery\DNS\MySQLConfigProvider();

$c = new mysqli($config->host, $config->user, $config->password, $config->database);

$q = $c->query("SELECT * FROM 
		NSUser
	WHERE 
		NSUserName = '".$c->real_escape_string($username)."' 
		AND NSUserPassword = '".$c->real_escape_string(sha1($password))."' 
		AND NSUserDomain = '".$c->real_escape_string($domain)."'");

$t = $q->fetch_object();
if(!$t){
	header("HTTP/1.0 401 Unauthorized");
	die();
}

$q = $c->query("
	UPDATE 
		NSEntry 
	SET 
		NSEntryData = '".$c->real_escape_string($ip)."'
	WHERE 
		NSEntryType = 'A' 
		AND NSEntryDomain = '".$c->real_escape_string($domain)."'");

$update = new stdClass();
$update->domain = $domain;
$update->ip = $ip;

msg_send(msg_get_queue(3456), 8, $update, true, false, $err);
msg_send(msg_get_queue(3457), 8, $update, true, false, $err);
	
echo "good ".$ip;