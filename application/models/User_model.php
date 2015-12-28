<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class User_model extends MY_Model {

	function __construct()
	{
		parent::__construct ();
	}

	function get_user_pairs()
	{
		$this->db->from ( "users" );
		$this->db->where ( "active", 1 );
		$this->db->order_by ( "username" );
		$this->db->select("first_name,first_name",FALSE);
		$result = $this->db->get()->result ();
		return $result;
	}
}