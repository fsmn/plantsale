<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('order_model', 'order');
	}

	function index($catalog_number = NULL)
	{
		$data['title'] = 'Inventory Search';
		$data['target'] = 'inventory/search';
		$data['catalog_number'] = $catalog_number;
		$this->load->view('inventory/index', $data);
	}

	function search()
	{
		if ($catalog_number = $this->input->get('catalog_number')) {
			$this->_clean($catalog_number);
			$item = $this->order->get_by_cat($catalog_number);
			if ($item) {
				$data['item'] = $item;
				$data['title'] = 'Verify Item';
				$data['target'] = 'inventory/verify';
				$this->load->view('inventory/index', $data);
			} else {
				$this->_log('The catalog number you entered, ' . $catalog_number . ', did not return any results. Try again.');
				redirect('inventory/index/' . $catalog_number);
			}
		} else {
			$this->_log('You did not enter a catalog number. This doesn\'t work unless you enter a catalog number.');
			redirect('inventory/index');
		}
	}

	function verify($catalog_number, $step = 1)
	{
		$this->_clean($catalog_number);
		$item = $this->order->get_by_cat($catalog_number);

		if ($item) {
			$data['step'] = $step;
			$data['item'] = $item;
			$data['title'] = format_string('Inventory for @catalog_number: @name @variety (@latin_name)', [
				'@catalog_number' => $item->catalog_number,
				'@name' => $item->name,
				'@variety' => $item->variety,
				'@latin_name' => format_latin_name($item),
			]);
			$data['target'] = 'inventory/edit';
			$this->load->view('inventory/index', $data);
		}
	}

	function check()
	{
		$variables = array(
			//'received_presale',
			'sellout_friday',
			//'remainder_friday',
			//'received_midsale',
			'sellout_saturday',
			//'remainder_sunday',
			//'count_dead' 
		);
		if ($this->input->post('step') == 1) {
			if ($catalog_number = $this->input->post('catalog_number')) {
				$this->_log('Please verify your entries to make sure they are correct');
				foreach ($variables as $variable) {
					bake_cookie($variable, $this->input->post($variable));
				}
				redirect('inventory/verify/' . $catalog_number . '/2');
			} else {
				$this->_log('Something went wrong with the submission, the catalog number was missing.');
				redirect('inventory/index');
			}
		} else {

			$values = array();
			$message = array();
			foreach ($variables as $variable) {
				if ($value = $this->input->post($variable)) {
					$values[$variable] = $this->input->post($variable);
					$message[] = format_string('@variable: @post_variable', [
						'@variable' => $variable,
						'@post_variable' => $this->input->post($variable),
					]);
				}
				burn_cookie($variable);
			}
			$this->order->sellout($this->input->post('id'), $values);
			$this->_log('This item has been updated with the following values ' .  implode(',', $message));
			redirect('inventory/index');
		}
	}

	function _clean(&$catalog_number)
	{
		$catalog_number = trim(preg_replace('/[^a-zA-Z0-9\']+/', '', $catalog_number));
	}

	function _log($string, $target = 'warning')
	{
		parent::_log($string, $target);
	}
}
