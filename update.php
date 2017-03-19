<?php
require "loader.php";

$mysqlStorageProvider = new yswery\DNS\MySQLStorageProvider(new \yswery\DNS\MySQLConfigProvider());

print_r($mysqlStorageProvider);