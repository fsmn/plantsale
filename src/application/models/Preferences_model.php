<?php

defined('BASEPATH') or exit('No direct script access allowed');

// preferences_model.php Chris Dart Dec 10, 2014 4:33:55 PM
// chrisdart@cerebratorium.com
class Preferences_model extends MY_Model
{
    var $id;
    var $name;
    var $description;
    var $format;
    var $options;

    var $rec_modifier;
    var $rec_modified;

    function __construct ()
    {
        parent::__construct();
    }

    function get($id){
    	$this->db->from('preferences');
    	$this->db->where('id', $id);
    	return $this->db->get()->row();
	}




}
