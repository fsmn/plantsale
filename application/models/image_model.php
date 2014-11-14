<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

class Image_Model extends MY_Model
{
    var $variety_id;
    var $image_source;
    var $image_name;
    var $image_type;
    var $image_size;
    var $image_path;
    var $rec_modifier;
    var $rec_modified;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ($image_data)
    {
        $variables = array(
                "variety_id",
                "image_source"
        );
        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->post($my_variable)) {
                $this->$my_variable = $this->input->post($my_variable);
            }
        }

        if (array_key_exists("file_name", $image_data)) {
            $this->image_name = $image_data["file_name"];
            $this->image_path = "files/" . $this->image_name;
        }

        if (array_key_exists("file_type", $image_data)) {
            $this->image_type = $image_data["file_type"];
        }

        if (array_key_exists("file_size", $image_data)) {
            $this->image_size = $image_data["file_size"];
        }

        $this->rec_modified = mysql_timestamp();
        $this->rec_modifier = $this->ion_auth->user()->row()->id;
    }

    function insert ($variety_id, $image_data)
    {
        $this->prepare_variables($image_data);
        return $this->_insert("image");
    }

    function get ($id)
    {
        $this->db->where('id', $id);
        $this->db->from('image');
        $result = $this->db->get()->row();
        return $result;
    }

    function get_for_variety ($variety_id)
    {
        $this->db->where("variety_id", $variety_id);
        $this->db->from("image");
        $result = $this->db->get()->result();
        return $result;
    }

    function get_all ($variety_id)
    {
        $this->db->where('variety_id', $variety_id);
        $this->db->from('image');
        $this->db->order_by('image_display_name');
        $result = $this->db->get()->result();
        return $result;
    }

    function delete ($id)
    {
        if($this->ion_auth->in_group(array(1,2))){
        $image = $this->get($id);
        $filename = $_SERVER['DOCUMENT_ROOT'] . "files/" . $image->image_name;
        if (file_exists($filename)) {
            unlink($filename);
        }
        $id_array = array(
                'id' => $id
        );
        $this->db->delete('image', $id_array);
        }else{
            return FALSE;
        }
    }

    function fetch_values ($fields, $image_fields = null)
    {
        $this->db->from('image');
        $this->db->distinct();

        if (is_array($fields)) {
            foreach ($fields as $field) {
                $this->db->select($field);
            }
        } else {
            $this->db->select($fields);
        }

        if ($image_fields) {
            if (is_array($image_fields)) {
                foreach ($image_fields as $image) {
                    $this->db->order_by($image);
                }
            } else {
                $this->db->order_by($image_fields);
            }
        }

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}