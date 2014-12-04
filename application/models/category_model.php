<?php
defined('BASEPATH') or exit('No direct script access allowed');

// category_model.php Chris Dart Dec 4, 2014 3:28:44 PM
// chrisdart@cerebratorium.com
class Category_Model extends MY_Model
{
    var $category;

    function __construct ()
    {
        parent::__construct();
    }

    function get_all ()
    {
        $this->db->from("category");
        $this->db->order_by("category", "ASC");
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * Migration script from forking off menu model.
     */
    function get_pairs ()
    {
        $this->db->from("category");
        $this->db->select("`category` as `key`, `category` as `value`");
        $this->db->order_by("category", "ASC");
        $result = $this->db->get()->result();
        return $result;
    }
}