<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Color_Model extends CI_Model
{
	var $common_id;
	var $species;
	var $color;
	var $min_height;
	var $max_height;
	var $min_width;
	var $max_width;
	var $height_unit;
	var $width_unit;
	var $note;
	var $rec_modifier;
	var $rec_modified;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("species","color","min_height","max_height","min_width","max_width","height_unit","width_unit","note","common_id");

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
		$this->db->insert("color",$this);
		$id = $this->db->insert_id();
		return $id;
	}

	function update($id, $values = array())
	{
		$this->db->where("id", $id);
		if(empty($values)){
			$this->prepare_variables();
			$this->db->update("color",$this);
		}else{
			$this->db->update("color",$values);
			if($values == 1){
				$keys = array_keys($values);
				return $this->get_value($id, $keys[0] );
			}
		}
	}
	


	function get($id)
	{
		$this->db->where("color.id", $id);
		$this->db->where("color.common_id = `common`.`id`");
		$this->db->from("color,common");
		$this->db->select("color.*, color.id as id, color.common_id as common_id, common.name as common_name, common.genus,  common.category, common.description");
		$result = $this->db->get()->row();
		return $result;
	}
	
	function get_by_common($common_id)
	{
		$this->db->where("color.common_id", $common_id);
		$this->db->from("color");
		$this->db->select("color.*, order.year");
		//@TODO how do we solve the question of orders only showing for current year?
		//$this->db->where("order.year", get_current_year());
		$this->db->join("order","color.id = order.color_id", "LEFT");
		$this->db->order_by("order.year","DESC");
		$this->db->group_by("color.id");
		$result = $this->db->get()->result();
		
		return $result;
		
	}
	
	function get_value($id, $field)
	{
		$this->db->where("id", $id);
		$this->db->select($field);
		$this->db->from("color");
		$output = $this->db->get()->row();
		return $output->$field;
	}
	

}