<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Variety_Model extends MY_Model {
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
	var $print_description;
	var $web_description;
	var $new_year;
	var $needs_copy_review;
	var $churn_value;
	var $rec_modifier;
	var $rec_modified;

	function __construct()
	{
		parent::__construct ();
	}

	function prepare_variables()
	{
		$variables = array (
				"species",
				"variety",
				"min_height",
				"max_height",
				"min_width",
				"max_width",
				"height_unit",
				"width_unit",
				"print_description",
				"web_description",
				"new_year",
				"needs_copy_review",
				"churn_value",
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

	function insert()
	{
		$this->prepare_variables ();
		return $this->_insert ( "variety" );
	}

	function update($id, $values = array())
	{
		return $this->_update ( "variety", $id, $values );
	}

	function get($id)
	{
		$this->db->where ( "variety.id", $id );
		$this->db->from ( "variety" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id = subcategory.id", "LEFT" );
		$this->db->join ( "image", "variety.id=image.variety_id", "LEFT" );
		$this->db->select ( "variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,subcategory.subcategory,  category.category, common.description, common.sunlight, variety.print_description,variety.web_description, common.other_names" );
		$this->db->select ( "image.id as image_id, image_name" );
		$result = $this->db->get ()->row ();
		return $result;
	}

	/**
	 * Deprecated *
	 */
	function get_by_common($common_id)
	{
		return $this->get_for_common ( $common_id );
	}

	function get_for_common($common_id)
	{
		$this->db->from ( "variety" );
		$this->db->where ( "common_id", $common_id );
		$this->db->order_by ( "variety.variety" );
		$result = $this->db->get ()->result ();
		$this->load->model ( "order_model", "orders" );
		foreach ( $result as $variety ) {
			$year = $this->db->query ( sprintf ( "SELECT `year` FROM `orders` `o` WHERE `o`.`variety_id` = '$variety->id' ORDER BY `o`.`year` DESC LIMIT 1" ) )->row ();
			if ($year) {
				$variety->year = $year->year;
			} else {
				$variety->year = NULL;
			}
		}
		return $result;
	}

	function get_for_quark($common_id, $year)
	{
		$this->db->from ( "variety" );
		$this->db->join ( "orders", "variety.id = orders.variety_id" );
		$this->db->where ( "common_id", $common_id );
		$this->db->where ( "year", $year );
		$this->db->select ( "variety.*" );
		$this->db->select ( "orders.year, orders.pot_size,orders.price,orders.catalog_number,orders.count_midsale" );
		$this->db->order_by ( "orders.catalog_number" );
		$this->db->order_by ( "CAST(orders.price as DECIMAL)" );
		$this->db->order_by ( "orders.pot_size" );
		$this->db->order_by ( "variety" );
		$result = $this->db->get ()->result ();
		return $result;
	}

	function get_by_name($name)
	{
		$this->db->where ( "`variety` LIKE '%$name%' OR `common`.`name` LIKE '%$name%' OR `variety`.`species` LIKE '%$name%' OR `common`.`genus` LIKE '%$name%'" );
		$this->db->join ( "common", "variety.common_id=common.id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id = subcategory.id", "LEFT" );
		$this->db->order_by ( "variety", "ASC" );
		$this->db->order_by ( "common.name", "ASC" );
		$this->db->select ( "variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,  category.category, subcategory.subcategory, common.description" );
		
		$result = $this->db->get ( "variety" )->result ();
		return $result;
	}

	function get_value($id, $field)
	{
		$this->db->where ( "id", $id );
		$this->db->select ( $field );
		$this->db->from ( "variety" );
		$output = $this->db->get ()->row ();
		return $output->$field;
	}

	function get_new_varieties($year)
	{
		$this->db->where ( "new_year", $year );
		$this->db->from ( "variety" );
		$this->db->select ( "new_year" );
		$this->db->join("orders","orders.variety_id = variety.id","RIGHT");
		$this->db->where("orders.year",$year);
		$result = $this->db->get ()->num_rows ();
// 		$this->_log();
		return $result;
	}

	function is_new($id, $year = NULL)
	{
		if (! $year) {
			$year = $this->session->userdata("sale_year");
		}
		$query = sprintf ( "select * from `orders`,variety where `orders`.`variety_id` = %s and variety.id = `orders`.variety_id  and  not exists(select `year` from `orders` where `year` < %s and variety_id = %s)  having `orders`.`year` = %s", $id, $year, $id, $year );
		$result = $this->db->query ( $query )->num_rows ();
		return $result;
	}

	function update_all($year)
	{
		if (IS_EDITOR) {
			$output = array ();
			$this->db->select ( "id" );
			$this->db->from ( "variety" );
			// $this->db->where("new_year IS NULL", NULL, false);
			$varieties = $this->db->get ()->result ();
			foreach ( $varieties as $variety ) {
				$query = sprintf ( "SELECT `orders`.`year` FROM `orders`,`variety` WHERE `orders`.`variety_id` = %s AND variety.id = `orders`.variety_id  AND NOT EXISTS(SELECT `year` FROM `orders` WHERE `year` < %s AND variety_id = %s)  HAVING `orders`.`year` = %s;", $variety->id, $year, $variety->id, $year );
				$new_year = $this->db->query ( $query )->row ();
				if ($new_year) {
					$this->update_status ( $variety->id, $year );
					$output [] = $this->get ( $variety->id );
				}
			}
		}
		return $output;
	}

	function update_status($id, $year)
	{
		$this->db->where ( "id", $id );
		$update = array (
				"new_year" => $year 
		);
		$this->db->update ( "variety", $update );
	}

	function get_varieties_for_year($year, $only_new = FALSE)
	{
		$this->db->from ( "variety" );
		$this->db->join ( "orders", "variety.id=orders.variety_id" );
		$this->db->join ( "common", "common.id = variety.common_id" );
		$this->db->where ( "orders.year", $year );
		if ($only_new) {
			$this->db->where ( "variety.new_year", $year );
		}
		$this->db->order_by ( "category_id" );
		$this->db->order_by ( "subcategory_id" );
		$this->db->order_by ( "common.name" );
		$this->db->order_by ( "variety.variety" );
		$this->db->select ( "variety.*" );
		$this->db->select ( "common.description,common.name" );
		$result = $this->db->get ()->result ();
		return $result;
	}

	/**
	 *
	 * @param int(4) $year
	 *        	get the varieties that are renewals from a previous
	 *        	year.
	 */
	function get_reorders($year)
	{
		$this->db->from ( "variety as v" );
		$this->db->from ( "orders as o" );
		$this->db->join ( "common as c", "v.common_id = c.id" );
		$this->db->join ( "category", "c.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "c.subcategory_id = subcategory.id", "LEFT" );
		$this->db->select ( "v.*" );
		$this->db->select ( "o.year,o.id as order_id" );
		$this->db->select ( "c.name,c.sunlight,c.genus" );
		$this->db->where ( "o.variety_id = v.id", NULL, FALSE );
		$this->db->where ( "o.year", $year );
		$this->db->where ( "v.new_year !=", $year );
		$this->db->order_by ( "category.category,c.name,c.genus,v.variety" );
		$result = $this->db->get ()->result ();
		return $result;
	}
	
	
	//@TODO this should be moved to orders model
	function get_category_totals($year)
	{
		$this->db->from ( "variety" );
		$this->db->join ( "orders", "variety.id=orders.variety_id" );
		$this->db->join ( "common", "common.id=variety.common_id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id = subcategory.id", "LEFT" );
		$this->db->where ( "orders.year", $year );
		/*
		 * //exclude bare root perennials $this->db->where("NOT
		 * (`orders`.`pot_size` LIKE '%bare%' AND `category`.`id` =
		 * 7)",NULL,FALSE); $this->db->where("subcategory_id !=", 3); // no
		 * hanging baskets $this->db->where("subcategory_id !=", 4); // no
		 * indoor annuals $this->db->where("subcategory_id !=", 8); // no
		 * perennial water plants
		 */
		$this->db->group_by ( "common.category_id" );
		$this->db->order_by ( "category.category" );
		$this->db->select ( "count(`variety`.`id`) as count,category.category,category.id" );
		$result = $this->db->get ()->result ();
		// $this->_log("alert");
		return $result;
	}
	
	//@TODO this should be moved to orders model
	function get_flat_totals($year)
	{
		$this->db->from ( "variety" );
		$this->db->join ( "orders", "variety.id=orders.variety_id" );
		$this->db->join ( "common", "common.id=variety.common_id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->where ( "orders.year", $year );
		// exclude bare root and bulb perennials
		$this->db->where ( "NOT (`orders`.`pot_size` LIKE '%bareroot%' AND `category_id` = 7 )", NULL, FALSE );
		$this->db->where ( "NOT (`orders`.`pot_size` LIKE '%bulb%' AND `category_id` = 7 )", NULL, FALSE );
		
		//subcategory3 = no hanging baskets
		//subcategory 4 =  no indoor annuals
		//subcategory 8 = no perennial water plants
		$this->db->where ( "((`common`.`subcategory_id` != 3 AND `common`.`subcategory_id` !=4 AND `common`.`subcategory_id` !=8 AND common.name NOT LIKE '%Peony%') OR `common`.`subcategory_id` IS NULL)", NULL, FALSE ); // plants
		
		$this->db->group_by ( "common.category_id" );
		$this->db->order_by ( "category.category" );
		$this->db->select ( "sum(`orders`.`count_presale`) as presale_count" );
		$this->db->select ( "sum(`orders`.`count_midsale`) as midsale_count" );
		$this->db->select ( "category.category,category.id as category_id" );
		$result = $this->db->get ()->result ();
// 		 $this->_log();
		return $result;
	}

	/**
	 * *
	 * maintenance function to update whether items need bags.
	 * This can be run at any time, but is generally run when the variety find
	 * function is run
	 */
	function update_needs_bag()
	{
		$query = sprintf ( "update `variety` SET needs_bag = 0;" );
		$this->db->query ( $query );
		$query = sprintf ( "update `variety`, `orders` SET `needs_bag` = 1 WHERE `orders`.`year` = '%s' AND `variety`.`id` = `orders`.`variety_id` and (`orders`.`pot_size` LIKE '%s' OR
`orders`.`pot_size` LIKE '%s'  OR
`orders`.`pot_size` LIKE '%s' OR
`orders`.`pot_size` LIKE '%s')", get_current_year (), "%bareroot%", "%bulb%", "%bulb%", "%pound%" );
		$this->db->query ( $query );
	}

	function find($variables, $order_by)
	{
		$this->update_needs_bag ();
		$my_parameters = ( object ) array ();
		for($i = 0; $i < count ( $variables ); $i ++) {
			$my_variable = $variables [$i];
			if ($this->input->get ( $my_variable ) && $this->input->get ( $my_variable ) != "") {
				$my_value = $this->input->get ( $my_variable );
				if ($my_value) {
					$my_parameters->$my_variable = new stdClass ();
					
					$my_parameters->$my_variable->key = $my_variable;
					$my_parameters->$my_variable->value = $my_value;
				}
			}
		}
		if (! is_array ( $order_by )) {
			$order_by = array (
					$order_by 
			);
		}
		for($i = 0; $i < count ( $order_by ["fields"] ); $i ++) {
			$order_field = "catalog_number";
			if (array_key_exists ( "fields", $order_by ) && ! empty ( $order_by ["fields"] [$i] )) {
				$order_field = $order_by ["fields"] [$i];
			}
			
			$order_direction = "ASC";
			if (array_key_exists ( "direction", $order_by ) && ! empty ( $order_by ["direction"] [$i] )) {
				$order_direction = $order_by ["direction"] [$i];
			}
			
			if ($order_field == "subcategory") {
				$this->load->helper ( "export" );
				$this->db->order_by ( "(" . subcategory_order () . ")" );
				$this->db->order_by("subcategory.subcategory");
			} else {
				$this->db->order_by ( $order_field, $order_direction );
			}
		}
		$this->db->from ( "variety" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id = subcategory.id", "LEFT" );
		$this->db->join ( "flag", "variety.id = flag.variety_id", "LEFT" );
		$this->db->join ( "orders", "variety.id = orders.variety_id", "RIGHT" );
		if ($this->input->get ( "no_image" )) {
			$this->db->join ( "image", "variety.id = image.variety_id", "LEFT" );
			$this->db->where ( "image.id IS NULL", NULL, FALSE );
		}
		foreach ( $my_parameters as $parameter ) {
			if ($parameter->key == "sunlight") {
				if ($this->input->get ( "sunlight-boolean" ) == "or") {
					$my_list = $parameter->value;
					foreach ( $parameter->value as $my_item ) {
						$this->db->or_like ( "sunlight", "$my_item" );
					}
				} elseif ($this->input->get ( "sunlight-boolean" ) == "only") {
					$this->db->where ( "sunlight", implode ( ",", $parameter->value ) );
				} else {
					$this->db->like ( "sunlight", implode ( ",", $parameter->value ) );
				}
			} elseif (trim ( $parameter->value ) == "NULL" && $parameter->key != "name") {
				$this->db->where ( "$parameter->key IS NULL" );
			} elseif (trim ( $parameter->value ) == "NOT NULL" && $parameter->key != "name") {
				$this->db->where ( "$parameter->key IS NOT NULL" );
			} elseif ($parameter->key == "name") {
				$this->db->like ( "common.name", $parameter->value );
			} elseif ($parameter->key == "flag") {
				if ($this->input->get ( "not_flag" ) == 1) {
					$this->db->where ( sprintf ( "NOT EXISTS(SELECT 1 from flag where `flag`.`name` ='%s' AND `variety`.`id` = `flag`.`variety_id`)", urldecode ( $parameter->value ) ), NULL, FALSE );
				} else {
					$this->db->where ( "flag.name", urldecode ( $parameter->value ) );
				}
			} elseif ($parameter->key == "year") {
				$this->db->where ( "orders.year", $parameter->value );
			} elseif (in_array ( $parameter->key, array (
					"variety",
					"genus",
					"species",
					"description",
					"print_description",
					"web_description" ,
					"edit_notes",
					"pot_size",
			) )) {
				$this->db->like ( $parameter->key, $parameter->value );
				}elseif($parameter->key=="descriptions"){
					$this->db->where("(`common`.`description` LIKE '%$parameter->value%' OR `variety`.`web_description` LIKE '%$parameter->value%' OR `variety`.`print_description` LIKE '%$parameter->value%')",NULL,FALSE);
				
			} elseif ($parameter->key == "omit") {
				$this->db->where ( "(orders.omit is NULL OR orders.omit != 1)", NULL, FALSE );
			} elseif ($parameter->key == "not_flag") {
				// no action taken
			} elseif ($parameter->key == "category_id") {
				$this->db->where ( "common.category_id", $parameter->value );
			}elseif($parameter->key == "crop_failure"){
				$this->db->where("orders.received_presale",0);
			}elseif($parameter->key == "needs_bag"){
				$this->db->where("(pot_size LIKE '%bulb%' OR pot_size LIKE '%bag' OR pot_size LIKE '%bareroot%' OR pot_size LIKE '%pound%')", NULL, FALSE);
				
			} else {
				$this->db->where ( $parameter->key, $parameter->value );
			}
		}
		// select common fields
		$this->db->select ( "common.name,common.genus, common.sunlight, category.category, subcategory.subcategory,common.description" );
		// include all variety fields (maybe change this).
		$this->db->select ( "variety.*" );
		
		// select orders fields
		$this->db->select ( "orders.id as order_id,year,flat_size,flat_cost,plant_cost,pot_size,price,count_presale,count_midsale,count_dead,omit" );
		$this->db->select ( "sellout_friday,sellout_saturday,remainder_friday,remainder_saturday,remainder_sunday,grower_code,grower_id,catalog_number" );
		$this->db->group_by ( "variety.id" );
		$result = $this->db->get ()->result ();
	$this->_log();
		return $result;
	}

	function get_for_web($year)
	{
		$this->db->from ( "variety" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "orders", "variety.id = orders.variety_id" );
		$this->db->join ( "category", "common.category_id=category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id=subcategory.id", "LEFT" );
		$this->db->where ( "orders.year", $year );
		$this->db->select ( "variety.id, variety.web_id, variety.common_id, variety.plant_color,variety.variety,variety.species, variety.min_height,variety.max_height,variety.height_unit,variety.min_width,variety.max_width,
        variety.width_unit,variety.new_year,variety.print_description,variety.web_description" );
		$this->db->select ( "common.other_names" );
		$this->db->select ( "orders.catalog_number,orders.year, orders.price,orders.pot_size,orders.count_midsale" );
		$this->db->select ( "category.category" );
		$this->db->select ( "subcategory.subcategory" );
		$result = $this->db->get ()->result ();
		// $this->_log("alert");
		return $result;
	}

	function get_last_web_id()
	{
		$query = "select web_id from variety orders by web_id DESC LIMIT 1";
		$web_id = $this->db->query ( $query )->row ()->web_id + 1;
		return $web_id;
	}

	function update_web_ids()
	{
		$query = "SELECT id FROM variety WHERE web_id IS NULL";
		$web_id = $this->get_last_web_id ();
		$result = $this->db->query ( $query )->result ();
		foreach ( $result as $item ) {
			// $query = "SET @rank:=$web_id; update variety set
			// web_id=@rank:=@rank+1 where web_id is null";
			$this->_update ( "variety", $item->id, array (
					"web_id" => $web_id 
			) );
			$web_id ++;
		}
	}

	function delete($id)
	{
		if ($this->ion_auth->in_group ( array (
				1,
				2 
		) )) {
			
			$this->db->delete ( "variety", array (
					'id' => $id 
			) );
			$this->db->delete ( "orders", array (
					'variety_id' => $id 
			) );
			$this->db->delete ( "flag", array (
					'variety_id' => $id 
			) );
		} else {
			return FALSE;
		}
	}
	
	
}