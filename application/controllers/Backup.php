<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends MY_Controller{
	
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$this->load->dbutil();
		$tables = $this->db->query("SHOW TABLES")->result();
		$data['target'] = "backup/control";
		$data['title'] = "Backup Data Tables";
		foreach($tables as $table => $item){
			foreach($item as $string){
				$data['tables'][] = $string;
			}
			
		}
		$this->load->view('page/index',$data);
		
	}
	
	function backup_table($table){
		ini_set('memory_limit', '4096M');
		
		// Load the DB utility class
		$this->load->dbutil();
		//	$dbs = $this->dbutil->list_databases();
		// Backup your entire database and assign it to a variable
		$prefs = array('tables'=>array($table));
		$backup = $this->dbutil->backup($prefs);
		$filename = sprintf("backup-%s-%s.sql.gz",$table, date("Y-m-d-H-i-s"));
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
	
	function get_csv($table=NULL){
		$this->load->dbutil();
		$query = NULL;
		$query = ("SELECT * FROM `$table`");
		$filename = sprintf('backup-%s-%s.csv',date("Y-m-d-H-i-s"));
		$path = sprintf("/tmp/");
		$temp_file = $path . $filename;
		$delimiter = ",";
		$newline = "\r\n";
		$enclosure = '"';
		$query = $this->db->query($query);
		$backup =  $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
		$this->load->helper('file');
		write_file($temp_file, $backup);
		$this->load->helper('download');
		force_download($filename,$backup);
		sleep(5);
		
		
	}
	

}
