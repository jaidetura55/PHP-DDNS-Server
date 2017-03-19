CREATE USER 'phpddns'@'localhost' IDENTIFIED WITH mysql_native_password;
GRANT USAGE ON *.* TO 'phpddns'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
SET PASSWORD FOR 'phpddns'@'localhost' = PASSWORD('tkwu0xrrF0JqMShc');

CREATE DATABASE IF NOT EXISTS `phpddns`;
GRANT ALL PRIVILEGES ON `phpddns`.* TO 'phpddns'@'localhost';

FLUSH PRIVILEGES;

USE phpddns;

CREATE TABLE `NSEntry` (
  `NSEntryID` int(10) NOT NULL,
  `NSEntryDomain` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `NSEntryType` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NSEntryData` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `NSEntry` (`NSEntryID`, `NSEntryDomain`, `NSEntryType`, `NSEntryData`) VALUES
(1, 'nemiah.de', 'A', '111.111.111.111'),
(2, 'nemiah.de', 'MX', 'mail.nemiah.de'),
(3, 'nemiah.de', 'NS', 'ns1.nemiah.de,ns2.nemiah.de'),
(4, 'nemiah.de', 'SOA', 'mname:ns1.nemiah.de,rname:admin.nemiah.de,serial:20170319,retry:7200,refresh:1800,expire:8600,minimum-ttl:60'),
(5, 'ns1.nemiah.de', 'A', '188.94.24.106'),
(7, 'ns2.nemiah.de', 'A', '188.94.28.124'),
(8, 'home.nemiah.de', 'A', '84.164.106.117');

CREATE TABLE `NSUser` (
  `NSUserID` int(10) NOT NULL,
  `NSUserName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `NSUserPassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `NSUserDomain` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `NSUser` (`NSUserID`, `NSUserName`, `NSUserPassword`, `NSUserDomain`) VALUES
(1, 'nena', SHA1('Hallo123'), 'nemiah.de');

ALTER TABLE `NSEntry`
  ADD PRIMARY KEY (`NSEntryID`);

ALTER TABLE `NSUser`
  ADD PRIMARY KEY (`NSUserID`);

ALTER TABLE `NSEntry`
  MODIFY `NSEntryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `NSUser`
  MODIFY `NSUserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;