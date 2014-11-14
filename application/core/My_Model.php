<?php

class My_Model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    private function __insert($db,$me){

    if (is_editor($this->ion_auth->get_users_groups()->result())) {
        $this->db->insert($db, $this);
        $id = $this->db->insert_id();
        return $id;
    } else {
        return FALSE;
    }
}

}