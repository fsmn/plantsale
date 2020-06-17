<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Order_Model extends MY_Model {
	var $variety_id;
	var $grower_id;
	var $catalog_number;
	var $year;
	var $flat_size;
	var $flat_cost;
	var $flat_area;
	var $tiers;
	var $pot_size;
	var $plant_cost;
	var $price;
	var $count_presale;
	var $count_midsale;
	var $received_presale;
	var $received_midsale;
	var $count_dead;
	var $sellout_friday;
	var $sellout_saturday;
	var $remainder_friday;
	var $remainder_saturday;
	var $remainder_sunday;
	var $grower_code;
	var $omit;
	var $rec_modified;
	var $rec_modifier;

	function __construct()
	{
		parent::__construct ();
	}

	function prepare_variables()
	{
		$variables = array (
				"variety_id",
				"grower_id",
				"catalog_number",
				"year",
				"flat_size",
				"flat_cost",
				"pot_size",
				"plant_cost",
				"price",
				"count_presale",
				"count_midsale",
				"received_presale",
				"received_midsale",
				"count_dead",
				"sellout_friday",
				"sellout_saturday",
				"remainder_friday",
				"remainder_saturday",
				"remainder_sunday",
				"flat_area",
				"tiers",
				"grower_code",
				"omit" 
		);
		
		for($i = 0; $i < count ( $variables ); $i ++) {
			$my_variable = $variables [$i];
			if ($this->input->post ( $my_variable )) {
				$this->$my_variable = urldecode ( $this->input->post ( $my_variable ) );
			}
		}
		
		$this->rec_modified = mysql_timestamp ();
		$this->rec_modifier = $this->session->userdata ( 'user_id' );
	}

	function insert()
	{
		$this->prepare_variables ();
		$id = $this->_insert ( "orders", $this );
		// $this->db->insert ( "orders", $this );
		// $id = $this->db->insert_id ();
		return $id;
	}

	function update($id, $values = array())
	{
		$output = $this->_update ( "orders", $id, $values );
		return $output;
	}
	
	function sellout($id, $values){
		$this->db->where("id",$id);
		$this->db->update("orders",$values);
		return TRUE;
	}

	function delete($id)
	{
		$order = $this->get ( $id );
		$variety_id = $order->variety_id;
		$this->_delete ( "orders", $id );
		return $variety_id;
	}

	function get($id)
	{
		$this->db->where ( "orders.id", $id );
		$this->db->from ( "orders,variety" );
		$this->db->where ( "`orders`.`variety_id` = `variety`.`id`" );
		$this->db->select ( "orders.*, variety.variety" );
		$output = $this->db->get ()->row ();
		return $output;
	}

	function get_for_variety($variety_id, $year = FALSE)
	{
		$this->db->where ( "variety_id", $variety_id );
		if ($year) {
			$this->db->where ( "year", $year );
		}
		$this->db->from ( "orders" );
		$this->db->join ( "grower", "orders.grower_id=grower.id", "LEFT OUTER" );
		$this->db->select ( "orders.*,grower.grower_name" );
		$this->db->order_by ( "year", "desc" );
		if ($year) {
			$output = $this->db->get ()->row ();
		} else {
			$output = $this->db->get ()->result ();
		}
		// $this->_log ( "alert" );
		return $output;
	}

	function get_totals($sale_year, $options = array(), $order_by = array("fields"=>array("catalog_number"),"direction"=>array("ASC")))
	{
		$this->db->from ( "orders" );
		$this->db->join ( "variety", "orders.variety_id = variety.id" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id = subcategory.id", "LEFT" );
		$this->db->join ( "flag", "flag.variety_id=variety.id", "LEFT" );
		$option_keys = array_keys ( $options );
		$option_values = array_values ( $options );
		for($i = 0; $i < count ( $options ); $i ++) {
			$key = $option_keys [$i];
			$value = $option_values [$i];
			switch ($key) {
				case "show-non-reorders" :
					$this->db->where ( sprintf ( "NOT EXISTS (SELECT `year` from `orders` as `o` WHERE `o`.`variety_id` = `orders`.`variety_id` and `year` = '%s') ", $sale_year + 1 ), NULL, FALSE );
					break;
				case "category_id" :
					$this->db->where ( "common.category_id", $value );
					break;
				case "subcategory_id" :
					$this->db->where ( "common.subcategory_id", $value );
					break;
				case "plant_cost" :
				case "price" :
				case "flat_cost" :
				
					$this->where_operator ( $key, $value );
					break;
				case "flag" :
					$this->db->where ( "flag.name", $value );
					break;
				case "needs_bag":
					$this->db->where("(pot_size LIKE '%bulb%' OR pot_size LIKE '%bag' OR pot_size LIKE '%bareroot%' OR pot_size LIKE '%pound%')", NULL, FALSE);
					break;
				case "received_presale":
					$this->db->where("received_presale",$value);
					break;
				case "name" :
					$this->db->like ( "common.name", $value );
					break;
				case "year" :
					break;
				default :
					$this->db->like ( $key, $value );
			}
		}
		$this->db->where ( "orders.year", $sale_year );
		
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
			
			// if the $order_field is a price field or integer, sort as number.
			if ($order_field == "flat_size") {
				$this->db->order_by ( "CAST(`$order_field` as DECIMAL)", $order_direction );
			} elseif ($order_field == "subcategory") {
				$this->load->helper ( "export" );
				$this->db->order_by ( "(" . subcategory_order () . ")" );
				$this->db->order_by("subcategory.subcategory");
			} else {
				$this->db->order_by ( $order_field, $order_direction );
			}
		}
		$this->db->select ( "orders.*" );
		$this->db->select ( "IF(`orders`.`count_presale` IS NULL, 0,`orders`.`count_presale`) + IF(`orders`.`count_midsale` IS NULL,0,`orders`.`count_midsale`) as `flat_count`", FALSE );
		$this->db->select ( "variety.variety, variety.species,variety.new_year" );
		$this->db->select ( "common.name, common.genus, common.category_id, common.subcategory_id, common.id as common_id" );
		$this->db->select ( "category.category,subcategory.subcategory" );
		$this->db->group_by ( "orders.id" );
		$result = $this->db->get ()->result ();
		return $result;
	}

	function get_current_year()
	{
		$this->db->from ( "orders" );
		$this->db->order_by ( "year", "DESC" );
		$this->db->group_by ( "year" );
		$this->db->limit ( 1 );
		$result = $this->db->get ()->row ();
		return $result->year;
	}

	function get_previous_year($variety_id, $current_year)
	{
		$this->db->from ( "orders" );
		$this->db->where ( "variety_id", $variety_id );
		$this->db->where ( "year <", $current_year );
		$this->db->join ( "variety", "orders.variety_id=variety.id" );
		$this->db->select ( "orders.id,
				orders.grower_id, 
				orders.year,
				orders.flat_size,
				orders.flat_cost,
				orders.flat_area,
				orders.tiers,
				orders.plant_cost,
				orders.pot_size,
				orders.price,
				orders.count_presale,
				orders.count_midsale,
				orders.grower_code" );
		
		$this->db->select ( "variety.variety" );
		$this->db->order_by ( "year", "DESC" );
		$this->db->group_by ( "year" );
		$this->db->limit ( 1 );
		$result = $this->db->get ()->row ();
		return $result;
	}

	/**
	 * Get all crop failures for plants ordered only once and then forgotten.
	 */
	function get_crop_failures($options = array(), $order_by = array())
	{
		$where =array();
		$query = "SELECT * from
			(SELECT v.id , c.name, c.genus, v.variety, v.species, v.common_id, o.year, COUNT(v.id) c, o.received_presale, o.catalog_number, o.count_presale, o.pot_size, o.flat_size, o.flat_cost, cat.category, subcat.subcategory,o.variety_id
			FROM    variety v
			LEFT JOIN 
				 `orders` o
				ON o.variety_id = v.id
			LEFT JOIN
				`common` c
				ON c.id = v.common_id
			LEFT JOIN
				category cat
				on cat.id = c.category_id
			LEFT JOIN
				subcategory subcat
				ON subcat.id = c.subcategory_id
				%s
			GROUP BY  v.id)
			AS `w` where `w`.`c` = 1 and (w.received_presale = 0.000) %s";
		foreach ( $options as $key => $value ) {
			switch ($key) {
				case "category_id" :
					$where [] = sprintf ( "`co`.`%s` = '%s'", $key, $value );
					break;
				default :
					$where [] = sprintf ( "`%s` = '%s'", $key, $value );
			}
		}
		for($i = 0; $i < count ( $order_by ["fields"] ); $i ++) {
			$order_field = "year";
			if (array_key_exists ( "fields", $order_by ) && ! empty ( $order_by ["fields"] [$i] )) {
				
				$order_field = $order_by ["fields"] [$i];
			}
			
			$order_direction = "ASC";
			if (array_key_exists ( "direction", $order_by ) && ! empty ( $order_by ["direction"] [$i] )) {
				$order_direction = $order_by ["direction"] [$i];
			}
			
			// if the $order_field is a price field or integer, sort as number.
			if ($order_field == "flat_size") {
				$order [] = ("CAST(`$order_field` as DECIMAL) $order_direction");
			} elseif ($order_field == "subcategory") {
				$this->load->helper ( "export" );
				$order [] = ("(" . subcategory_order () . ")");
				$order[] = "subcategory.subcategory";
			} else {
				$order [] = ("$order_field $order_direction");
			}
		}
		$where_string = "";
		if(!empty($where)){
			$where_string = sprintf("WHERE %s", implode ( " AND ", $where));
		}
		$query = sprintf ( $query, $where_string, "ORDER BY " . implode ( " AND ", $order ) );
		
		$result = $this->db->query ( $query )->result ();
		//$this->_log("alert");
		return $result;
	}

	function is_latest($variety_id, $current_year)
	{
		$this->db->from ( "orders" );
		$this->db->where ( "variety_id", $variety_id );
		$this->db->where ( "year >", $current_year );
		$this->db->order_by ( "year", "DESC" );
		$this->db->group_by ( "year" );
		$result = $this->db->get ()->num_rows;
		$output = TRUE;
		if ($result == 1) {
			$output = FALSE;
		}
		return $output;
	}

	function get_for_catalog($year, $category = NULL)
	{
		$this->db->from ( "orders" );
		$this->db->join ( "variety", "orders.variety_id = variety.id" );
		$this->db->join ( "common", "variety.common_id = common.id" );
		$this->db->join ( "category", "common.category_id = category.id", "LEFT" );
		$this->db->join ( "subcategory", "common.subcategory_id = subcategory.id", "LEFT" );
		$this->db->where ( "orders.year", $year );
		if ($category) {
			$this->db->where ( "common.category_id", $category );
		}
		$this->db->order_by ( "category.category", "ASC" );
		$this->load->helper ( "export" );
		$this->db->order_by ( "(" . subcategory_order () . ")" );
		$this->db->order_by ( "subcategory.subcategory" );
		$this->db->order_by ( "common.name", "ASC" );
		$this->db->order_by ( "orders.price", "ASC" );
		$this->db->order_by ( "orders.pot_size", "ASC" );
		$this->db->order_by ( "variety.variety", "ASC" );
		$this->db->select ( "orders.id,category.category" );
		$result = $this->db->get ()->result ();
		// $this->_log ( "alert" );
		return $result;
	}

	function get_value($id, $field)
	{
		$this->db->where ( "id", $id );
		$this->db->select ( $field );
		$this->db->from ( "orders" );
		$output = $this->db->get ()->row ();
		return $output->$field;
	}

	function get_by_cat($cat)
	{
		$this->db->where ( "catalog_number", trim ( $cat ) );
		$this->db->where ( "year", get_current_year () );
		$this->db->from ( "orders" );
		$this->db->join ( "variety", "variety.id=orders.variety_id" );
		$this->db->join ( "common", "common.id=variety.common_id" );
		$this->db->join ( "image", "orders.variety_id=image.variety_id" );
		$this->db->select ( "orders.*" );
		$this->db->select ( "variety.variety,variety.species" );
		$this->db->select ( "common.name,common.genus" );
		$this->db->select ( "image.image_name, image.image_path" );
		$this->db->limit ( 1 );
		$result = $this->db->get ()->row ();
		return $result;
	}

	function get_pot_sizes()
	{
		$this->db->from ( "orders" );
		$this->db->select ( "pot_size" );
		$this->db->group_by ( "pot_size" );
		$this->db->order_by ( "pot_size" );
		$result = $this->db->get ()->result ();
		return $result;
	}

	function get_plant_total($year)
	{
		// sum(flat_size * (count_presale + count_midsale))
		$query = sprintf ( "SELECT sum((`count_presale` + `count_midsale`)) as `total` FROM `orders` where `year` = '%s' ", $year );
		$result = $this->db->query ( $query )->row ();
		return $result->total;
	}

	function get_price_range($year = NULL)
	{
		$this->db->from ( "orders" );
		$this->db->select ( "min(`plant_cost`) as `min_price`, max(`plant_cost`) as `max_price` , avg(`plant_cost`) as `average_price`" );
		$this->db->where ( "year", $year );
		$result = $this->db->get ()->row ();
		return $result;
	}

	/**
	 *
	 * @param int(4) $base_year        	
	 * @param int(4) $comparison_year        	
	 */
	function get_non_reorders($base_year, $comparison_year)
	{
		$query = sprintf ( "select * from `orders` as `o`, `variety` as `v` WHERE `v`.`id`= `o`.`variety_id` and `o`.`year` ='%s'
        and not exists (select `year` from `orders`, `variety` where `o`.`variety_id` = `orders`.`variety_id` and `year` ='%s')", $base_year, $comparison_year );
	}

	function batch_update($ids, $values)
	{
		if (IS_ADMIN) {
			$this->db->from ( "orders" );
			$this->db->where_in ( "id", explode ( ",", $ids ) );
			$this->db->set ( $values );
			$this->db->update ();
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function where_operator($field, $value)
	{
		$operator = preg_replace ( "/[^\<\>\=\!]/", "", $value );
		
		$value = preg_replace ( "/[^0-9.,]/", "", $value );
		switch ($operator) {
			case "=" :
				$this->db->where ( $field, $value );
				break;
			case ">" :
			case "<" :
				$this->db->where ( "CAST(`$field` AS DECIMAL) $operator", $value, NULL, FALSE );
				break;
			default :
				$this->db->like ( $field, $value );
		}
	}

	

	function test()
	{
		$this->db->from ( "variety" );
		$this->db->where ( "variety.id", 3166 );
		$this->db->join ( "flag", "variety.id = flag.variety_id" );
		$this->db->join ( "flag_token", "flag.name = flag_token.flag", "LEFT" );
		
		return $this->db->get ()->row ();
	}
}
