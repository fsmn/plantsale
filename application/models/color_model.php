<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Color_Model extends CI_Model
{
	var $common_id;
	var $name;
	var $color;
	var $height;
	var $width;
	var $notes;
	var $rec_modifier;
	var $rec_modified;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("name","species","genus","description","latin_name");

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
		$this->insert("color",$this);
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
		$this->db->where("color.common_id = common.id");
		$this->db->from("color,common");
		$this->db->join("flag","flag.color_id = color.id");
		$this->db->join("order","order.color_id = color.id");
		$this->db->join("menu","menu.id = flag.menu_id");
		$this->db->order_by("flag.","asc");
		$this->db->order_by("menu.value");
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