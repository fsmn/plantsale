<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Color_Model extends CI_Model
{
	var $common_id;
	var $name;
	var $color;
	var $height;
	var $width;
	var $note;
	var $rec_modifier;
	var $rec_modified;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("name","color","height","width","note","common_id");

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
		}
	}


	function get($id)
	{
		$this->db->where("color.id", $id);
		$this->db->where("color.common_id = `common`.`id`");
		$this->db->from("color,common");
		$this->db->select("color.*, common.name as common_name, common.species, common.genus, common.latin_name, common.category, common.description,order.id as order_id, order.*");
		$this->db->join("order","order.color_id = color.id AND `order`.`year` = ". get_current_year(), "LEFT");
		$result = $this->db->get()->row();
		return $result;
	}
	
	function get_by_common($common_id)
	{
		$this->db->where("color.common_id", $common_id);
		$this->db->from("color");
		$this->db->join("order","color.id = order.color_id");
		$this->db->order_by("order.year","DESC");
		$result = $this->db->get()->result();
		return $result;
		
	}
	
	

}