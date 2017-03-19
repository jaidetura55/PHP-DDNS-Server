PHP DDNS Server
==============

This is a DDNS (or DynDNS)-Server written in pure PHP.  
The records lie in a MySQL database an can easily be updated via the update.php script.  
The installation information below is suited for a newly installed debian jessie.  
Requires PHP>= 5.3

Supported record types
----------------------

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

Installation:
-------------
```
apt install php5-cli php5-mysqlnd supervisor mysql-server libapache2-mod-php5

mkdir /var/ddns
git clone https://github.com/nemiah/PHP-DDNS-Server.git

cd PHP-DDNS-Server

cp serverAll.conf /etc/supervisor/conf.d/
ln -s /var/ddns/PHP-DDNS-Server/update.php /var/www/html/update.php


mysql -uroot -p < setup.sql

service supervisor restart

dig @IP-address nemiah.de
```

IP update:
----------

```
wget http://nemiah.de/update.php?domain=home.nemiah.de&username=nena&password=Hallo123&ip=123.123.123.123
```