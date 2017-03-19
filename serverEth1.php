<?php
require "/var/ddns/loader.php";

$mysqlStorageProvider = new yswery\DNS\MySQLStorageProvider("localhost", "phpddns", "tkwu0xrrF0JqMShc", "phpddns");

$stackableResolver = new yswery\DNS\StackableResolver(array($mysqlStorageProvider));

$dns = new yswery\DNS\Server($stackableResolver, '188.94.28.124', 53, 60);

$dns->start();