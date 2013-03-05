<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_Model extends CI_Model
{
	var $color_id;
	var $vendor_id;
	var $catalog_number;
	var $catalog_id;
	var $year;
	var $flat_size;
	var $flat_cost;
	var $pot_size;
	var $plant_cost;
	var $price;
	var $count_presale;
	var $count_midsale;
	var $count_dead;
	var $sellout_friday;
	var $sellout_saturday;
	var $remainder_friday;
	var $remainder_saturday;
	var $remainder_sunday;
	var $vendor_code;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("color_id","vendor_id","catalog_number",
				"catalog_id","year", "flat_size","flat_cost","pot_size",
				"plant_cost","price","count_presale","count_midsale","count_dead",
				"sellout_friday","sellout_saturday","remainder_friday",
				"remainder_saturday","remainder_sunday","vendor_code",
		);

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
		$this->db->insert("order", $this);
		$id = $this->db->insert_id();
		return $id;
	}

	function update($id, $values = array())
	{
		$this->db->where("id", $id);
		if(empty($values)){
			$this->prepare_variables();
			$this->db->update("order", $this);
		}else{
			$this->db->update("order", $values);
			$keys = array_keys($values);
			return $this->get_value($id, $keys[0] );
		}
	}

	function get($id)
	{
		$this->db->where("order.id", $id);
		$this->db->from("order,color");
		$this->db->where("`order`.`color_id` = `color`.`id`");
		$output = $this->db->get()->row();
		return $output;
	}

	function get_for_color($color_id, $year = NULL)
	{
		$this->db->where("color_id", $color_id);
		if($year){
			$this->db->where("year", $year);
		}
		$this->db->from("order");
		$this->db->order_by("year","desc");
		if($year){
			$output = $this->db->get()->row();
		}else{
			$output = $this->db->get()->result();
		}
		return $output;
	}

	function get_value($id, $field)
	{
		$this->db->where("id", $id);
		$this->db->select($field);
		$this->db->from("order");
		$output = $this->db->get()->row();
		return $output->$field;
	}


}