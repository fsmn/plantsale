<?php

defined('BASEPATH') or exit('No direct script access allowed');

// category_model.php Chris Dart Dec 4, 2014 3:28:44 PM
// chrisdart@cerebratorium.com
class Subcategory_Model extends MY_Model
{
    var $subcategory;
    var $category_id;

    function __construct ()
    {
        parent::__construct();
    }

    function get_for_category ($category_id)
    {
        $this->db->from("subcategory");
        $this->db->where("category_id", $category_id);
        $this->db->order_by("subcategory", "ASC");
        $result = $this->db->get()->result();
        return $result;
    }
}