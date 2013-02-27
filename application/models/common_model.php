<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model
{

	var $name;
	var $species;
	var $genus;
	var $description;
	var $latin_name;
	var $category;
	var $subcategory;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("name","species","genus","description","latin_name","category","subcategory");

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
		$this->db->where("`name` LIKE '%$name%'");
		$this->db->order_by("name","ASC");
		$this->db->order_by("genus","ASC");
		$result = $this->db->get("common")->result();
		return $result;
	}





}