<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help_model extends CI_Model
{
	var $topic;
	var $subtopic;
	var $text;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("topic","subtopic","text");
		for($i = 0; $i < count($variables); $i++){
			$myVariable = $variables[$i];
			if($this->input->post($myVariable)){
				$this->$myVariable = $this->input->post($myVariable);
			}
		}

		//$this->recModified = mysql_timestamp();
		//$this->recModifier = $this->session->userdata('userID');
	}

	function get($topic,$subtopic=NULL)
	{
		$this->db->select("text");
		$this->db->where("topic", $topic);
		if($subtopic){
			$this->db->where("subtopic", $subtopic);
		}
		$this->db->from("help");
		$row = $this->db->get()->row();
		return $row->text;
	}//end showHelp

}