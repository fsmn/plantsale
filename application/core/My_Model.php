<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class My_Model extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
    }

    function _insert ($db)
    {
        if (is_editor($this->ion_auth->get_users_groups()->result())) {
            $this->db->insert($db, $this);
            $id = $this->db->insert_id();
            return $id;
        } else {
            return FALSE;
        }
    }

    function _update ($db, $id, $values)
    {
        if (is_editor($this->ion_auth->get_users_groups()->result())) {
            $this->db->where("id", $id);
            if (empty($values)) {
                $this->prepare_variables();
                $this->db->update($db, $this);
            } else {
                $this->db->update($db, $values);
                if (count($values) == 1) {
                    $keys = array_keys($values);
                    return $this->get_value($id, $keys[0]);
                }
            }
        } else {
            return FALSE;
        }
    }

    function _delete ($db, $id)
    {
        if (is_editor($this->ion_auth->get_users_groups()->result())) {
            $this->db->delete($db, array(
                    "id" => $id
            ));
        } else {
            return FALSE;
        }
    }
}