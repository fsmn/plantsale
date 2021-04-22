<?php
class Subcategory extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('subcategory_model', 'subcategory');
	}

	function update_value()
	{
		$id = $this->input->post('id');
		$value = urldecode($this->input->post('value'));
		$field = $this->input->post('field');
		$values = [
			$field => $value
		];
		$output = $this->subcategory->update($id, $values);

		print $output;
	}

	function create($category_id)
	{
		$this->load->model('category_model', 'category');
		$category = $this->category->get($category_id);
		$data['category_id'] = $category_id;
		$data['title'] = sprintf('Create a New Subcategory for %s', $category->category);
		$data['target'] = 'subcategory/edit';
		$data['action'] = 'insert';
		$data['subcategory'] = FALSE;
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		} else {
			$this->load->view('page/index', $data);
		}
	}

	function insert()
	{
		if ($subcategory = $this->input->post('subcategory')) {
			$category_id = $this->input->post("category_id");
			if (!$this->subcategory->exists($category_id, $subcategory)) {
				$this->subcategory->insert($category_id, $subcategory);
			}
		}
		redirect('category');
	}
}
