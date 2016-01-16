<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class User_model extends MY_Model {

	function __construct()
	{
		parent::__construct ();
	}

	/**
	 * 
	 * @param string $group
	 * @return unknown
	 * Groups are not yet used in this configuration.
	 */
	function get_user_pairs($group = FALSE)
	{
		$this->db->from ( "users" );
		$this->db->where ( "active", 1 );
		$this->db->order_by ( "username" );
		$this->db->select ( "id,CONCAT(`first_name`,' ',`last_name`) as `name`", FALSE );
		$result = $this->db->get ()->result ();
		return $result;
	}

	function get_user($id)
	{
		$this->db->from ( "users" );
		$this->db->where ( "id", $id );
		$output = $this->db->get ()->row ();
		return $output;
	}

	function get_by_name($name)
	{
		$this->db->from ( "users" );
		$name_array = explode ( " ", $name );
		$first_name = $name_array [0];
		$last_name = $name_array [1];
		
		$this->db->where ( "first_name", $first_name );
		$this->db->where ( "last_name", $last_name );
		$output = $this->db->get ()->row ();
		return $output;
	}
}