<?php

/**
 * Class Database
 */
class Database extends MY_Controller {

	/**
	 * Database constructor.
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('Update_model','updater');
	}


	/**
	 *
	 */
	function run_updates() {
		$messages = [];
		foreach (get_class_methods('Database') as $method) {
			if ($my_method = strstr($method, 'db_update_')) {
				$id = (int) filter_var($my_method, FILTER_SANITIZE_NUMBER_INT);
				$query = $this->$my_method();
				if ($message = $this->updater->update($id, $query)) {
					$messages[] = $message;
				}
			}
		}
		$this->session->set_flashdata('notice', implode('<br/>', $messages));
		redirect();
	}

	/**
	 * @return string
	 */
	function db_update_2() {
		return 'ALTER TABLE `orders` CHANGE `count_midsale` `count_midsale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_3() {
		return 'ALTER TABLE `orders` CHANGE `count_presale` `count_presale` DECIMAL(10,2) NULL DEFAULT NULL;';

	}

	/**
	 * @return string
	 */
	function db_update_4() {
		return 'ALTER TABLE `orders` CHANGE `received_midsale` `received_midsale` DECIMAL(10,2) NULL DEFAULT NULL;';

	}

	/**
	 * @return string
	 */
	function db_update_5() {
		return 'ALTER TABLE `orders` CHANGE `received_presale` `received_presale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_6() {
		return 'ALTER TABLE `orders` CHANGE `received_presale` `received_presale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_7() {
		return 'ALTER TABLE `orders` CHANGE `received_presale` `received_presale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_8() {
		return 'ALTER TABLE `orders` CHANGE `count_dead` `count_dead` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_9() {
		return 'UPDATE `variety` set new_year = 2021 where new_year = 2020;';
	}

	/**
	 * @return string
	 */
	function db_update_10(){
		return 'ALTER TABLE `orders` ADD `count_thursday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_11(){
		return 'ALTER TABLE `orders` ADD `count_friday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_12(){
		return 'ALTER TABLE `orders` ADD `count_saturday` DECIMAL(10,2) NULL;';

	}

	/**
	 * @return string
	 */
	function db_update_13(){
		return 'ALTER TABLE `orders` ADD `received_thursday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_14(){
		return 'ALTER TABLE `orders` ADD `received_friday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_15(){
		return 'ALTER TABLE `orders` ADD `received_saturday` DECIMAL(10,2) NULL;';
	}

	function db_update_16(){
		return 'CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT \'\',
  `value` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT \'\',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;';
	}

	function db_update_17(){
		return 'ALTER TABLE `orders` ADD `flat_exclude` INT(1) NULL;';
	}

}

