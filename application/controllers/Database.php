<?php
class Database extends MY_Controller{
	function __construct(){
		parent::__construct ();
		
	}
	function update_database(){
		$this->db->query("ALTER TABLE user_sessions CHANGE id id varchar(128) NOT NULL;");
	}
}

