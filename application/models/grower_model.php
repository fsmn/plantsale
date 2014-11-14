<?php defined('BASEPATH') OR exit('No direct script access allowed');


class grower_model extends MY_Model
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
		return $this->_insert("grower");
	}

	function update($id,$values = array())
	{
	    return $this->_update("grower",$id,$values);
	}

	function get($id,$values=NULL)
	{
		$this->db->from("grower");
		$this->db->where("id",$id);
		$result = $this->db->get()->row();
		return $result;
	}

	function delete($id)
	{
	    return $this->_delete("grower",$id);
	}

	function get_ids()
	{
		$this->db->from("grower");
		$this->db->select("id,name");
		$this->db->order_by("id","ASC");
		$result = $this->db->get()->result();
		return $result;
	}

}