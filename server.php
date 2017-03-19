<?php
require "loader.php";

$mysqlStorageProvider = new yswery\DNS\MySQLStorageProvider(new \yswery\DNS\MySQLConfigProvider());

$stackableResolver = new yswery\DNS\StackableResolver(array($mysqlStorageProvider));

$interface = "0.0.0.0";
if(isset($argv[1]))
	$interface = $argv[1];

$port = 53;
if(isset($argv[2]))
	$port = $argv[2] * 1;

$dns = new yswery\DNS\Server($stackableResolver, $interface, $port, 60);

$dns->start();