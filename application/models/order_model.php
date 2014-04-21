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
			$this->db->update("order",$this);
		}else{
			$this->db->update("order",$values);
			if(count($values) == 1){
				$keys = array_keys($values);
				return $this->get_value($id, $keys[0] );
			}
		}
	}

	function get($id)
	{
		$this->db->where("order.id", $id);
		$this->db->from("order,color");
		$this->db->where("`order`.`color_id` = `color`.`id`");
		$this->db->select("order.*, color.color");
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
	
	function get_by_category($category, $sale_year,$order_by = "catalog_number"){
		$this->db->from("order");
		$this->db->join("color","order.color_id = color.id");
		$this->db->join("common","color.common_id = common.id");
		$this->db->where("common.category",$category);
		$this->db->where("order.year", $sale_year);
		$this->db->order_by("catalog_number");
		$this->db->select("order.id,vendor_id, order.year, order.catalog_number, order.flat_size, order.flat_cost, order.plant_cost, order.pot_size, order.price,order.count_presale, order.count_midsale,order.vendor_code");
		$this->db->select("color.color, color.species");
		$this->db->select("common.name, common.genus, common.category");
		$result = $this->db->get()->result();
		return $result;
	}
	
	function get_current_year()
	{
		$this->db->from("order");
		$this->db->order_by("year","DESC");
		$this->db->group_by("year");
		$this->db->limit(1);
		$result = $this->db->get()->row();
		return $result->year;
		
	}
	
	function get_previous_year($color_id, $current_year){
		$this->db->from("order");
		$this->db->where("color_id", $color_id);
		$this->db->where("year <",$current_year);
		$this->db->order_by("year","DESC");
		$this->db->group_by("year");
		$this->db->limit(1);
		$result = $this->db->get()->row();
		return $result;
	}

	function get_value($id, $field)
	{
		$this->db->where("id", $id);
		$this->db->select($field);
		$this->db->from("order");
		$output = $this->db->get()->row();
		return $output->$field;
	}
	
	function get_plant_total($year){
		//sum(flat_size * (count_presale + count_midsale))
		$query = sprintf("SELECT sum((`count_presale` + `count_midsale`)) as `total` FROM `order` where `year` = '%s' ",$year);
		$result = $this->db->query($query)->row();
		return $result->total;
		
	}
	
	function get_price_range($year = NULL){
		$this->db->from("order");
		$this->db->select("min(`plant_cost`) as `min_price`, max(`plant_cost`) as `max_price` , avg(`plant_cost`) as `average_price`");
		$this->db->where("year", $year);
		$result = $this->db->get()->row();
		return $result;
	}
	



}