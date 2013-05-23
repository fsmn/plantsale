<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model
{
	var $name;
	var $phone1;
	var $phone1_type;
	var $phone2;
	var $phone2_type;
	var $email;
	var $rec_modifier;
	var $rec_modified;
	
	function __construct()
	{
		parent::__construct();
	}
	
	function prepare_variables()
	{
		$variables = array("name","contact_type","phone1","phone1_type","phone2","phone2_type","email");
	
		for($i = 0; $i < count($variables); $i++){
			$my_variable = $variables[$i];
			if($this->input->post($my_variable)){
				$this->$my_variable = $this->input->post($my_variable);
			}
		}
	
		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->session->userdata('user_id');
	}
	
	function get($id)
	{
		$this->db->where("id", $id);
		$this->db->from("contact");
		$result = $this->db->get()->row();
		return $result;
	}
	
	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("contact",$this);
		return $this->db->insert_id();
	}
	
	function update($id)
	{
		$this->prepare_variables();
		$this->db->where("id", $id);
		$this->db->update("contact",$this);
	}
	
	function delete($id)
	{
		$delete = array("id"=>$id);
		$this->db->delete("contact",$delete);
	}
	
}