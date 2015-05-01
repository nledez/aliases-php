--
-- Table structure for table `postfix_alias`
--

CREATE TABLE `postfix_alias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(128) NOT NULL DEFAULT '',
  `destination` varchar(128) NOT NULL DEFAULT '',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`,`destination`),
  KEY `alias_2` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
