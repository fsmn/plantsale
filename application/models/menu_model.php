<?php defined('BASEPATH') OR exit('No direct script access allowed');

// symbol_model.php Chris Dart Feb 17, 2013 5:21:15 PM chrisdart@cerebratorium.com

class Menu_Model extends CI_Model
{
	var $category;
	var $key;
	var $value;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = array("category","key","value");

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
		$id = $this->get_id($this->category, $this->key, $this->value);
		if(!$id){
			$this->db->insert("menu",$this);
			$id = $this->db->last_insert_id();
		}
		return $id;
		
	}

	function update($id)
	{
		$this->db->where("id", $id);
		$this->prepare_variables();
		$this->db->update("menu", $this);
	}
	
	function get_id($category, $key, $value)
	{
		$this->db->where("category", $category);
		$this->db->where("key", $key);
		$this->db->where("value", $value);
		$this->db->from("menu");
		$output = $this->db->get()->row();
		return $output;
		
	}

	function get_categories()
	{
		$this->db->from("menu");
		$this->db->select("`category` as 'key',`category` as 'value'");
		$this->db->distinct("category");
		$this->db->order_by("category","ASC");
		$result = $this->db->get()->result();
		return $result;
	}


	function get_pairs($category, $order = array())
	{

		$this->db->where('category', $category);
		$this->db->select('key');
		$this->db->select('value');
		$direction = "ASC";
		$order_field = "value";

		if(!empty($order)){
			if(in_array("direction", $order)){
				$direction = $order['direction'];
			}
			if(in_array("field", $order)){
				$order_field = $order['field'];
			}
		}

		$this->db->order_by($order_field, $direction);
		$this->db->from('menu');
		$result = $this->db->get()->result();
		return $result;

	}

}