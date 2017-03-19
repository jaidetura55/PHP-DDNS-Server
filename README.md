PHP DDNS Server
==============

This is a DDNS or DynDNS-Server written in pure PHP.

Supported record types
====================

* A
* NS
* CNAME
* SOA
* PTR
* MX
* TXT
* AAAA
* OPT
* AXFR
* ANY

PHP requirements
================

* `PHP 5.3+`

Installation:
========
```
apt install php5-cli supervisor mysql-server

mkdir /var/ddns
git clone https://github.com/nemiah/PHP-DDNS-Server.git

cd PHP-DDNS-Server

cp serverEth0.php ../
cp serverEth1.php ../

cp serverEth0.conf /etc/supervisor/conf.d/
cp serverEth1.conf /etc/supervisor/conf.d/

mysql -uroot -p < setup.sql

cd /var/ddns
nano serverEth0.php #change IP-address to eth0
nano serverEth1.php #change IP-address to eth1

service supervisor restart

dig @localhost nemiah.de
```
