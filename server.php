<?php
require __DIR__."/loader.php";

$interface = "0.0.0.0";
if(isset($argv[1]))
	$interface = $argv[1];

$port = 53;
if(isset($argv[2]))
	$port = $argv[2] * 1;

$messageQueue = 3456;
if(isset($argv[3]))
	$messageQueue = $argv[3];

$dns = new yswery\DNS\Server(new yswery\DNS\MySQLStorageProvider(new \yswery\DNS\MySQLConfigProvider(), 60, $messageQueue), $interface, $port, 60);

$dns->start();