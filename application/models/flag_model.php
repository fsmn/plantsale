<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Flag_Model extends CI_Model
{
	var $color_id;
	var $symbol_id;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::_construct();
	}

	function prepare_variables()
	{
		$variables = array("color_id","symbol_id");

		for($i = 0; $i < count($variables); $i++){
			$my_variable = $variables[$i];
			if($this->input->post($my_variable)){
				$this->$my_variable = $this->input->post($my_variable);
			}
		}

		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->session->userdata('user_id');
	}

	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("flag",$this);
		$id = $this->db->last_insert_id();
		return $id;
	}

	function update($id, $values = array())
	{
		$this->db->where("id", $id);
		if(empty($values)){
			$this->prepare_variables();
			$this->db->update("flag",$this);
		}else{
			$this->db->update("flag",$values);
		}
	}

	function delete($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("flag");
	}
}