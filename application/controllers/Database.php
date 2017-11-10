<?php
class Database extends MY_Controller {

	function __construct()
	{
		parent::__construct ();
	}

	function update_database()
	{
		$output = array ();
		$table = $this->db->escape_str ( "user_sessions" );
		$sql = "DESCRIBE `$table`";
		$desc = $this->db->query ( $sql )->result ();
		foreach ( $desc as $item ) {
			if ($item->Field == "id" && $item->Type != "varchar(128)") {
				if ($this->db->query ( "ALTER TABLE user_sessions CHANGE id id varchar(128) NOT NULL;" )) {
					$output [] = "User Sessions Updated";
				} else {
					$output [] = "User Sessions Update Failed due to the following error: " . $this->db->error ();
				}
			}
		}
		$precount = $this->db->count_all ( 'user_sessions' );
		if ($this->db->query ( "DELETE from user_sessions where `timestamp` < unix_timestamp(now()) - 168000" )) {
			$postcount = $this->db->count_all ( 'user_sessions' );
			$output [] = sprintf ( "%s old records removed from `user_sessions` table", $precount - $postcount );
		} else {
			$output [] = "User sessions not cleared of old data due the following error: " . $this->db->error ();
		}
		if (empty ( $output )) {
			$message = "No Database Updates";
		} else {
			$message = implode ( "</br>", $output );
		}
		$this->session->set_flashdata ( "notice", $message );
		redirect ( "/" );
	}
}

