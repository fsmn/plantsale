<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Variety_Model extends CI_Model {
	var $common_id;
	var $species;
	var $variety;
	var $min_height;
	var $max_height;
	var $min_width;
	var $max_width;
	var $height_unit;
	var $width_unit;
	var $plant_color;
	var $note;
	var $new_year;
	var $rec_modifier;
	var $rec_modified;

	function __construct() {

		parent::__construct ();
	
	}

	function prepare_variables() {

		$variables = array (
				"species",
				"variety",
				"min_height",
				"max_height",
				"min_width",
				"max_width",
				"height_unit",
				"width_unit",
				"note",
				"new_year",
				"common_id" 
		);
		
		for($i = 0; $i < count ( $variables ); $i ++) {
			$my_variable = $variables [$i];
			if ($this->input->post ( $my_variable )) {
				$this->$my_variable = urldecode ( $this->input->post ( $my_variable ) );
			}
		}
		
		if ($this->input->post ( "plant_color" )) {
			$this->plant_color = implode ( ",", $this->input->post ( "plant_color" ) );
		}
		
		$this->rec_modified = mysql_timestamp ();
		$this->rec_modifier = $this->session->userdata ( 'user_id' );
	
	}

	function insert() {

		$this->prepare_variables ();
		$this->db->insert ( "variety", $this );
		$id = $this->db->insert_id ();
		return $id;
	
	}

	function update($id, $values = array()) {

		$this->db->where ( "id", $id );
		if (empty ( $values )) {
			$this->prepare_variables ();
			$this->db->update ( "variety", $this );
		} else {
			$this->db->update ( "variety", $values );
			if ($values == 1) {
				$keys = array_keys ( $values );
				return $this->get_value ( $id, $keys [0] );
			}
		}
	
	}

	function get($id) {

		$this->db->where ( "variety.id", $id );
		$this->db->from ( "variety" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "image", "variety.id=image.variety_id", "LEFT" );
		$this->db->select ( "variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,  common.category, common.description, common.sunlight, common.extended_description, common.other_names" );
		$this->db->select ( "image.id as image_id, image_name" );
		$result = $this->db->get ()->row ();
		return $result;
	
	}

	function get_by_common($common_id) {

		$query = "SELECT v.*, o.year
            FROM `variety` v
                LEFT JOIN
                    (SELECT n.variety_id, MAX(n.year) AS max_year  FROM `order` n GROUP BY n.variety_id) y
                        ON y.variety_id = v.id
                 LEFT JOIN `order` o ON `o`.`variety_id` = `v`.`id` AND `o`.`year`=`y`.`max_year`
                 WHERE `v`.`common_id` = $common_id ORDER BY `year` DESC";
		$result = $this->db->query ( $query )->result ();
		return $result;
	
	}

	function get_by_name($name) {

		$this->db->where ( "`variety` LIKE '%$name%' OR `common`.`name` LIKE '%$name%' OR `variety`.`species` LIKE '%$name%' OR `common`.`genus` LIKE '%$name%'" );
		$this->db->join ( "common", "variety.common_id=common.id" );
		$this->db->order_by ( "variety", "ASC" );
		$this->db->order_by ( "common.name", "ASC" );
		$this->db->select ( "variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,  common.category, common.description" );
		
		$result = $this->db->get ( "variety" )->result ();
		return $result;
	
	}

	function get_value($id, $field) {

		$this->db->where ( "id", $id );
		$this->db->select ( $field );
		$this->db->from ( "variety" );
		$output = $this->db->get ()->row ();
		return $output->$field;
	
	}

	function get_new_varieties($year) {

		$this->db->where ( "new_year", $year );
		$this->db->from ( "variety" );
		$this->db->select ( "new_year" );
		$result = $this->db->get ()->num_rows ();
		return $result;
	
	}

	function is_new($id, $year = NULL) {

		if (! $year) {
			$year = get_cookie ( "sale_year" );
		}
		$query = sprintf ( "select * from `order`,variety where `order`.`variety_id` = %s and variety.id = `order`.variety_id  and  not exists(select `year` from `order` where `year` < %s and variety_id = %s)  having `order`.`year` = %s", $id, $year, $id, $year );
		$result = $this->db->query ( $query )->num_rows ();
		return $result;
	
	}

	function update_all($year) {

		$this->db->select ( "id" );
		$this->db->from ( "variety" );
		$this->db->where ( "new_year IS NULL", NULL, false );
		$varieties = $this->db->get ()->result ();
		foreach ( $varieties as $variety ) {
			$query = sprintf ( "select `order`.`year` from `order`,variety where `order`.`variety_id` = %s and variety.id = `order`.variety_id  and  not exists(select `year` from `order` where `year` < %s and variety_id = %s)  having `order`.`year` = %s", $variety->id, $year, $variety->id, $year );
			$new_year = $this->db->query ( $query )->row ();
			print_r ( $new_year );
			if ($new_year) {
				$this->update_status ( $variety->id, $year );
			}
		}
	
	}

	function update_status($id, $year) {

		$this->db->where ( "id", $id );
		$update = array (
				"new_year" => $year 
		);
		$this->db->update ( "variety", $update );
	
	}

	function get_varieties_for_year($year) {

		$this->db->from ( "variety" );
		$this->db->join ( "order", "variety.id=order.variety_id" );
		$this->db->where ( "order.year", $year );
		$result = $this->db->get ()->result ();
		return $result;
	
	}

	function get_category_totals($year) {

		$this->db->from ( "variety" );
		$this->db->join ( "order", "variety.id=order.variety_id" );
		$this->db->join ( "common", "common.id=variety.common_id" );
		$this->db->where ( "order.year", $year );
		$this->db->group_by ( "common.category" );
		$this->db->select ( "count(`variety`.`id`) as count,common.category" );
		$result = $this->db->get ()->result ();
		return $result;
	
	}

	function get_flat_totals($year) {

		$this->db->from ( "variety" );
		$this->db->join ( "order", "variety.id=order.variety_id" );
		$this->db->join ( "common", "common.id=variety.common_id" );
		$this->db->where ( "order.year", $year );
		$this->db->group_by ( "common.category" );
		$this->db->select ( "sum(`order`.`count_presale`) as count,common.category" );
		$result = $this->db->get ()->result ();
		return $result;
	
	}

	function find($variables) {

		$my_parameters = ( object ) array ();
		for($i = 0; $i < count ( $variables ); $i ++) {
			$my_variable = $variables [$i];
			if ($this->input->get ( $my_variable ) && $this->input->get ( $my_variable ) != "") {
				$my_value = $this->input->get ( $my_variable );
				if ($my_value) {
					$my_parameters->$my_variable = new stdClass ();
					if ($my_variable == "sunlight") {
						$my_parameters->$my_variable->key = $my_variable;
						$my_parameters->$my_variable->value = implode ( ",", $my_value );
					} else {
						$my_parameters->$my_variable->key = $my_variable;
						$my_parameters->$my_variable->value = $my_value;
					}
				}
			}
		}
		$this->db->from ( "variety" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "flag", "variety.id = flag.variety_id" );
		$this->db->join ( "order", "variety.id = order.variety_id" );
		
		foreach ( $my_parameters as $parameter ) {
			if ($parameter->key == "sunlight") {
				if ($this->input->get ( "sunlight-boolean" ) == "or") {
					$my_list = explode ( ",", $paramter->value );
					foreach ( $my_list as $my_item ) {
						$this->db->or_like ( "sunlight", "$my_item" );
					}
				} elseif ($this->input->get ( "sunlight-boolean" ) == "only") {
					$this->db->where ( "sunlight", $parameter->value );
				} else {
					$this->db->like ( "sunlight", $parameter->value );
				}
			} elseif ($parameter->key == "name") {
				$this->db->like ( "common.name", $parameter->value );
			} elseif ($parameter->key == "flag") {
				$this->db->where ( "flag.name", $parameter->value );
			} elseif ($parameter->key == "year") {
				$this->db->where ( "order.year", $parameter->value );
			} elseif (in_array ( $parameter->key, array (
					"variety",
					"genus",
					"species",
					"description" 
			) )) {
				$this->db->like ( $parameter->key, $parameter->value );
			} elseif ($parameter->key == "print_omit") {
				$this->db->where ( "(order.print_omit is NULL OR order.print_omit != 1)", NULL, FALSE );
			} else {
				$this->db->where ( $parameter->key, $parameter->value );
			}
		}
		// select common fields
		$this->db->select ( "common.name,common.genus, common.sunlight, common.category" );
		// include all variety fields (maybe change this).
		$this->db->select ( "variety.*" );
		
		// select order fields
		$this->db->select ( "order.id as order_id,year,flat_size,flat_cost,plant_cost,pot_size,price,count_presale,count_midsale,count_dead,print_omit" );
		$this->db->select ( "sellout_friday,sellout_saturday,remainder_friday,remainder_saturday,remainder_sunday,grower_code,grower_id,catalog_number" );
		$this->db->group_by ( "variety.id" );
		$result = $this->db->get ()->result ();
		return $result;
	
	}

	function delete($id) {

		$this->db->delete ( "variety", array (
				'id' => $id 
		) );
		$this->db->delete ( "order", array (
				'variety_id' => $id 
		) );
		$this->db->delete ( "flag", array (
				'variety_id' => $id 
		) );
	
	}

}