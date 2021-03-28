<?php

defined('BASEPATH') or exit('No direct script access allowed');
//@TODO swap double quotes with single quotes
// symbol_model.php Chris Dart Feb 17, 2013 5:21:15 PM
// chrisdart@cerebratorium.com
class Menu_Model extends MY_Model
{
    var $category;
    var $key;
    var $value;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ()
    {
        $variables = array(
                "category",
                "key",
                "value"
        );

        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->post($my_variable)) {
                $this->$my_variable = $this->input->post($my_variable);
            }
        }
    }

    function insert ()
    {
        if (IS_ADMIN) {
            $this->prepare_variables();

           return $this->get( $this->_insert("menu"));
        }
    }

    function update ($id)
    {
        if (IS_ADMIN) {
            $this->db->where("id", $id);
            $this->prepare_variables();
            $this->db->update("menu", $this);
            return $this->get($id);
        }
    }

    function get ($id)
    {
        return $this->_get("menu", $id);
    }

    function get_id ($category, $key, $value)
    {
        $this->db->where("category", $category);
        $this->db->where("key", $key);
        $this->db->where("value", $value);
        $this->db->from("menu");
        $output = $this->db->get()->row();
        return $output;
    }

    function get_categories ($pairs = TRUE)
    {
        $this->db->from("menu");
        if($pairs){
        $this->db->select("`category` as 'key',`category` as 'value'");
        }else{
            $this->db->select("category");
        }
        $this->db->group_by("category");
        $this->db->order_by("category", "ASC");
        $result = $this->db->get()->result();
        return $result;
    }

    function get_all ($category = FALSE)
    {
        $this->db->from("menu");
        $this->db->order_by("category", "ASC");
        $this->db->order_by("value");
        if ($category) {
            $this->db->where("category", $category);
        }
        $result = $this->db->get()->result();
        return $result;
    }

    function get_pairs ($category, $order_by = array())
    {
    	
        $this->db->where('category', $category);
        $this->db->select(['key', 'value']);
        $direction = "ASC";
        $order_field = "key";
        
        if (!empty($order_by)) {
            if (array_key_exists("direction", $order_by)) {
                $direction = $order_by['direction'];
            }
            if (array_key_exists("field", $order_by)) {
                $order_field = $order_by['field'];
            }
        }
        
        $this->db->order_by($order_field, $direction);
        $this->db->from('menu');
        $result = $this->db->get()->result();
        return $result;        
    }

    function get_value ($category, $key)
    {
        $this->db->from("menu");
        $this->db->where("category", $category);
        $this->db->where("key", $key);
        $value = $this->db->get()->row()->value;
        return $value;
    }
}
