<?php
require "/var/ddns/PHP-DDNS-Server/loader.php";

$mysqlStorageProvider = new yswery\DNS\MySQLStorageProvider("localhost", "phpddns", "tkwu0xrrF0JqMShc", "phpddns");

$stackableResolver = new yswery\DNS\StackableResolver(array($mysqlStorageProvider));

$dns = new yswery\DNS\Server($stackableResolver, '188.94.24.106', 53, 60);
#$dns = new yswery\DNS\Server($stackableResolver, '0.0.0.0', 5553, 60);

$dns->start();