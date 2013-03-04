# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.67-0ubuntu0.11.10.1)
# Database: plantsaledb
# Generation Time: 2013-03-04 12:25:15 -0600
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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `common_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(255) DEFAULT NULL,
  `height` varchar(25) DEFAULT NULL,
  `width` varchar(25) DEFAULT NULL,
  `note` text,
  `rec_modifier` int(11) NOT NULL,
  `rec_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;

INSERT INTO `color` (`id`, `common_id`, `name`, `color`, `height`, `width`, `note`, `rec_modifier`, `rec_modified`)
VALUES
	(1,2,'Floristan White','White','24-36\"',NULL,'8-10 cm bulbs.',1,'2013-02-28 22:21:11');

/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table common
# ------------------------------------------------------------

DROP TABLE IF EXISTS `common`;

CREATE TABLE `common` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `species` varchar(255) DEFAULT '',
  `genus` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT '',
  `description` text,
  `comments` text,
  `light_requirements` varchar(255) DEFAULT NULL,
  `latin_name` varchar(255) DEFAULT NULL,
  `rec_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rec_modifier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `common` WRITE;
/*!40000 ALTER TABLE `common` DISABLE KEYS */;

INSERT INTO `common` (`id`, `name`, `species`, `genus`, `category`, `subcategory`, `description`, `comments`, `light_requirements`, `latin_name`, `rec_modified`, `rec_modifier`)
VALUES
	(1,'Test','Testus',NULL,NULL,'','The poodle is near midnight. ',NULL,NULL,'T. Examen','2013-02-19 11:04:25',1),
	(2,'Blazing Star','spicata','liatris','Perennials',NULL,'Long flowers spikes. Seeds eaten by birds. Best in groups. Drought tolerant, but loves water, too. ',NULL,NULL,NULL,'2013-03-01 14:39:16',1);

/*!40000 ALTER TABLE `common` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table flag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flag`;

CREATE TABLE `flag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(55) DEFAULT '',
  `value` varchar(55) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
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
	(11,'common_category','Vegetables','Vegetables'),
	(12,'db_role','Admin','Admin'),
	(13,'db_role','User','User'),
	(14,'user_status','Active','Active'),
	(15,'user_status','Inactive','Inactive');

/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `color_id` int(11) NOT NULL,
  `common_id` int(11) NOT NULL,
  `catalog_number` varchar(15) DEFAULT NULL,
  `catalog_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `flat_size` int(11) DEFAULT NULL,
  `flat_cost` varchar(11) DEFAULT NULL,
  `plant_cost` varchar(11) DEFAULT NULL,
  `pot_size` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `count_presale` int(11) DEFAULT NULL,
  `count_midsale` int(11) DEFAULT NULL,
  `count_dead` int(11) DEFAULT NULL,
  `sellout_friday` int(11) DEFAULT NULL,
  `sellout_saturday` int(11) DEFAULT NULL,
  `remainder_friday` int(11) DEFAULT NULL,
  `remainder_saturday` int(11) DEFAULT NULL,
  `remainder_sunday` int(11) DEFAULT NULL,
  `vendor_id` varchar(2) DEFAULT NULL,
  `vendor_code` varchar(255) DEFAULT NULL,
  `rec_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rec_modifier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;

INSERT INTO `order` (`id`, `color_id`, `common_id`, `catalog_number`, `catalog_id`, `year`, `flat_size`, `flat_cost`, `plant_cost`, `pot_size`, `price`, `count_presale`, `count_midsale`, `count_dead`, `sellout_friday`, `sellout_saturday`, `remainder_friday`, `remainder_saturday`, `remainder_sunday`, `vendor_id`, `vendor_code`, `rec_modified`, `rec_modifier`)
VALUES
	(1,1,2,NULL,NULL,2013,1,'0.92 ','0.92','Bulbs & Bareroots 7 for ',3,85,0,NULL,NULL,0,0,0,NULL,'gw',NULL,'2013-03-04 12:06:53',0);

/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT NULL,
  `reset_hash` varchar(32) NOT NULL COMMENT 'used for verifying password resets',
  `is_active` varchar(32) NOT NULL DEFAULT '',
  `db_role` enum('user','admin') NOT NULL,
  `rec_modified` timestamp NULL DEFAULT NULL,
  `rec_modifier` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `password`, `first`, `last`, `email`, `is_verified`, `reset_hash`, `is_active`, `db_role`, `rec_modified`, `rec_modifier`)
VALUES
	(1,'admin','05e10fb316046c0c7771c0de4f26eb2e','Chris','Dart','chrisdart@cerebratorium.com',1,'04564c9b5f86e74697934335d4e61066','Active','admin',NULL,NULL),
	(2,'pat','','Pat','Thompson','pat@marksimonson.com',NULL,'','Active','admin',NULL,NULL),
	(3,'test','13292e01b77ae7a4dc73c8b77cf9587c','Test','Nostril','chris@cerebratorium.com',NULL,'','Active','user',NULL,NULL),
	(4,'testy','','Test','User','technology@cerebratorium.com',NULL,'','Active','user','2013-03-01 15:20:03',1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_log`;

CREATE TABLE `user_log` (
  `id` int(4) NOT NULL,
  `username` varchar(55) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
	(1,'admin','2013-02-28 21:13:14','login'),
	(1,'admin','2013-03-01 13:39:28','login'),
	(1,'admin','2013-03-01 14:46:58','logout'),
	(1,'admin','2013-03-01 14:47:03','login'),
	(3,'test','2013-03-04 12:04:49','login');

/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_sessions`;

CREATE TABLE `user_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table vendor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vendor`;

CREATE TABLE `vendor` (
  `id` varchar(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
