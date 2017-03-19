PHP DDNS Server
==============

This is a DDNS or DynDNS-Server written in pure PHP.

Support Record Types
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

PHP Requirements
================

* `PHP 5.3+`

Installation:
========
```
apt install php5-cli supervisor

mkdir /var/ddns
git clone https://github.com/nemiah/PHP-DDNS-Server.git

cd PHP-DDNS-Server
wget https://getcomposer.org/installer
php installer
php composer.phar update

cp serverEth0.php ../
cp serverEth1.php ../
cp dns_record.json ../

cp serverEth0.conf /etc/supervisor/conf.d/
cp serverEth1.conf /etc/supervisor/conf.d/

cd /var/ddns
nano serverEth0.php #change IP-address to eth0
nano serverEth1.php #change IP-address to eth1

service supervisor restart

dig @localhost nemiah.de
```
