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
	
	function get_by_name($name)
	{
		$this->db->where("`color` LIKE '%$name%' OR `common`.`name` LIKE '%$name%' OR `color`.`species` LIKE '%$name%' OR `common`.`genus` LIKE '%$name%'");
		$this->db->join("common","color.common_id=common.id");
		$this->db->order_by("color","ASC");
		$this->db->order_by("common.name","ASC");
		$this->db->select("color.*, color.id as id, color.common_id as common_id, common.name as common_name, common.genus,  common.category, common.description");
		
		$result = $this->db->get("color")->result();
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
	
	function get_new_colors($year)
	{
		$query = sprintf("SELECT color.id FROM `color` join `order` on `color`.`id` = `order`.`color_id`
  WHERE `color`.`id` NOT IN (SELECT `color_id` from `order` WHERE `year` < %s ) and `order`.`year` = %s", $year,$year);
		$result = $this->db->query($query)->result();
		return $result;
	}
	
	function get_colors_for_year($year){
		$this->db->from("color");
		$this->db->join("order","color.id=order.color_id");
		$this->db->where("order.year", $year);
		$result = $this->db->get()->result();
		return $result;
	}
	
	function get_category_totals($year){
		$this->db->from("color");
		$this->db->join("order","color.id=order.color_id");
		$this->db->join("common","common.id=color.common_id");
		$this->db->where("order.year",$year);
		$this->db->group_by("common.category");
		$this->db->select("count(`color`.`id`) as count,common.category");
		$result = $this->db->get()->result();
		return $result;
		
	}
	
	function delete($id)
	{
		$this->db->delete("color", array('id' => $id));
		$this->db->delete("order", array('color_id' => $id));
		$this->db->delete("flag", array('color_id' => $id));
	}
	

}