<?php


class Settings_model extends MY_Model
{

	var $id;
	var $key;
	var $value;

	function get_by_key($key)
	{
		$this->db->from('settings');
		$this->db->where('key', $key);
		return $this->db->get()->result();
	}

	function update($key, $values)
	{
		foreach ($values as $value) {
			if (!empty($value)) {
				$this->db->replace('settings', ['key' => $key, 'value' => urldecode($value)]);
			}
		}
	}

}
