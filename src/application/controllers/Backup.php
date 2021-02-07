<?php

defined('BASEPATH') or exit ('No direct script access allowed');

class Backup extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->load->dbutil();
		$tables = $this->db->query("SHOW TABLES")->result();
		$data ['target'] = "backup/control";
		$data ['title'] = "Backup Data Tables";
		foreach ($tables as $table => $item) {
			foreach ($item as $string) {
				$data ['tables'] [] = $string;
			}
		}
		$this->load->view('page/index', $data);
	}

	function backup_table($table, $type = "sql") {
		if ($type == "sql") {
			ini_set('memory_limit', '4096M');

			// Load the DB utility class
			$this->load->dbutil();
			if ($table == "user_sessions") {
				$this->db->query("DELETE FROM `user_sessions` WHERE timestamp < UNIX_TIMESTAMP() - 5000");
			}

			if (!is_array($table)) {
				$table = [$table];
			}
			$prefs = [
				'tables' => $table,
			];
			// Backup your entire database and assign it to a variable

			$backup = $this->dbutil->backup($prefs);

			$filename = sprintf("%s-backup-%s.sql.gz", join("_", $table), date("Y-m-d-H-i-s"));
			$path = sprintf("/tmp/");
			$temp_file = $path . $filename;
			// Load the file helper and write the file to your server
			$this->load->helper('file');
			write_file($temp_file, $backup);
			// Load the download helper and send the file to your desktop
			$this->load->helper('download');
			force_download($filename, $backup);
		}
		elseif ($type == "csv") {
			$this->_backup_csv($table);
		}
		redirect("/");
	}

	function full_backup() {
		ini_set('memory_limit', '4096M');
		$this->db->query("DELETE FROM `user_sessions` WHERE timestamp < UNIX_TIMESTAMP() - 5000");
		$this->db->query('TRUNCATE table `login_attempts`');
		// Load the DB utility class
		//ignore certain tables
		$this->load->dbutil();
		// $settings = array('ignore'=> array('user_log', 'login_attempts'));
		$settings = [];
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup($settings);
		$filename = sprintf("backup-%s.sql.gz", date("Y-m-d-H-i-s"));
		$path = sprintf("/tmp/");
		$temp_file = $path . $filename;
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file($temp_file, $backup);
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($filename, $backup);
		redirect("/");
	}

	function _backup_csv($table) {
		$this->load->dbutil();
		$query = NULL;
		$query = ("SELECT * FROM `$table`");
		$filename = sprintf('s%-backup-%s.csv', $table, date("Y-m-d-H-i-s"));
		$path = sprintf("/tmp/");
		$temp_file = $path . $filename;
		$delimiter = ",";
		$newline = "\r\n";
		$enclosure = '"';
		$query = $this->db->query($query);
		$backup = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
		$this->load->helper('file');
		write_file($temp_file, $backup);
		$this->load->helper('download');
		force_download($filename, $backup);
		redirect("/");
	}

	function critical() {
		$this->backup_table([
			'category',
			'common',
			'flag',
			'grower',
			'image',
			'orders',
			'subcategory',
			'users',
			'variety',
		]);
	}

}
