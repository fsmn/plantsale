<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grower extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (IS_INVENTORY) {
			redirect('inventory');
		}
		$this->load->model('grower_model', 'grower');
		$this->load->model('contact_model', 'contact');
	}

	function view($id)
	{
		if ($grower = $this->grower->get($id)) {
			$grower->contacts = $this->contact->get_for_grower($id);
			$this->load->model('user_model', 'user');
			$users = $this->user->get_user_pairs();
			$data['users'] = get_keyed_pairs($users, [
				'id',
				'name',
			], TRUE);
			$data['grower'] = $grower;
			$data['target'] = 'grower/view';
			$data['title'] = format_string('Viewing Details for @id', ['@id' => $id]);
			$this->load->view('page/index', $data);
		} else {
			show_error('The grower with ID ' . $id . ' could not be found. Press the back arrow, and notify the database administrator if you believe this error is a mistake.');
		}
	}

	function is_unique($id)
	{
		$output = TRUE;
		if ($this->grower->is_unique($id) == 1) {
			$output = FALSE;
		}
		print $output;
		return $output;
	}

	function show_orphans()
	{
		$orphans = $this->grower->get_orphans();
		$data['title'] = 'Orphan Grower Records';
		$data['target'] = 'grower/orphans';
		if (!empty($orphans)) {
			$data['message'] = 'The Following Orphan Records were Found';
			$data['orphans'] = $orphans;
		} else {
			$data['orphans'] = NULL;
			$data['message'] = 'No Orphan Growers Were Found.';
		}
		$this->load->view('page/index', $data);
	}

	function create($id = NULL)
	{
		$data['grower'] = NULL;

		if ($id) {
			$data['grower'] = (object) [
				'id' => strtoupper($id),
			];
		}
		$this->load->model('user_model', 'user');
		$users = $this->user->get_user_pairs();
		$data['users'] = get_keyed_pairs($users, [
			'id',
			'name',
		], TRUE);
		$data['action'] = 'insert';
		$data['target'] = 'grower/edit';
		$data['title'] = 'Add New Grower';
		if ($this->input->get('ajax') == 1) {
			$this->load->view('page/modal', $data);
		} else {
			$this->load->view('page/index', $data);
		}
	}

	function insert()
	{
		$this->grower->insert();
		$id = $this->input->post('id');
		redirect('grower/view/' . $id);
	}

	function update_value()
	{
		$id = $this->input->post('id');
		$value = $this->input->post('value');
		$field = $this->input->post('field');
		if (is_array($value)) {
			$value = implode(',', $value);
		}
		if (!$value) {
			$value = 0;
		}
		$values = [
			$field => $value,
		];
		$output = $this->grower->update($id, $values);
		if ($output == '') {
			$output = '&nbsp;';
		}
		if ($field == 'user_id') {
			if ($value) {
				$this->load->model('user_model', 'user');
				$user = $this->user->get_user($value);
				$output = format_string('@first_name @last_name', [
					'@first_name' => $user->first_name,
					'@last_name' => $user->last_name,
				]);
			} else {
				$output = '&nbsp;';
			}
		}

		print $output;
	}

	function filter()
	{
		$data = [
			'title' => 'Filter Growers by Year',
			'target' => 'grower/filter',
		];
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		} else {
			$this->load->view('page/index', $data);
		}
	}

	function totals()
	{
		$year = $this->input->get('year');
		if (!$year) {
			$year = cookie('sale_year');
		}
		$data['year'] = $year;
		$data['orphan_count'] = count($this->grower->get_orphans());
		$ids = $this->grower->get_ids($year);
		$growers = [];
		$grand_total = 0;

		foreach ($ids as $id) {
			$my_grower = $this->grower->get_totals($id->id, $year);
			if ($this->input->get('export')) {
				$growers[] = $my_grower;
			} else {
				$growers[] = $this->load->view('grower/report/row', [
					'grower' => $my_grower,
					'year' => $year,
				], TRUE);
			}
			$grand_total += $my_grower->total;
			// $growers[$id] = $this->grower->get_totals($id->grower_id, $year);
		}
		$data['grand_total'] = $grand_total;
		$data['ids'] = $ids;
		$data['growers'] = $growers;
		$data['year'] = $year;
		$data['title'] = 'Totals Report by Grower for ' . $year;

		if ($this->input->get('export')) {
			$this->load->helper('download');
			$this->load->view('grower/report/export', $data);
		} else {
			$data['target'] = 'grower/report/list';
			$this->load->view('page/index', $data);
		}
	}
}
