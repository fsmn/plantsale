<?php
class Category extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('category_model', 'category');
		$this->load->model('subcategory_model', 'subcategory');
	}

	function index()
	{
		$categories = $this->category->get_all();
		foreach ($categories as $category) {
			$category->subcategories = $this->subcategory->get_for_category($category->id);
		}
		$data['categories'] = $categories;
		$data['title'] = 'Category List';
		$data['target'] = 'category/list';
		$this->load->view('page/index', $data);
	}

	function create()
	{
		$data['title'] = 'Create a New Category';
		$data['target'] = 'category/edit';
		$data['action'] = 'insert';
		$data['category'] = FALSE;
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		} else {
			$this->load->view('page/index', $data);
		}
	}

	function insert()
	{
		if ($category = $this->input->post('category')) {
			if (!$this->category->exists($category)) {
				$this->category->insert($category);
			}
		}
		redirect('category');
	}

	function update_value()
	{
		$id = $this->input->post('id');
		$value = urldecode($this->input->post('value'));
		$field = $this->input->post('field');
		$values = [
			$field => $value
		];
		$output = $this->category->update($id, $values);

		print $output;
	}
}
