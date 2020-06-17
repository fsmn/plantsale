<?php
class Database extends MY_Controller {

	function __construct()
	{
		parent::__construct ();
	}

	function update_database()
	{
		$message = NULL;
$query = sprintf('CREATE TABLE IF NOT EXISTS `backoffice`.`settings` (  `name` VARCHAR(254) NOT NULL UNIQUE, `label` VARCHAR(254) NOT NULL , `value` VARCHAR(254) NOT NULL , PRIMARY KEY (`name`)) ENGINE = InnoDB;');
$this->db->query($query);

		$this->session->set_flashdata ( "notice", $message );
		redirect ( "/" );
	}
}

