<?php
class Database extends MY_Controller{
	function __construct(){
		parent::__construct ();
		
	}
	function update_database(){
		//$this->db->query("ALTER TABLE `variety` CHANGE `copy_received` `copy_received` VARCHAR(10)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT 'no'  COMMENT 'yes/no copy has been received';");
	}
}