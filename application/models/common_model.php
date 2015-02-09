<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends MY_Model
{
    var $name;
    var $genus;
    var $description;
    var $category_id;
    var $subcategory_id;
    var $other_names;
    var $sunlight;
    var $rec_modified;
    var $rec_modifier;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ($method = "post")
    {
        $variables = array(
                "name",
                "genus",
                "description",
                "category_id",
                "subcategory_id",
                ",other_names",
                "sunlight"
        );

        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];

            if ($method == "post") {
                $my_value = $this->input->post($my_variable);
                if (is_array($my_value)) {
                    $my_value = implode(",", $my_value);
                }
                $my_value = urldecode($my_value);
            } elseif ($method == "get") {
                $my_value = $this->input->get($my_variable);
            }
            if ($my_value) {

                $this->$my_variable = $my_value;
            }
        }

        $this->rec_modified = mysql_timestamp();
        $this->rec_modifier = $this->session->userdata('user_id');
    }

    function insert ()
    {
        $this->prepare_variables();
        if($this->category_id == 1 && !$this->subcategory_id){
            $this->db->where("common.subcategory_id",9);// update all annuals that are not categorized as "general"
        }
        $id = $this->_insert("common");
        return $id;
    }

    function update ($id, $values = array())
    {

        return $this->_update("common", $id, $values);
    }

    function get ($id)
    {
        $this->db->where("common.id", $id);
        $this->db->from("common");
        $this->db->join("category","common.category_id = category.id","LEFT");
        $this->db->join("subcategory","common.subcategory_id = subcategory.id","LEFT");
        $this->db->select("common.*");
        $this->db->select("subcategory.subcategory,category.category");
        $output = $this->db->get()->row();

        return $output;
    }

    function get_by_name ($name)
    {
        $this->db->where("`name` LIKE '%$name%' OR `genus` LIKE '%$name%'");
        $this->db->order_by("name", "ASC");
        $this->db->order_by("genus", "ASC");
        $result = $this->db->get("common")->result();
        return $result;
    }

    function get_value ($id, $field)
    {
        $this->db->where("id", $id);
        $this->db->select($field);
        $this->db->from("common");
        $output = $this->db->get()->row();
        if($output){
        return $output->$field;
        }else{
            return FALSE;
        }
    }

    function find ()
    {
        $this->prepare_variables("get");
        $this->db->from("common");
        if ($this->name && ! $this->genus) {
            $this->db->where("`name` LIKE '%$this->name%' OR `genus` LIKE '%$this->name%'");
        } elseif ($this->name && $this->genus) {
            $this->db->like("name", "$this->name");
            $this->db->like("genus", "$this->genus");
        } elseif (! $this->name && $this->genus) {
            $this->db->where("`name` LIKE '%$this->genus%' OR `genus` LIKE '%$this->genus%'");
        }

        if($this->category_id){
            $this->db->where("common.category_id",$this->category_id);
        }
        if($this->subcategory_id){
            $this->db->where("common.subcategory_id",$this->subcategory_id);
        }
        if ($this->sunlight) {
            if ($this->input->get("sunlight-boolean") == "or") {
                $my_list = explode(",", $this->sunlight);
                foreach ($my_list as $my_item) {
                    $this->db->or_like("sunlight", "$my_item");
                }
            } elseif ($this->input->get("sunlight-boolean") == "only") {
                foreach ($this->sunlight as $sunlight) {
                    $this->db->where("sunlight", $sunlight);
                }
            } else {
                foreach ($this->sunlight as $sunlight) {
                    $this->db->like("sunlight", $sunlight);
                }
            }
        }
        $this->db->join("category","common.category_id = category.id","LEFT");
        $this->db->join("subcategory","common.subcategory_id = subcategory.id","LEFT");
        $this->db->select("common.id,common.category_id,common.subcategory_id,name,genus,description,other_names,sunlight");
        $this->db->select("category.category,subcategory.subcategory");

        if ($year = $this->input->get("year")) {
            $this->db->join("variety", "common.id=variety.common_id");
            $this->db->join("order", "variety.id=order.variety_id");
            $this->db->select("order.year");
            $this->db->where("year",$year);
            $this->db->group_by("common.id");
        }

        $result = $this->db->get()->result();
        $this->_log();
        return $result;
    }

    function delete($id){
        $this->_delete("common", $id);
    }
}