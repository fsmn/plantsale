<?php


class Logs extends MY_Controller {


	function __construct() {
		parent::__construct();
		$this->load->helper('directory');
		$this->load->helper('file');
	}

	function index() {

		// get a list of the files in the logs directory
		$files = get_filenames(APPPATH . 'logs', TRUE);
		$file_list = [];

		foreach ($files as $file) {
			$file_info = get_file_info($file);
			$extension = pathinfo($file, PATHINFO_EXTENSION);
			if ($extension == 'php') {
				$file_list[] = pathinfo($file, PATHINFO_FILENAME);
			}
		}
		$data['file_list'] = $file_list;
		$data['title'] = 'Log Files';
		$data['target'] = 'logs/list';
		$this->load->view('page/index', $data);
	}

	function read($file) {
		$contents = fopen(APPPATH . 'logs/' . $file . '.php', 'r');
		$rows = [];
		$types = [];
		while ($row = fgets($contents)) {
			$row = str_replace(PHP_EOL, '', $row);
			if ($row != "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>" && !empty($row)) {
				$row_values = preg_split('/ - /', $row);
				$rows[] = $row_values;
				$types[$row_values[0]] = $row_values[0];

			}
		}
		$data['rows'] = $rows;
		$data['types'] = $types;
		$data['title'] = $file;
		$data['target'] = 'logs/view';
		$this->load->view('page/index', $data);
	}

}
