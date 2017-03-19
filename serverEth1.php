<?php

require "/var/ddns/PHP-DDNS-Server/vendor/autoload.php";

// JSON formatted DNS records file
$record_file = '/var/ddns/dns_record.json';
$jsonStorageProvider = new yswery\DNS\JsonStorageProvider($record_file);

// Recursive provider acting as a fallback to the JsonStorageProvider
#$recursiveProvider = new yswery\DNS\RecursiveProvider($options);

$stackableResolver = new yswery\DNS\StackableResolver(array($jsonStorageProvider));

// Creating a new instance of our class
$dns = new yswery\DNS\Server($stackableResolver, '188.94.28.124', 53, 60);

// Starting our DNS server
$dns->start();
