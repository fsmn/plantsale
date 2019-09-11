<?php

defined('BASEPATH') or exit('No direct script access allowed');

// category_model.php Chris Dart Dec 4, 2014 3:28:44 PM
// chrisdart@cerebratorium.com
class Subcategory_Model extends MY_Model
{
    var $subcategory;
    var $category_id;
    var $rec_modifier;
    var $rec_modified;
    
    function __construct ()
    {
        parent::__construct();
    }

    function get($id){
    	return $this->_get("subcategory",$id);
    	
    }
    function get_for_category ($category_id)
    {
        $this->db->from("subcategory");
        $this->db->where("category_id", $category_id);
        $this->db->order_by("subcategory", "ASC");
        $result = $this->db->get()->result();
        return $result;
    }

    function get_pairs ($category_id = NULL)
    {
        if($category_id){
            $this->db->where("category_id",$category_id);
        }
        $this->db->from("subcategory");
        $this->db->select("`id` as `key`, `subcategory` as `value`");
        $this->db->order_by("subcategory", "ASC");
        $result = $this->db->get()->result();
        return $result;
    }
    
    function exists($category_id, $subcategory){
    	$this->db->from("subcategory");
    	$this->db->where('category_id',$category_id);
    	$this->db->where('subcategory',trim($subcategory));
    	$result = $this->db->get()->row();
    	return $result;
    }
    
    function insert($category_id, $subcategory){
    	$this->category_id = $category_id;
    	$this->subcategory = $subcategory;
    	return $this->_insert("subcategory");
    }
    
    function update($id,$values = array()){
    	return $this->_update("subcategory",$id,$values);
    }
}