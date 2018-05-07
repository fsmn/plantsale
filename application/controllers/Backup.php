<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends MY_Controller{
	
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		ini_set('memory_limit', '4096M');
		
		// Load the DB utility class
		$this->load->dbutil();
	//	$dbs = $this->dbutil->list_databases();
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();
		$filename = sprintf("backup-%s.sql.gz",date("Y-m-d-H-i-s"));
		$path = sprintf("/tmp/");
		$temp_file = $path . $filename;
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file($temp_file, $backup);
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
	    force_download($filename, $backup);
		//*/
		redirect("/");
	}
	
	
}
