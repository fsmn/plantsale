<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Vendor_model extends CI_Model
{
	var $id;
	var $name;
	var $street;
	var $unit_type;
	var $unit;
	var $city;
	var $state;
	var $zip;
	var $country;
	var $phone;
	var $email;
	var $website;
	var $contact_id;
	var $billing_id;
	var $account;
	var $payment_method;
	var $shipping_id;
	var $shipping_notes;
	var $rec_modifier;
	var $rec_modified;
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function prepare_variables()
	{
		$variables = array("id",
				"name",
				"street",
				"unit_type",
				"unit","city",
				"state",
				"zip",
				"country",
				"phone",
				"email",
				"website",
				"contact_id",
				"billing_id",
				"account",
				"payment_method",
				"shipping_id",
				"shipping_notes",);
	
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
		$this->db->insert("vendor",$this);
		return $this->db->insert_id();
	}
	
	function update($id)
	{
		$this->prepare_variables();
		$this->db->where("id",$id);
		$this->db->update("vendor",$this);
	}
	
	function get($id,$values=NULL)
	{
		$this->db->from("vendor");
		$this->db->where("id",$id);
		$result = $this->db->get()->row();
		return $result;
	}
	
	function delete($id)
	{
		$id_array = array("id"=>$id);
		$this->db->delete("vendor",$id_array);
	}
	
	function get_ids()
	{
		$this->db->from("vendor");
		$this->db->select("id,name");
		$this->db->order_by("id","ASC");
		$result = $this->db->get()->result();
		return $result;
	}
	
}