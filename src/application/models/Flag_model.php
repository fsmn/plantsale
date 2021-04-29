<?php defined('BASEPATH') or exit('No direct script access allowed');

class Flag_Model extends MY_Model
{
	var $variety_id;
	var $name;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = ['variety_id', 'name'];

		for ($i = 0; $i < count($variables); $i++) {
			$my_variable = $variables[$i];
			if ($this->input->post($my_variable)) {
				$this->$my_variable = urldecode($this->input->post($my_variable));
			}
		}

		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->ion_auth->get_user_id();
	}


	function insert()
	{
		$this->prepare_variables();
		$id = $this->_insert('flag');
		return $id;
	}

	function update($id, $values = [])
	{
		return $this->_update('flag', $id, $values);
	}

	/**
	 * Update the flags for a set of variety ids
	 * @param array $ids
	 * @param string $flag
	 */
	function batch_update($variety_ids, $flag)
	{
		$rec_modified = mysql_timestamp();
		$rec_modifier = $this->ion_auth->get_user_id();
		$values = [];

		foreach ($variety_ids as $id) {
			$values[] = sprintf('(%s,"%s","%s","%s")', $id, $flag, $rec_modified, $rec_modifier);
		}
		$query = sprintf('REPLACE INTO flag (`variety_id`,`name`,`rec_modified`,`rec_modifier`) VALUES%s;', implode(',', $values));
		$this->db->query($query);
	}

	function delete($id)
	{
		return $this->_delete('flag', $id);
	}

	function get_for_variety($variety_id)
	{
		$this->db->where('variety_id', $variety_id);
		$this->db->from('flag');
		$this->db->select('flag.*,icon.source,icon.thumbnail');
		$this->db->join('menu', 'flag.name=menu.key');
		$this->db->join('icon', 'menu.id=icon.menu_id');
		$output = $this->db->get()->result();
		return $output;
	}

	function get_for_web($variety_id)
	{
		$this->db->where('variety_id', $variety_id);
		$this->db->from('flag');
		$this->db->select('flag.name');
		$output = $this->db->get()->result_array();
		return $output;
	}

	/**
	 * finds all the flags for a variety and returns a key-value pair multi-array
	 *
	 * @param int $variety_id
	 *
	 * @return array
	 */
	function get_missing(int $variety_id)
	{
		$current_flags = $this->get_for_variety($variety_id);
		$flag_list = [];
		foreach ($current_flags as $current_flag) {
			$flag_list[] = $current_flag->name;
		}
		$query = sprintf('SELECT `key`, `value` FROM `menu` WHERE `category` = "flag" AND `value` not in ("%s")', implode('","', $flag_list));

		$output = $this->db->query($query)->result();

		return $output;
	}
}
