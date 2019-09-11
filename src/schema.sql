# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.0.92-log)
# Database: plantsaledb
# Generation Time: 2016-03-22 18:44:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Each common plant (genus) must have a category and a subcate';



# Dump of table common
# ------------------------------------------------------------

DROP TABLE IF EXISTS `common`;

CREATE TABLE `common` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `subcategory_id` int(11) default NULL,
  `name` varchar(255) NOT NULL default '',
  `genus` varchar(255) default NULL,
  `description` text,
  `other_names` varchar(255) default NULL,
  `sunlight` varchar(255) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_modifier` int(11) default NULL,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`),
  KEY `subcategory_id` (`subcategory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='this table contains all the common (parent plants, or genus)';



# Dump of table common_archive
# ------------------------------------------------------------

DROP TABLE IF EXISTS `common_archive`;

CREATE TABLE `common_archive` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `common_id` int(11) unsigned NOT NULL,
  `old_description` text,
  `extended_description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table contact
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contact`;

CREATE TABLE `contact` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `grower_id` varchar(2) default NULL,
  `contact_type` varchar(20) default NULL,
  `name` varchar(255) default NULL,
  `phone1` varchar(25) default NULL,
  `phone1_type` varchar(11) default NULL,
  `phone2` varchar(255) default '',
  `phone2_type` varchar(11) default NULL,
  `email` varchar(255) default NULL,
  `notes` varchar(255) default NULL,
  `rec_modifier` int(11) NOT NULL default '1',
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `grower_id` (`grower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='these are contacts related to vendors.';



# Dump of table copy_edits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `copy_edits`;

CREATE TABLE `copy_edits` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `entity_id` int(11) default NULL,
  `entity_type` varchar(25) default NULL,
  `entity_field` varchar(25) default NULL,
  `copy_text` text,
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains edits to the common.description, variety';



# Dump of table flag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flag`;

CREATE TABLE `flag` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `variety_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_modifier` int(11) NOT NULL default '1',
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `variety_id` (`variety_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Every variety may have one or more flags. Each flag is conne';



# Dump of table flag_token
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flag_token`;

CREATE TABLE `flag_token` (
  `flag` varchar(25) collate utf8_unicode_ci NOT NULL default '',
  `token` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`flag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='flag_token is the font information for flags whenever flags ';



# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='this is a part of the ion_auth tool used for user authentica';



# Dump of table grower
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grower`;

CREATE TABLE `grower` (
  `id` varchar(2) NOT NULL default '',
  `user_id` int(3) default NULL COMMENT 'the user identified as the internal contact for this grower',
  `grower_name` varchar(255) NOT NULL default '',
  `street_address` varchar(255) default NULL,
  `po_box` varchar(25) default NULL,
  `city` varchar(50) default NULL,
  `state` varchar(2) default NULL,
  `zip` varchar(15) default NULL,
  `country` enum('USA','CANADA') default 'USA',
  `website` varchar(255) default NULL,
  `email` varchar(50) default NULL,
  `phone` varchar(15) default NULL,
  `fax` varchar(15) default NULL,
  `shipping_notes` text,
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table help
# ------------------------------------------------------------

DROP TABLE IF EXISTS `help`;

CREATE TABLE `help` (
  `id` int(4) NOT NULL auto_increment,
  `topic` varchar(55) NOT NULL,
  `subtopic` varchar(55) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='provides help text that can be summoned based on query';



# Dump of table icon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `icon`;

CREATE TABLE `icon` (
  `menu_id` int(11) NOT NULL COMMENT 'menu key of the menu item source',
  `source` varchar(255) NOT NULL default '' COMMENT 'path to icon image',
  `thumbnail` varchar(255) default NULL,
  PRIMARY KEY  (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='The icons are associated with flags. This table contains the';



# Dump of table image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `id` int(11) NOT NULL auto_increment,
  `variety_id` int(11) NOT NULL COMMENT 'fk variety',
  `image_name` varchar(255) NOT NULL default '',
  `image_source` varchar(255) NOT NULL default '',
  `image_type` varchar(30) NOT NULL default '',
  `image_size` int(11) NOT NULL,
  `image_path` text NOT NULL,
  `rec_modifier` int(4) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `variety_id` (`variety_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='images for varieties';



# Dump of table login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  `key` varchar(55) default '',
  `value` varchar(55) NOT NULL default '',
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_modifier` int(11) default NULL,
  `rec_created` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `variety_id` int(11) NOT NULL,
  `grower_id` varchar(2) default NULL,
  `catalog_number` varchar(15) default NULL,
  `year` int(11) default NULL,
  `flat_size` varchar(15) default NULL,
  `flat_cost` decimal(10,2) default NULL,
  `flat_area` varchar(11) NOT NULL default '2' COMMENT 'square footage of a given flat',
  `tiers` int(11) NOT NULL default '3' COMMENT 'Number of tiers the flats are stacked at sale',
  `plant_cost` decimal(10,2) default NULL,
  `pot_size` varchar(255) default NULL,
  `price` decimal(10,2) default NULL,
  `count_presale` decimal(10,2) default '0.00',
  `count_midsale` decimal(10,2) default '0.00',
  `received_presale` decimal(10,3) default '0.000',
  `received_midsale` decimal(10,3) default '0.000',
  `count_dead` decimal(10,3) default '0.000',
  `sellout_friday` varchar(20) default NULL,
  `sellout_saturday` varchar(20) default NULL,
  `remainder_friday` decimal(10,3) default NULL,
  `remainder_saturday` decimal(10,3) default NULL,
  `remainder_sunday` decimal(10,3) default NULL,
  `grower_code` varchar(255) default NULL,
  `omit` tinyint(4) default NULL,
  `crop_failure` int(1) default '0',
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_modifier` int(11) NOT NULL,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `variety_id` (`variety_id`),
  KEY `grower_id` (`grower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table parent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `parent`;

CREATE TABLE `parent` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='for parents of common plants like tomatoes';



# Dump of table preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `preferences`;

CREATE TABLE `preferences` (
  `id` varchar(25) NOT NULL default '',
  `name` varchar(255) NOT NULL COMMENT 'human-readable name of the preference',
  `description` text NOT NULL,
  `options` varchar(40) NOT NULL,
  `format` varchar(26) NOT NULL,
  `weight` int(11) NOT NULL COMMENT 'weight in the list of preferences',
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `rec_created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table subcategory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subcategory`;

CREATE TABLE `subcategory` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `subcategory` varchar(255) NOT NULL default '',
  `rec_modifier` int(11) default NULL,
  `rec_created` timestamp NULL default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_log`;

CREATE TABLE `user_log` (
  `id` int(4) NOT NULL,
  `username` varchar(55) NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `action` enum('login','logout','shmallow') character set utf8 collate utf8_unicode_ci NOT NULL default 'login'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='database for tracking user logins/logouts';



# Dump of table user_preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_preferences`;

CREATE TABLE `user_preferences` (
  `user_id` int(11) NOT NULL,
  `preference_id` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`user_id`,`preference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_sessions`;

CREATE TABLE `user_sessions` (
  `id` varchar(40) collate utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) collate utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL default '0',
  `data` blob NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) default NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) default NULL,
  `forgotten_password_code` varchar(40) default NULL,
  `forgotten_password_time` int(11) unsigned default NULL,
  `remember_code` varchar(40) default NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned default NULL,
  `active` tinyint(1) unsigned default NULL,
  `first_name` varchar(50) default NULL,
  `last_name` varchar(50) default NULL,
  `company` varchar(100) default NULL,
  `phone` varchar(20) default NULL,
  `rec_modifier` int(11) default NULL,
  `rec_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table variety
# ------------------------------------------------------------

DROP TABLE IF EXISTS `variety`;

CREATE TABLE `variety` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `common_id` int(11) NOT NULL,
  `web_id` int(11) default NULL,
  `species` varchar(255) default NULL,
  `variety` varchar(255) default NULL,
  `plant_color` varchar(255) default NULL,
  `min_height` varchar(10) default NULL,
  `max_height` varchar(10) default NULL,
  `height_unit` varchar(255) default NULL,
  `min_width` varchar(10) default NULL,
  `max_width` varchar(10) default NULL,
  `width_unit` varchar(255) default NULL,
  `web_description` text,
  `print_description` text,
  `new_year` int(4) default NULL,
  `needs_bag` int(4) default NULL COMMENT 'This variety is always sold as a bare root, bulb or seed root',
  `needs_copy_review` varchar(4) character set utf8 collate utf8_unicode_ci default 'yes' COMMENT 'Yes if the copy for the variety or common requires review',
  `editor` varchar(3) default NULL COMMENT 'person responsible for reviewing edits',
  `copywriter` varchar(25) character set utf8 collate utf8_unicode_ci default NULL COMMENT 'person assigned to do edits',
  `copy_received` varchar(10) character set utf8 collate utf8_unicode_ci default NULL COMMENT 'yes/no copy has been received',
  `edit_notes` varchar(255) character set utf8 collate utf8_unicode_ci default NULL COMMENT 'notes related to the copy editing status',
  `rec_modifier` int(11) NOT NULL,
  `rec_created` timestamp NULL default NULL,
  `rec_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `common_id` (`common_id`),
  KEY `web_id` (`web_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table variety_archive
# ------------------------------------------------------------

DROP TABLE IF EXISTS `variety_archive`;

CREATE TABLE `variety_archive` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `common_id` int(11) NOT NULL,
  `variety_id` varchar(255) default NULL,
  `print_description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
