<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Order_Model extends MY_Model {


	/**
	 * @var
	 */
	public $variety_id;

	public $grower_id;

	public $catalog_number;

	public $year;

	public $flat_size;

	public $flat_cost;

	public $flat_area;

	public $tiers;

	public $pot_size;

	public $plant_cost;

	public $price;

	public $count_presale = 0.0;

	public $count_midsale = 0.0;

	public $received_presale;

	public $received_midsale;

	public $count_dead;

	public $sellout_friday;

	public $sellout_saturday;

	public $remainder_friday;

	public $remainder_saturday;

	public $remainder_sunday;

	public $grower_code;

	public $omit = 0;

	public $flat_exclude = 0;

	public $rec_modified = 0;

	var $rec_modifier;

	function __construct() {
		parent::__construct();
	}

	function prepare_variables() {

		$variables = get_class_vars('Order_Model');
		foreach ($variables as $my_variable => $value) {
			$my_value = $this->input->post($my_variable);
			if ($my_value === '0') {
				$this->{$my_variable} = 0;
			}
			elseif (!empty($my_value)) {
				$this->{$my_variable} = urldecode($my_value);
		}
	}



		$this->rec_modified = mysql_timestamp();
		$this->rec_modifier = $this->session->userdata('user_id');
	}

	function insert() {
		$this->prepare_variables();
		$id = $this->_insert('orders');
		return $id;
	}

	function clear($id, $field) {
		$this->db->query('UPDATE `orders` SET ' . $field . ' = NULL');
		return $this->get_value($id, $field);
	}

	function update($id, $values = []) {
		return $this->_update('orders', $id, $values);
	}

	function sellout($id, $values) {
		$this->db->where('id', $id);
		$this->db->update('orders', $values);
		return TRUE;
	}

	function delete($id) {
		$order = $this->get($id);
		$variety_id = $order->variety_id;
		$this->_delete('orders', $id);
		return $variety_id;
	}

	function get($id) {
		$this->db->where('orders.id', $id);
		$this->db->from('orders,variety');
		$this->db->where('`orders`.`variety_id` = `variety`.`id`');
		$this->db->select('orders.*, variety.variety');
		$output = $this->db->get()->row();
		return $output;
	}

	function get_for_variety($variety_id, $year = FALSE) {
		$this->db->where('variety_id', $variety_id);
		if ($year) {
			$this->db->where('year', $year);
		}
		$this->db->from('orders');
		$this->db->join('grower', 'orders.grower_id=grower.id', 'LEFT OUTER');
		$this->db->select('orders.*,grower.grower_name');
		$this->db->order_by('year', 'desc');
		if ($year) {
			$output = $this->db->get()->row();
		}
		else {
			$output = $this->db->get()->result();
		}
		// $this->_log ( 'alert' );
		return $output;
	}

	function get_totals($sale_year, $options = [], $order_by = [
		'fields' => ['catalog_number'],
		'direction' => ['ASC'],
	]) {
		$this->db->from('orders');
		$this->db->join('variety', 'orders.variety_id = variety.id');
		$this->db->join('common', 'variety.common_id = common.id');
		$this->db->join('category', 'common.category_id = category.id', 'LEFT');
		$this->db->join('subcategory', 'common.subcategory_id = subcategory.id', 'LEFT');
		$this->db->join('flag', 'flag.variety_id=variety.id', 'LEFT');
		$option_keys = array_keys($options);
		$option_values = array_values($options);
		for ($i = 0; $i < count($options); $i++) {
			$key = $option_keys [$i];
			$value = $option_values [$i];
			switch ($key) {
				case 'show-non-reorders' :
					$this->db->where(sprintf('NOT EXISTS (SELECT `year` from `orders` as `o` WHERE `o`.`variety_id` = `orders`.`variety_id` and `year` = %s) ', $sale_year + 1), NULL, FALSE);
					break;
				case 'category_id' :
					$this->db->where('common.category_id', $value);
					break;
				case 'subcategory_id' :
					$this->db->where('common.subcategory_id', $value);
					break;
				case 'plant_cost' :
				case 'price' :
				case 'flat_cost' :

					$this->where_operator($key, $value);
					break;
				case 'flag' :
					$this->db->where('flag.name', $value);
					break;
				case 'needs_bag':
					$this->db->where('(pot_size LIKE \'%bulb%\' OR pot_size LIKE \'%bag\' OR pot_size LIKE \'%bareroot%\' OR pot_size LIKE \'%pound%\')', NULL, FALSE);
					break;
				case 'received_presale':
					$this->db->where('received_presale', $value);
					break;
				case 'name' :
					$this->db->like('common.name', $value);
					break;
				case 'year' :
					break;
				case 'flat_exclude':
					$this->db->where('flat_exclude', $value);
					break;
				default :
					$this->db->like($key, $value);
			}
		}
		$this->db->where('orders.year', $sale_year);

		if (!is_array($order_by)) {
			$order_by = [
				$order_by,
			];
		}
		for ($i = 0; $i < count($order_by ['fields']); $i++) {
			[
				$order_by,
				$order_field,
				$order_direction,
			] = $this->create_order_by($order_by, $i, 'catalog_number');

			// if the $order_field is a price field or integer, sort as number.
			if ($order_field == 'flat_size') {
				$this->db->order_by('CAST(`' . $order_field . '` as DECIMAL)', $order_direction);
			}
			elseif ($order_field == 'subcategory') {
				$this->load->helper('export');
				$this->db->order_by('(' . subcategory_order() . ')');
				$this->db->order_by('subcategory.subcategory');
			}
			else {
				$this->db->order_by($order_field, $order_direction);
			}
		}
		$this->db->select('orders.*');
		$this->db->select('IF(`orders`.`count_presale` IS NULL, 0,`orders`.`count_presale`) + IF(`orders`.`count_midsale` IS NULL,0,`orders`.`count_midsale`) as `flat_count`, flat_exclude', FALSE);
		$this->db->select('variety.variety, variety.species,variety.new_year');
		$this->db->select('common.name, common.genus, common.category_id, common.subcategory_id, common.id as common_id');
		$this->db->select('category.category,subcategory.subcategory');
		$this->db->group_by('orders.id');
		$result = $this->db->get()->result();
		$this->_log();
		return $result;
	}

	function get_current_year() {
		$this->db->from('orders');
		$this->db->order_by('year', 'DESC');
		$this->db->group_by('year');
		$this->db->limit(1);
		$result = $this->db->get()->row();
		return $result->year;
	}

	function get_previous_year($variety_id, $current_year) {
		$this->db->from('orders');
		$this->db->where('variety_id', $variety_id);
		$this->db->where('year <', $current_year);
		$this->db->join('variety', 'orders.variety_id=variety.id');
		$this->db->select('orders.id,
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
				orders.grower_code');

		$this->db->select('variety.variety');
		$this->db->order_by('year', 'DESC');
		$this->db->group_by('year');
		$this->db->limit(1);
		$result = $this->db->get()->row();
		return $result;
	}

	/**
	 * Get all crop failures for plants ordered only once and then forgotten.
	 *
	 * @param array $options
	 * @param array $order_by
	 *
	 * @return mixed
	 */
	function get_crop_failures($options = [], $order_by = []) {
		$where = [];
		$query = 'SELECT * from
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
			AS `w` where `w`.`c` = 1 and (w.received_presale = 0.000) %s';
		foreach ($options as $key => $value) {
			switch ($key) {
				case 'category_id' :
					$where [] = sprintf('`subcat`.`%s` = \'%s\'', $key, $value);
					break;
				default :
					$where [] = sprintf('`%s` = \'%s\'', $key, $value);
			}
		}
		for ($i = 0; $i < count($order_by ['fields']); $i++) {

			[
				$order_by,
				$order_field,
				$order_direction,
			] = $this->create_order_by($order_by, $i, 'year');

			// if the $order_field is a price field or integer, sort as number.
			if ($order_field == 'flat_size') {
				$order [] = ('CAST(`' . $order_field . '` as DECIMAL) ' . $order_direction);
			}
			elseif ($order_field == 'subcategory') {
				$this->load->helper('export');
				$order [] = ('(' . subcategory_order() . ')');
				$order[] = 'subcategory.subcategory';
			}
			else {
				$order [] = ($order_field . ' ' . $order_direction);
			}
		}
		$where_string = '';
		if (!empty($where)) {
			$where_string = sprintf('WHERE %s', implode(' AND ', $where));
		}
		$query = sprintf($query, $where_string, 'ORDER BY ' . implode(' AND ', $order));

		$result = $this->db->query($query)->result();
		$this->_log();
		return $result;
	}

	function is_latest($variety_id, $current_year) {
		$this->db->from('orders');
		$this->db->where('variety_id', $variety_id);
		$this->db->where('year >', $current_year);
		$this->db->order_by('year', 'DESC');
		$this->db->group_by('year');
		$result = $this->db->get()->num_rows;
		$output = TRUE;
		if ($result == 1) {
			$output = FALSE;
		}
		return $output;
	}

	function get_for_catalog($year, $category = NULL) {
		$this->db->from('orders');
		$this->db->join('variety', 'orders.variety_id = variety.id');
		$this->db->join('common', 'variety.common_id = common.id');
		$this->db->join('category', 'common.category_id = category.id', 'LEFT');
		$this->db->join('subcategory', 'common.subcategory_id = subcategory.id', 'LEFT');
		$this->db->where('orders.year', $year);
		if ($category) {
			$this->db->where('common.category_id', $category);
		}
		$this->db->order_by('category.category', 'ASC');
		$this->load->helper('export');
		$this->db->order_by('(' . subcategory_order() . ')');
		$this->db->order_by('subcategory.subcategory');
		$this->db->order_by('common.name', 'ASC');
		$this->db->order_by('orders.price', 'ASC');
		$this->db->order_by('orders.pot_size', 'ASC');
		$this->db->order_by('variety.variety', 'ASC');
		$this->db->select('orders.id,category.category');
		$result = $this->db->get()->result();
		// $this->_log ( 'alert' );
		return $result;
	}

	function get_value($id, $field) {
		$this->db->where('id', $id);
		$this->db->select($field);
		$this->db->from('orders');
		$output = $this->db->get()->row();
		return $output->$field;
	}

	function get_by_cat($cat) {
		$this->db->where('catalog_number', trim($cat));
		$this->db->where('year', get_current_year());
		$this->db->from('orders');
		$this->db->join('variety', 'variety.id=orders.variety_id');
		$this->db->join('common', 'common.id=variety.common_id');
		$this->db->join('image', 'orders.variety_id=image.variety_id');
		$this->db->select('orders.*');
		$this->db->select('variety.variety,variety.species');
		$this->db->select('common.name,common.genus');
		$this->db->select('image.image_name, image.image_path');
		$this->db->limit(1);
		$result = $this->db->get()->row();
		return $result;
	}

	function get_pot_sizes() {
		$this->db->from('orders');
		$this->db->select('pot_size');
		$this->db->group_by('pot_size');
		$this->db->order_by('pot_size');
		$result = $this->db->get()->result();
		return $result;
	}

	function get_plant_total($year): int {
		$columns = [
			'count_presale',
			'count_midsale',
			'count_friday',
			'count_saturday',
		];
		$totals = 0;
		foreach ($columns as $column) {
			$totals += $this->get_column_total($column, $year);
		}
		return $totals;
	}

	function get_column_total($column, $year) {
		$total_label = $column . '_total';
		$this->db->from('orders');
		$this->db->where('year', $year);
		$this->db->select('SUM(`' . $column . '`) AS `' . $total_label . '`');
		return $this->db->get()->row()->$total_label;
	}

	function get_price_range($year = NULL) {
		$this->db->from('orders');
		$this->db->select('min(`plant_cost`) as `min_price`, max(`plant_cost`) as `max_price` , avg(`plant_cost`) as `average_price`');
		$this->db->where('year', $year);
		$result = $this->db->get()->row();
		return $result;
	}

	/**
	 *
	 * @param int(4) $base_year
	 * @param int(4) $comparison_year
	 */
	function get_non_reorders($base_year, $comparison_year) {
		$query = sprintf('select * from `orders` as `o`, `variety` as `v` WHERE `v`.`id`= `o`.`variety_id` and `o`.`year` =%s
        and not exists (select `year` from `orders`, `variety` where `o`.`variety_id` = `orders`.`variety_id` and `year` =%s)', $base_year, $comparison_year);
	}

	function batch_update($ids, $values) {
		if (IS_ADMIN) {
			$this->db->from('orders');
			$this->db->where_in('id', explode(',', $ids));
			$this->db->set($values);
			$this->db->update();
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function where_operator($field, $value) {
		$operator = preg_replace('/[^\<\>\=\!]/', '', $value);

		$value = preg_replace('/[^0-9.,]/', '', $value);
		switch ($operator) {
			case '=' :
				$this->db->where($field, $value);
				break;
			case '>' :
			case '<' :
				$this->db->where('CAST(`$field` AS DECIMAL) $operator', $value, NULL, FALSE);
				break;
			default :
				$this->db->like($field, $value);
		}
	}


	function test() {
		$this->db->from('variety');
		$this->db->where('variety.id', 3166);
		$this->db->join('flag', 'variety.id = flag.variety_id');
		$this->db->join('flag_token', 'flag.name = flag_token.flag', 'LEFT');

		return $this->db->get()->row();
	}


	function reset_flat_exclusions() {
		$reset = "UPDATE `orders` SET flat_exclude=0";
		$this->db->query($reset);
		//exclude bulbs, bareroot and tubers from the sale years.
		$query = "UPDATE `orders` SET flat_exclude=1  WHERE `pot_size` LIKE '%bareroot%' OR `pot_size` LIKE '%bulb%' OR `pot_size` LIKE '%tuber%' OR `pot_size` like '%seed%'";
		$this->db->query($query);
		// exclude peonies from every year except the COVID-19-modified sale year 2021
		$query = "UPDATE `orders`  JOIN `variety` ON `orders`.`variety_id` = `variety`.`id`
    JOIN `common` ON `common`.`id`  = `variety`.`common_id` 
    SET `orders`.`flat_exclude` = 1 
			WHERE `common`.`genus` = 'Paeonia' AND `orders`.`year` != 2021";
		$this->db->query($query);
		$this->session->set_flashdata('notice', 'Flat exclusions have been reset.');
	}

	/**
	 * @param array $order_by
	 * @param int $i
	 * @param string $order_field
	 *
	 * @return array
	 */
	protected function create_order_by(array $order_by, int $i, string $order_field): array {
		if (array_key_exists('fields', $order_by) && !empty ($order_by ['fields'] [$i])) {
			$order_field = $order_by ['fields'] [$i];
		}
		$order_direction = 'ASC';
		if (array_key_exists('direction', $order_by) && !empty ($order_by ['direction'] [$i])) {
			$order_direction = $order_by ['direction'] [$i];
		}
		return [$order_by, $order_field, $order_direction];
	}

}
