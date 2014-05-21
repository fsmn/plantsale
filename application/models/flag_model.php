<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Flag_Model extends CI_Model
{
	var $variety_id;
	var $name;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("variety_id","name");

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
		$id = $this->db->insert_id();
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

	function get_for_variety($variety_id){
		$this->db->where("variety_id",$variety_id);
		$this->db->from("flag");
		$this->db->select("flag.*,icon.source,icon.thumbnail");
		$this->db->join("menu","flag.name=menu.key");
		$this->db->join("icon","menu.id=icon.menu_id");
		$output = $this->db->get()->result();
		return $output;
	}

	/**
	 * finds all the flags for a variety and returns a key-value pair multi-array
	 * @param unknown $variety_id
	 * @return array
	 */
	function get_missing($variety_id){
		$current_flags = $this->get_for_variety($variety_id);
		$flag_list = array();
		foreach($current_flags as $current_flag){
			$flag_list[] = $current_flag->name;
		}
		$query = sprintf("SELECT `key`, `value` FROM `menu` WHERE `category` = 'flag' AND `value` not in ('%s')",implode("','", $flag_list));
		
		$output = $this->db->query($query)->result();

		return $output;
	}

}