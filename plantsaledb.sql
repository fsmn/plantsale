# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.0.92-log)
# Database: plantsaledb
# Generation Time: 2013-03-01 12:36:54 -0600
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table color
# ------------------------------------------------------------

DROP TABLE IF EXISTS `color`;

CREATE TABLE `color` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `common_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `color` varchar(255) default NULL,
  `height` varchar(25) default NULL,
  `width` varchar(25) default NULL,
  `note` text,
  `rec_modifier` int(11) NOT NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;

INSERT INTO `color` (`id`, `common_id`, `name`, `color`, `height`, `width`, `note`, `rec_modifier`, `rec_modified`)
VALUES
	(1,2,'Floristan White','White','24-36\"',NULL,'8-10 cm bulbs.',1,'2013-03-01 12:19:11');

/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table common
# ------------------------------------------------------------

DROP TABLE IF EXISTS `common`;

CREATE TABLE `common` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `species` varchar(255) default '',
  `genus` varchar(255) default NULL,
  `category` varchar(255) default NULL,
  `subcategory` varchar(255) default '',
  `description` text,
  `latin_name` varchar(255) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_modifier` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `common` WRITE;
/*!40000 ALTER TABLE `common` DISABLE KEYS */;

INSERT INTO `common` (`id`, `name`, `species`, `genus`, `category`, `subcategory`, `description`, `latin_name`, `rec_modified`, `rec_modifier`)
VALUES
	(1,'Test','Testus',NULL,NULL,'','The poodle is near midnight. ','T. Examen','2013-02-19 11:04:25',1),
	(2,'Blazing Star','spicata','liatris','Perennials','','Long flowers spikes. Seeds eaten by birds. Best in groups. Drought tolerant, but loves water, too.\n',' ','2013-03-01 12:16:57',1);

/*!40000 ALTER TABLE `common` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table flag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flag`;

CREATE TABLE `flag` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `menu_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  `key` varchar(55) default '',
  `value` varchar(55) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;

INSERT INTO `menu` (`id`, `category`, `key`, `value`)
VALUES
	(1,'common_category','Annuals','Annuals'),
	(2,'common_category','Climbers','Climbers'),
	(3,'common_category','Fruit','Fruit'),
	(4,'common_category','Grasses','Grasses'),
	(5,'common_category','Herbs','Herbs'),
	(6,'common_category','Natives','Natives'),
	(7,'common_category','Perennials','Perennials'),
	(8,'common_category','Roses','Roses'),
	(9,'common_category','Shrubs/Trees','Shrubs/Trees'),
	(10,'common_category','Unusual','Unusual'),
	(11,'common_category','Vegetables','Vegetables');

/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `color_id` int(11) NOT NULL,
  `common_id` int(11) NOT NULL,
  `catalog_number` varchar(15) default NULL,
  `catalog_id` int(11) default NULL,
  `year` int(11) default NULL,
  `flat_size` int(11) default NULL,
  `flat_cost` double default NULL,
  `plant_cost` double default NULL,
  `pot_size` varchar(255) default NULL,
  `price` double default NULL,
  `count_presale` int(11) default NULL,
  `count_midsale` int(11) default NULL,
  `count_dead` int(11) default NULL,
  `sellout_friday` int(11) default NULL,
  `sellout_saturday` int(11) default NULL,
  `remainder_friday` int(11) default NULL,
  `remainder_saturday` int(11) default NULL,
  `remainder_sunday` int(11) default NULL,
  `vendor_id` varchar(2) default NULL,
  `vendor_code` varchar(255) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_modifier` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;

INSERT INTO `order` (`id`, `color_id`, `common_id`, `catalog_number`, `catalog_id`, `year`, `flat_size`, `flat_cost`, `plant_cost`, `pot_size`, `price`, `count_presale`, `count_midsale`, `count_dead`, `sellout_friday`, `sellout_saturday`, `remainder_friday`, `remainder_saturday`, `remainder_sunday`, `vendor_id`, `vendor_code`, `rec_modified`, `rec_modifier`)
VALUES
	(1,1,2,NULL,NULL,2013,1,0.92,0.92,'Bulbs & Bareroots 7 for ',3,85,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'gw','','2013-03-01 12:17:51',0);

/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(55) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_verified` tinyint(1) default NULL,
  `reset_hash` varchar(32) NOT NULL COMMENT 'used for verifying password resets',
  `is_active` tinyint(1) NOT NULL,
  `db_role` enum('user','admin') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `password`, `first`, `last`, `email`, `is_verified`, `reset_hash`, `is_active`, `db_role`)
VALUES
	(1,'admin','dc9c485af2680f5b6123f46c6985485f','Chris','Dart','chrisdart@cerebratorium.com',1,'dd9ff3938d6e278d871a2caf43ef7150',1,'admin');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_log`;

CREATE TABLE `user_log` (
  `id` int(4) NOT NULL,
  `username` varchar(55) NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `action` enum('login','logout') NOT NULL,
  KEY `kTeach` (`username`),
  KEY `logTime` (`time`),
  KEY `logAction` (`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='database for tracking user logins/logouts';

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;

INSERT INTO `user_log` (`id`, `username`, `time`, `action`)
VALUES
	(1,'admin','2013-02-19 08:47:25','login'),
	(1,'admin','2013-02-19 08:51:12','login'),
	(1,'admin','2013-02-19 08:54:26','login'),
	(1,'admin','2013-02-19 08:54:27','login'),
	(1,'admin','2013-02-19 09:13:00','login'),
	(1,'admin','2013-02-25 10:10:11','login'),
	(1,'admin','2013-03-01 08:50:00','login');

/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_sessions`;

CREATE TABLE `user_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(120) default NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table vendor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vendor`;

CREATE TABLE `vendor` (
  `id` varchar(2) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
