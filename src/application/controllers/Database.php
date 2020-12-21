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
		$this->load->model('Update_model', 'updater');
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
	function db_update_1(): string {
		return 'ALTER TABLE `orders` CHANGE `count_midsale` `count_midsale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_2(): string {
		return 'ALTER TABLE `orders` CHANGE `count_presale` `count_presale` DECIMAL(10,2) NULL DEFAULT NULL;';

	}

	/**
	 * @return string
	 */
	function db_update_3(): string {
		return 'ALTER TABLE `orders` CHANGE `received_midsale` `received_midsale` DECIMAL(10,2) NULL DEFAULT NULL;';

	}

	/**
	 * @return string
	 */
	function db_update_4(): string {
		return 'ALTER TABLE `orders` CHANGE `received_presale` `received_presale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_5(): string {
		return 'ALTER TABLE `orders` CHANGE `received_presale` `received_presale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_6(): string {
		return 'ALTER TABLE `orders` CHANGE `received_presale` `received_presale` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_7(): string {
		return 'ALTER TABLE `orders` CHANGE `count_dead` `count_dead` DECIMAL(10,2) NULL DEFAULT NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_8(): string {
		return 'UPDATE `variety` set new_year = 2021 where new_year = 2020;';
	}

	/**
	 * @return string
	 */
	function db_update_9(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `count_thursday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_10(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `count_friday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_11(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `count_saturday` DECIMAL(10,2) NULL;';

	}

	/**
	 * @return string
	 */
	function db_update_12(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `received_thursday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_13(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `received_friday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_14(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `received_saturday` DECIMAL(10,2) NULL;';
	}

	/**
	 * @return string
	 */
	function db_update_15(): string {
		return 'ALTER TABLE `orders` ADD IF NOT EXISTS `flat_exclude` BOOLEAN NOT NULL DEFAULT FALSE';
	}

	/**
	 * @return string
	 */
	function db_update_16(): string {
		return 'ALTER TABLE `users_groups` DROP INDEX IF EXISTS `fk_users_groups_users1_idx`;';

	}


	/**
	 * @return string
	 */
	function db_update_17(): string {
		return 'ALTER TABLE `users_groups` DROP INDEX IF EXISTS `fk_users_groups_groups1_idx`;';

	}

	/**
	 * @return string
	 */
	function db_update_18(): string {
		return 'ALTER TABLE `users_groups` DROP INDEX IF EXISTS `uc_users_groups`;';
	}


}
