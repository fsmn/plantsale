<?php
defined('BASEPATH') or exit('No direct script access allowed');

class grower_model extends MY_Model {

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

	function __construct() {
		parent::__construct();
	}

	function prepare_variables() {
		$variables = [
			"id",
			"user_id",
			"grower_name",
			"street_address",
			"po_box",
			"city",
			"state",
			"zip",
			"country",
			"phone",
			"email",
			"website",
			"shipping_notes",
		];

		for ($i = 0; $i < count($variables); $i++) {
			$my_variable = $variables[$i];
			if ($this->input->post($my_variable)) {
				$this->{$my_variable} = $this->input->post($my_variable);
			}
		}

		// $this->rec_modified = mysql_timestamp();
		//$this->rec_modifier = $this->session->userdata('user_id');
	}

	function insert() {
		$this->prepare_variables();
		return $this->_insert("grower");
	}

	function is_unique($id) {
		return $this->db->select('id')->from('grower')->where('id',$id)->get()->num_rows();

	}

	function update($id, $values = []) {
		return $this->_update('grower', $id, $values);
	}

	function get_value($id, $field) {
		return $this->_get_value("grower", $id, $field);
	}

	function get_orphans() {
		$this->db->select("orders.grower_id");
		$this->db->from("orders");
		$this->db->join("grower", "orders.grower_id = grower.id", "LEFT");
		$this->db->where("grower.id IS NULL", NULL, FALSE);
		$this->db->where("orders.grower_id !=", "");
		$this->db->where("orders.year", $this->session->userdata("sale_year"));
		$result = $this->db->get()->result();
		return $this->group_by($result, 'id');

	}

	function get($id) {
		$this->db->from("grower");
		$this->db->where("grower.id", $id);
		$this->db->select("grower.*");
		$result = $this->db->get()->row();
		if(!empty($result)) {
			$this->load->model('user_model','user');
			$result->our_contact = $this->user->get_user($result->user_id);
			$this->load->model('contact_model', 'contact');
			$result->contacts = $this->contact->get_for_grower($id);
		}
		return $result;
	}

	function delete($id) {
		return $this->_delete("grower", $id);
	}

	function get_ids($year = NULL) {
		$this->db->from("grower");
		if ($year) {
			$this->db->where("year", $year);
		}
		$this->db->join("orders", "grower.id = orders.grower_id");
		$this->db->select("grower.id");
		$this->db->order_by("grower.id", "ASC");
		$result = $this->db->get()->result();
		// $this->_log("alert");
		return $this->group_by($result, 'id');
	}

	function get_totals($id, $year) {
		$query = sprintf("SELECT `total`, `grower`.*,`users`.`first_name`,`users`.`last_name`,
                `shipping`.`name` AS `shipping_name`,`shipping`.`phone1` AS `shipping_phone1`, `shipping`.`phone2` AS `shipping_phone2`, `shipping`.`email` AS `shipping_email`
                FROM (SELECT `grower_id`, (IFNULL(`count_presale`,0) + IFNULL(`count_midsale`,0) + IFNULL(`count_friday`,0) + IFNULL(`count_saturday`,0)) * `flat_cost` as `total` FROM (`orders`)
                WHERE `year` = '%s' AND `orders`.`grower_id` = '%s' ) as `o`
                LEFT JOIN `grower` ON `grower`.`id` = `o`.`grower_id`
                LEFT JOIN `contact` AS `shipping` ON `shipping`.`grower_id` = `grower`.`id` AND `shipping`.`contact_type` = 'shipping'
        		LEFT JOIN `users` AS `users` ON `grower`.`user_id` = `users`.`id`", $year, $id);
		$result = $this->db->query($query)->result();
		$this->_log();
		$totals = [];
		foreach($result as $item){
			$totals+= $item->total;
		}
		return $totals;
	}

	function list_fields(array $ignore_fields = []): array {
		return $this->_list_fields('grower', $ignore_fields);
	}

}
