<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Variety_Model extends CI_Model
{
	var $common_id;
	var $species;
	var $variety;
	var $min_height;
	var $max_height;
	var $min_width;
	var $max_width;
	var $height_unit;
	var $width_unit;
	var $plant_color;
	var $note;
	var $rec_modifier;
	var $rec_modified;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("species","variety","min_height","max_height","min_width","max_width","height_unit","width_unit","note","common_id");

		for($i = 0; $i < count($variables); $i++){
			$my_variable = $variables[$i];
			if($this->input->post($my_variable)){
				$this->$my_variable = $this->input->post($my_variable);
			}
		}
		
		if($this->input->post("plant_color")){
			$this->plant_color = implode(",", $this->input->post("plant_color"));
		}

		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->session->userdata('user_id');
	}

	function insert()
	{
		$this->prepare_variables();
		$this->db->insert("variety",$this);
		$id = $this->db->insert_id();
		return $id;
	}

	function update($id, $values = array())
	{
		$this->db->where("id", $id);
		if(empty($values)){
			$this->prepare_variables();
			$this->db->update("variety",$this);
		}else{
			$this->db->update("variety",$values);
			if($values == 1){
				$keys = array_keys($values);
				return $this->get_value($id, $keys[0] );
			}
		}
	}
	


	function get($id)
	{
		$this->db->where("variety.id", $id);
		$this->db->where("variety.common_id = `common`.`id`");
		$this->db->from("variety,common");
		$this->db->select("variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,  common.category, common.description");
		$result = $this->db->get()->row();
		return $result;
	}
	
	function get_by_common($common_id)
	{
		$this->db->where("variety.common_id", $common_id);
		$this->db->from("variety");
		$this->db->select("variety.*, order.year");
		//@TODO how do we solve the question of orders only showing for current year?
		//$this->db->where("order.year", get_current_year());
		$this->db->join("order","variety.id = order.variety_id", "LEFT");
		$this->db->order_by("order.year","DESC");
		$this->db->group_by("variety.id");
		$result = $this->db->get()->result();
		
		return $result;
		
	}
	
	function get_by_name($name)
	{
		$this->db->where("`variety` LIKE '%$name%' OR `common`.`name` LIKE '%$name%' OR `variety`.`species` LIKE '%$name%' OR `common`.`genus` LIKE '%$name%'");
		$this->db->join("common","variety.common_id=common.id");
		$this->db->order_by("variety","ASC");
		$this->db->order_by("common.name","ASC");
		$this->db->select("variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,  common.category, common.description");
		
		$result = $this->db->get("variety")->result();
		return $result;
	}
	
	function get_value($id, $field)
	{
		$this->db->where("id", $id);
		$this->db->select($field);
		$this->db->from("variety");
		$output = $this->db->get()->row();
		return $output->$field;
	}
	
	function get_new_varietys($year)
	{
		$query = sprintf("SELECT variety.id FROM `variety` join `order` on `variety`.`id` = `order`.`variety_id`
  WHERE `variety`.`id` NOT IN (SELECT `variety_id` from `order` WHERE `year` < %s ) and `order`.`year` = %s", $year,$year);
		$result = $this->db->query($query)->result();
		return $result;
	}
	
	function get_varietys_for_year($year){
		$this->db->from("variety");
		$this->db->join("order","variety.id=order.variety_id");
		$this->db->where("order.year", $year);
		$result = $this->db->get()->result();
		return $result;
	}
	
	function get_category_totals($year){
		$this->db->from("variety");
		$this->db->join("order","variety.id=order.variety_id");
		$this->db->join("common","common.id=variety.common_id");
		$this->db->where("order.year",$year);
		$this->db->group_by("common.category");
		$this->db->select("count(`variety`.`id`) as count,common.category");
		$result = $this->db->get()->result();
		return $result;
		
	}
	
	function delete($id)
	{
		$this->db->delete("variety", array('id' => $id));
		$this->db->delete("order", array('variety_id' => $id));
		$this->db->delete("flag", array('variety_id' => $id));
	}
	

}