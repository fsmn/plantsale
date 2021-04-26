<?php
defined('BASEPATH') or exit('No direct script access allowed');

// file_model.php Chris Dart Jan 22, 2015 5:28:31 PM chrisdart@cerebratorium.com
class Field_model extends MY_Model
{
    var $field;
    var $human_name;
    var $table;
    var $rec_modifier;
    var $rec_modified;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @todo Undefined variable $field_name
     */

    function get($field, $table)
    {
        $this->db->where('field', $field);
        $this->db->where('table', $table);
        $this->db->from('field');
        $result = $this->db->get()->row();
        if (empty($result)) {
            $result = $field_name;
        }
        return $result;
    }
}
