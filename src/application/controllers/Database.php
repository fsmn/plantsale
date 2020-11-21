<?php
class Database extends MY_Controller {

	function __construct()
	{
		parent::__construct ();
	}

	function update_database(){
		$fields = ['count_wednesday','count_thursday','count_friday','count_saturday','received_presale','received_wednesday','received_thursday','received_friday','received_saturday'];
		$previous_field = 'received_presale';
		$success = [];
		$failure = [];
		foreach($fields as $field) {
			try {
				$this->db->query('ALTER TABLE `orders` ADD `' . $field . '` DECIMAL(10,2) NULL AFTER `'. $previous_field . '`;');
				$success[] = $field;
			} catch (Exception $exception) {
				$failure[] = $field;
			}
			$previous_field = $field;
		}
		$message = sprintf('Succesful updates: %s<br/>Errors: %s', implode(', ', $success), implode(', ', $failure));

		$this->session->set_flashdata ( "notice", $message );
		redirect();

	}

}

