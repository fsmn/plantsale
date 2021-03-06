<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contact_model extends MY_Model
{
    var $name;
    var $grower_id;
    var $phone1;
    var $phone1_type;
    var $phone2;
    var $phone2_type;
    var $email;
    var $notes;
    var $rec_modifier;
    var $rec_modified;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ()
    {
        $variables = array(
                "name",
                "grower_id",
                "contact_type",
                "phone1",
                "phone1_type",
                "phone2",
                "phone2_type",
                "email",
                "notes",
        );

        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->post($my_variable)) {
                $this->$my_variable = $this->input->post($my_variable);
            }
        }

        $this->rec_modified = mysql_timestamp();
        $this->rec_modifier = $this->ion_auth->get_user_id();
    }

    function get ($id)
    {
        return $this->_get("contact",$id);
    }

    function get_for_grower ($grower_id)
    {
        $this->db->where("grower_id", $grower_id);
        $this->db->from("contact");
        $this->db->order_by("contact_type");
        $this->db->order_by("name");
        $result = $this->db->get()->result();
        return $result;
    }

    function insert ()
    {
        $this->prepare_variables();
        return $this->_insert("contact");
    }

    function update ($id)
    {
        $this->prepare_variables();
        $this->db->where("id", $id);
        $this->db->update("contact", $this);
    }

    function delete ($id)
    {
        $delete = array(
                "id" => $id
        );
        $this->db->delete("contact", $delete);
    }
}