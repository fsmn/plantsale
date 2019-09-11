<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// category_model.php Chris Dart Dec 4, 2014 3:28:44 PM
// chrisdart@cerebratorium.com
class Category_Model extends MY_Model
	{
		var $category;
		var $rec_modifier;
		var $rec_modified;

		function __construct()
		{

			parent::__construct ();
		
		}
		

		function get($id)
		{

			 $output = $this->_get ( "category", $id );
			return $output;
		
		}

		function get_all()
		{

			$this->db->from ( "category" );
			$this->db->order_by ( "category", "ASC" );
			$result = $this->db->get ()->result ();
			return $result;
		
		}
		
		function exists($category){
			$this->db->from('category');
			$this->db->where('category',trim($category));
			$result = $this->db->get()->row();
			return $result;
		}

		/**
		 * Migration script from forking off menu model.
		 */
		function get_pairs()
		{

			$this->db->from ( "category" );
			$this->db->select ( "`id` as `key`, `category` as `value`" );
			$this->db->order_by ( "category", "ASC" );
			$result = $this->db->get ()->result ();
			return $result;
		
		}

		function get_id($category)
		{

			$this->db->from ( "category" );
			$this->db->where ( "category", $category );
			$this->db->select ( "id" );
			$result = $this->db->get ()->row ()->id;
			return $result;
		
		}
		
		function update($id, $values = FALSE){
			return $this->_update("category", $id, $values);
		}
		
		function insert($category){
			$this->category = $category;
			$this->_insert("category");
		}
	}