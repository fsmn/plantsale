<?php

class Settings_model extends MY_Model{

	function __construct() {
		parent::__construct();
	}

	function get($name){
			$this->db->from('settings');
			$this->db->where('name', $name);
			$this->db->select('*');
			$result = $this->db->get()->row();
			return $result;
	}

	function insert($fields){
		$this->db->insert('settings', $fields);
		return $this->db->get($fields['name']);
	}

	function set($name, $value){
		$this->db->update('settings', ['value'=>$value]);
		$this->db->where('name', $name);
		return $this->get($name);
	}

}
