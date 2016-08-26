<?php
class Database extends MY_Controller{
	function __construct(){
		parent::__construct ();
		
	}
	function update_database(){
		$this->db->query("ALTER TABLE `variety` ADD `churn_value` INT  NULL  DEFAULT NULL  AFTER `edit_notes`;");
		$this->db->query("
REPLACE INTO `menu` (`id`, `category`, `key`, `value`, `rec_modified`, `rec_modifier`, `rec_created`)
VALUES
	(65, 'churn_value', '2', '2', '2016-08-26 13:14:56', NULL, NULL),
	(66, 'churn_value', '3', '3', '2016-08-26 13:15:05', NULL, NULL),
	(67, 'churn_value', '0', 'None', '2016-08-26 13:19:29', NULL, NULL);");
	}
}