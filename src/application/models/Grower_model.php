<?php
defined('BASEPATH') or exit('No direct script access allowed');

class grower_model extends MY_Model
{

	var $id;

	var $grower_name;

	var $street_address;

	var $po_box;

	var $city;

	var $state;

	var $zip;

	var $country;

	var $phone;

	var $email;

	var $website;

	var $user_id;

	var $shipping_notes;

	var $rec_modifier;

	var $rec_modified;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		$variables = [
			'id',
			'user_id',
			'grower_name',
			'street_address',
			'po_box',
			'city',
			'state',
			'zip',
			'country',
			'phone',
			'email',
			'website',
			'shipping_notes',
		];

		for ($i = 0; $i < count($variables); $i++) {
			$my_variable = $variables[$i];
			if ($this->input->post($my_variable)) {
				$this->$my_variable = $this->input->post($my_variable);
			}
		}

		// $this->rec_modified = mysql_timestamp();
		//$this->rec_modifier = $this->session->userdata('user_id');
	}

	function insert()
	{
		$this->prepare_variables();
		return $this->_insert('grower');
	}

	function is_unique($id)
	{
		return $this->db->query("SELECT id FROM grower WHERE id='$id'")->num_rows();
	}

	function update($id, $values = [])
	{
		return $this->_update('grower', $id, $values);
	}

	function get_value($id, $field)
	{
		return $this->_get_value('grower', $id, $field);
	}

	function get_orphans()
	{
		$this->db->select('orders.grower_id');
		$this->db->from('orders');
		$this->db->join('grower', 'orders.grower_id = grower.id', 'LEFT');
		$this->db->where('grower.id IS NULL', NULL, FALSE);
		$this->db->where('orders.grower_id !=', '');
		$this->db->where('orders.year', $this->session->userdata('sale_year'));
		$this->db->group_by('grower_id');
		$result = $this->db->get()->result();
		return $result;
	}

	function get($id, $values = NULL)
	{
		$this->db->from('grower');
		$this->db->where('grower.id', $id);
		$this->db->join('users', 'user_id = users.id', 'LEFT');
		$this->db->select('grower.*');
		$this->db->select('users.first_name, users.last_name');
		$result = $this->db->get()->row();
		return $result;
	}

	function delete($id)
	{
		return $this->_delete('grower', $id);
	}

	function get_ids($year = NULL)
	{
		$this->db->from('grower');
		if ($year) {
			$this->db->where('year', $year);
		}
		$this->db->join('orders', 'grower.id = orders.grower_id');
		$this->db->select('grower.id');
		$this->db->order_by('grower.id', 'ASC');
		$this->db->group_by('grower.id');
		$result = $this->db->get()->result();
		$this->_log("alert");
		return $result;
	}

	function get_totals($id, $year)
	{
		$query = sprintf('SELECT sum(`o`.`total`) as `total`, `grower`.*,`users`.`first_name`,`users`.`last_name`,
                `shipping`.`name` AS `shipping_name`,`shipping`.`phone1` AS `shipping_phone1`, `shipping`.`phone2` AS `shipping_phone2`, `shipping`.`email` AS `shipping_email`
                FROM (SELECT `grower_id`, (IFNULL(`count_presale`,0) + IFNULL(`count_midsale`,0) + IFNULL(`count_friday`,0) + IFNULL(`count_saturday`,0)) * `flat_cost` as `total` FROM (`orders`)
                WHERE `year` = "%s" AND `orders`.`grower_id` = "%s" ) as `o`
                LEFT JOIN `grower` ON `grower`.`id` = `o`.`grower_id`
                LEFT JOIN `contact` AS `shipping` ON `shipping`.`grower_id` = `grower`.`id` AND `shipping`.`contact_type` = "shipping"
        		LEFT JOIN `users` AS `users` ON `grower`.`user_id` = `users`.`id`
                GROUP BY `o`.`grower_id`', $year, $id);
		$result = $this->db->query($query)->row();
		$this->_log();
		return $result;
	}
}
