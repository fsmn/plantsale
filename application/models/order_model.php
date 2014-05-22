<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Order_Model extends CI_Model {
	var $variety_id;
	var $grower_id;
	var $catalog_number;
	var $catalog_id;
	var $year;
	var $flat_size;
	var $flat_cost;
	var $pot_size;
	var $plant_cost;
	var $price;
	var $count_presale;
	var $count_midsale;
	var $count_dead;
	var $sellout_friday;
	var $sellout_saturday;
	var $remainder_friday;
	var $remainder_saturday;
	var $remainder_sunday;
	var $grower_code;
	var $rec_modified;
	var $rec_modifier;

	function __construct() {

		parent::__construct ();

	}

	function prepare_variables() {

		$variables = array (
				"variety_id",
				"grower_id",
				"catalog_number",
				"catalog_id",
				"year",
				"flat_size",
				"flat_cost",
				"pot_size",
				"plant_cost",
				"price",
				"count_presale",
				"count_midsale",
				"count_dead",
				"sellout_friday",
				"sellout_saturday",
				"remainder_friday",
				"remainder_saturday",
				"remainder_sunday",
				"grower_code"
		);

		for($i = 0; $i < count ( $variables ); $i ++) {
			$my_variable = $variables [$i];
			if ( $this->input->post ( $my_variable )) {
				$this->$my_variable = urldecode($this->input->post ( $my_variable ));
			}
		}

		$this->rec_modified = mysql_timestamp ();
		$this->rec_modifier = $this->session->userdata ( 'user_id' );

	}

	function insert() {

		$this->prepare_variables ();
		$this->db->insert ( "order", $this );
		$id = $this->db->insert_id ();
		return $id;

	}

	function update($id, $values = array()) {

		$this->db->where ( "id", $id );
		if (empty ( $values )) {
			$this->prepare_variables ();
			$this->db->update ( "order", $this );
		} else {
			$this->db->update ( "order", $values );
			if (count ( $values ) == 1) {
				$keys = array_keys ( $values );
				return $this->get_value ( $id, $keys [0] );
			}
		}

	}

	function delete($id) {

		$order = $this->get ( $id );
		$variety_id = $order->variety_id;
		$this->db->delete ( "order", array (
				"id" => $id
		) );
		return $variety_id;

	}

	function get($id) {

		$this->db->where ( "order.id", $id );
		$this->db->from ( "order,variety" );
		$this->db->where ( "`order`.`variety_id` = `variety`.`id`" );
		$this->db->select ( "order.*, variety.variety" );
		$output = $this->db->get ()->row ();
		return $output;

	}

	function get_for_variety($variety_id, $year = NULL) {

		$this->db->where ( "variety_id", $variety_id );
		if ($year) {
			$this->db->where ( "year", $year );
		}
		$this->db->from ( "order" );
		$this->db->join("grower","order.grower_id=grower.id");
		$this->db->select("order.*,grower.grower_name");
		$this->db->order_by ( "year", "desc" );
		if ($year) {
			$output = $this->db->get ()->row ();
		} else {
			$output = $this->db->get ()->result ();
		}
		return $output;

	}

	function get_totals($sale_year, $options = array(), $order_by = array("fields"=>array("catalog_number"),"direction"=>array("ASC"))) {

		$this->db->from ( "order" );
		$this->db->join ( "variety", "order.variety_id = variety.id" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$option_keys = array_keys ( $options );
		$option_values = array_values ( $options );
		for($i = 0; $i < count ( $options ); $i ++) {
			$this->db->where ( $option_keys [$i], $option_values [$i] );
		}
		$this->db->where ( "order.year", $sale_year );
		if (! is_array ( $order_by )) {
			$order_by = array (
					$order_by
			);
		}
		for($i = 0; $i < count ( $order_by ["fields"] ); $i ++) {
			$order_field = "catalog_number";
			if (array_key_exists ( "fields", $order_by ) && ! empty ( $order_by ["fields"][$i] )) {
				$order_field = $order_by ["fields"] [$i];
			}

			$order_direction = "ASC";
			if (array_key_exists ( "direction", $order_by ) && !empty($order_by["direction"][$i])) {
				$order_direction = $order_by ["direction"] [$i];
			}
			$this->db->order_by ( $order_field, $order_direction );
		}
		$this->db->select ( "order.id,grower_id,order.variety_id, order.year, order.catalog_number, order.flat_size, order.flat_cost, order.plant_cost, order.pot_size, order.price,order.count_presale, order.count_midsale,order.grower_code" );
		$this->db->select ( "variety.variety, variety.species" );
		$this->db->select ( "common.name, common.genus, common.category, common.id as common_id" );
		$result = $this->db->get ()->result ();
		return $result;

	}

	function get_current_year() {

		$this->db->from ( "order" );
		$this->db->order_by ( "year", "DESC" );
		$this->db->group_by ( "year" );
		$this->db->limit ( 1 );
		$result = $this->db->get ()->row ();
		return $result->year;

	}

	function get_previous_year($variety_id, $current_year) {

		$this->db->from ( "order" );
		$this->db->where ( "variety_id", $variety_id );
		$this->db->where ( "year <", $current_year );
		$this->db->order_by ( "year", "DESC" );
		$this->db->group_by ( "year" );
		$this->db->limit ( 1 );
		$result = $this->db->get ()->row ();
		return $result;

	}

	function get_value($id, $field) {

		$this->db->where ( "id", $id );
		$this->db->select ( $field );
		$this->db->from ( "order" );
		$output = $this->db->get ()->row ();
		return $output->$field;

	}

	function get_pot_sizes() {

		$this->db->from ( "order" );
		$this->db->select ( "pot_size" );
		$this->db->group_by ( "pot_size" );
		$this->db->order_by ( "pot_size" );
		$result = $this->db->get ()->result ();
		return $result;

	}

	function get_plant_total($year) {
		// sum(flat_size * (count_presale + count_midsale))
		$query = sprintf ( "SELECT sum((`count_presale` + `count_midsale`)) as `total` FROM `order` where `year` = '%s' ", $year );
		$result = $this->db->query ( $query )->row ();
		return $result->total;

	}

	function get_price_range($year = NULL) {

		$this->db->from ( "order" );
		$this->db->select ( "min(`plant_cost`) as `min_price`, max(`plant_cost`) as `max_price` , avg(`plant_cost`) as `average_price`" );
		$this->db->where ( "year", $year );
		$result = $this->db->get ()->row ();
		return $result;

	}

}
