<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model
{

	var $name;
	var $genus;
	var $description;
	var $comment;
	var $category;
	var $subcategory;
	var $sunlight;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("name","genus","description","comment","category","subcategory","sunlight");

		for($i = 0; $i < count($variables); $i++){
			$my_variable = $variables[$i];
			if($this->input->post($my_variable)){
				if($my_variable == "sunlight"){
					$this->$my_variable = join(",", $this->input->post($my_variable));
				}
				$this->$my_variable = $this->input->post($my_variable);
			}
		}

		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->session->userdata('user_id');
	}
	

	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("common",$this);
		$id = $this->db->insert_id();
		return $id;
	}

	function update($id, $values = array())
	{
		$this->db->where("id", $id);
		if(empty($values)){
			$this->prepare_variables();
			$this->db->update("common",$this);
		}else{
			$this->db->update("common",$values);
				$keys = array_keys($values);
				return $this->get_value($id, $keys[0] );
		}
	}


	function get($id)
	{
		$this->db->where("id", $id);
		$this->db->from("common");
		$output = $this->db->get()->row();
		return $output;
	}

	function get_by_name($name)
	{
		$this->db->where("`name` LIKE '%$name%' OR `genus` LIKE '%$name%'");
		$this->db->order_by("name","ASC");
		$this->db->order_by("genus","ASC");
		$result = $this->db->get("common")->result();
		return $result;
	}

	function get_value($id, $field)
	{
		$this->db->where("id", $id);
		$this->db->select($field);
		$this->db->from("common");
		$output = $this->db->get()->row();
		return $output->$field;
	}




}