<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (IS_INVENTORY) {
			redirect('inventory');
		}
		$this->load->model('menu_model', 'menu');
		$this->load->model('category_model', 'category');
		$this->load->model('subcategory_model', 'subcategory');
	}

	function show_all($category = FALSE)
	{
		if (IS_ADMIN) {
			$data['items'] = $this->menu->get_all($category);
			$data['categories'] = $this->menu->get_categories(FALSE);

			if ($category) {
				$data['title'] = 'Showing Menu Items for ' . $category;
			} else {
				$data['title'] = 'Showing All Menu Items';
			}
		} else {
			$data['title'] = 'You are not authorized to view this page.';
			$data['items'] = NULL;
			$this->session->set_flashdata('notice', 'You are not authorized to do edit menu items');
		}
		$data['target'] = 'menu/list';

		$this->load->view('page/index', $data);
	}

	function show_categories()
	{
		$data['categories'] = $this->menu->get_categories(FALSE);
		$data['target'] = 'menu/categories';
	}

	function create()
	{
		if (IS_ADMIN) {
			$data['title'] = 'Editing a Menu Item';
			$data['target'] = "menu/edit";
			$data['ajax'] = FALSE;
			$data['action'] = 'insert';
			$data['item'] = NULL;
			$data['categories'] = get_keyed_pairs($this->menu->get_categories(FALSE), [
				'category',
				'category',
			]);
			$page = 'page/index';
			if ($this->input->get('ajax')) {
				$data['ajax'] = TRUE;
				$page = $data['target'];
			}
			$this->load->view($page, $data);
		}
	}

	function edit($id = NULL)
	{
		if ($id) {
			$data['title'] = 'Editing a Menu Item';
			$data['target'] = 'menu/edit';
			$data['ajax'] = FALSE;
			$data['categories'] = get_keyed_pairs($this->menu->get_categories(FALSE), [
				'category',
				'category',
			]);

			$page = 'page/index';
			if ($this->input->get('ajax')) {
				$data['ajax'] = TRUE;

				$page = $data['target'];
			}

			if (IS_ADMIN) {
				$data['action'] = 'update';
				$data['item'] = $this->menu->get($id);
			} else {
				$data['item'] = NULL;
				$data['title'] = 'No Access';
				$data['action'] = FALSE;
			}
			$this->load->view($page, $data);
		}
	}

	function insert()
	{
		if (IS_ADMIN) {
			$item = $this->menu->insert();
			$this->session->set_flashdata('notice', 'The item was successfully added');
			redirect("menu/show_all/$item->category");
		}
	}

	function update()
	{
		if (IS_ADMIN) {
			if ($id = $this->input->post('id')) {
				$item = $this->menu->update($id);
				$this->session->set_flashdata('notice', 'The item was successfully updated');

				redirect('menu/show_all/' . $item->category);
			}
		}
	}

	function edit_value()
	{
		$data['name'] = $this->input->get('field');

		$value = $this->input->get('value');
		if ($value != '&nbsp;') {
			$data['value'] = $value;
		} else {
			$data['value'] = '';
		}
		if (is_array($value)) {
			$data['value'] = implode(',', $value);
		}
		$data['id'] = $this->input->get('id');
		$data["size"] = strlen($data['value']) + 5;
		$data['type'] = $this->input->get('type');
		$data['category'] = $this->input->get('category');

		switch ($data['type']) {
			case 'dropdown':
				$output = $this->_get_dropdown($data['category'], $data['value'], $data['name']);
				break;
			case 'user-dropdown':
				$output = $this->_get_user_dropdown($data['category'], $data['value'], $data['name']);
				break;
			case 'category-dropdown':
				$this->load->model('common_model', 'common');
				$common = $this->common->get($data['id']);
				$output = $this->_get_dropdown($data['category'], $common->category_id, $data['name']);
				break;
			case 'subcategory-dropdown':
				$this->load->model('common_model', 'common');
				$common = $this->common->get($data['id']);
				$output = $this->_get_dropdown($data['category'], $common->subcategory_id, $data['name'], $common->category_id);
				break;
			case 'pot-size':
				$this->load->model('order_model', 'orders');
				$pot_sizes = get_keyed_pairs($this->orders->get_pot_sizes(), [
					'pot_size',
					'pot_size',
				], FALSE, TRUE);
				$output = form_dropdown('pot_size', $pot_sizes, urlencode($data['value']));
				break;
			case 'multiselect':
				$output = $this->_get_multiselect($data['category'], $data['value'], $data['name']);
				break;
			case 'textarea':
				$output = form_textarea($data, $data['value']);
				break;
			case 'autocomplete':
				$data['type'] = 'text';
				$output = form_input($data, $data['value'], 'class="autocomplete"');
				break;
			case 'time':
			case 'email':
				$output = sprintf('<input type"%s" name="%s" id="%s" value="%s" size="%s"', $data['type'], $data['name'], $data['id'], $data['value'], $data['size']);
				break;
			default:
				$output = form_input($data);
		}

		print $output;
	}

	/**
	 * AJAX function to create quick-edit dropdown <select> fields (for use with
	 * the field editing AJAX functions in general.js
	 */
	function get_dropdown()
	{
		$category = $this->input->get('category');
		$value = $this->input->get('value');
		$field = $this->input->get('field');
		$parent_id = $this->input->get('parent');
		print $this->_get_dropdown($category, $value, $field, $parent_id);
	}

	/**
	 * AJAX function to create a quick-edit multiselect <select
	 * multiple="multiple"> fields
	 * (for use with the field editing AJAX functions in general.js
	 */
	function get_multiselect()
	{
		$category = $this->input->get('category');
		$value = explode(",", $this->input->get('value'));
		$field = $this->input->get('field');
		$categories = $this->menu->get_pairs($category, [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$pairs = get_keyed_pairs($categories, [
			'key',
			'value',
		]);
		$output = [];
		$output[] = form_multiselect($field, $pairs, $value, "id='$field'");
		$buttons = implode(' ', $output);
		print $buttons . sprintf($field);
	}

	/**
	 * This function is not currently used because parsing check boxes in AJAX
	 * is a pain in the ass.
	 */
	function get_checkbox()
	{
		$category = $this->input->get('category');
		$value = $this->input->get('value');
		$field = $this->input->get('field');
		$categories = $this->menu->get_pairs($category, [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$pairs = get_keyed_pairs($categories, [
			'key',
			'value',
		]);

		$output = [];
		for ($i = 0; $i < count($categories); $i++) {
			$checked = '';
			$item = $categories[$i];
			if ($item->value == $value) {
				$checked = 'checked';
			}

			$output[] = sprintf("<label for='%s'>%s</label><input type='checkbox' name='%s[$i]' id='%s' value='%s' %s/>", $item->value, $item->value, $field, $field, $item->value, $checked);
		}
		$buttons = implode(' ', $output);
		print $buttons . sprintf("<span class='button save-checkbox' target='%s'>Save</span>", $field);
	}

	function get_autocomplete()
	{
		$category = $this->input->get('category');
		$value = $this->input->get('value');
		$id = $this->input->get('id');
		$is_live = FALSE;
		if ($this->input->get('is_live')) {
			$is_live = $this->input->get('is_live');
		}
		switch ($category) {
			case 'category':
				$categories = $this->category->get_pairs();
				break;
			case 'subcategory':
				$category_id = $this->category->get_id($this->input->get('parent'));
				$categories = $this->subcategory->get_pairs($category_id);
				break;
			default:

				$categories = $this->menu->get_pairs($category, [
					'field' => 'value',
					'direction' => 'ASC',
				]);
		}

		// print create_autocomplete($categories, $value, $id, $is_live);
		print create_list($categories);
		// print form_dropdown ( $field, $pairs, $value, "class='save-field'" );
	}

	function _get_dropdown($category, $value, $field, $parent_id = FALSE)
	{
		switch ($category) {
			case 'category':
				$categories = $this->category->get_pairs();
				break;
			case 'subcategory':
				if ($parent_id) {
					$categories = $this->subcategory->get_pairs($parent_id);
				} else {
					$categories = $this->subcategory->get_pairs();
				}

				break;
			default:

				$categories = $this->menu->get_pairs($category, [
					'field' => 'value',
					'direction' => 'ASC',
				]);
		}

		$pairs = get_keyed_pairs($categories, [
			'key',
			'value',
		], TRUE);
		return form_dropdown($field, $pairs, $value, "class='live-field'");
	}

	function _get_user_dropdown($category, $value, $field)
	{
		$this->load->model('user_model', 'user');
		$users = $this->user->get_user_pairs();
		$pairs = get_keyed_pairs($users, ['id', 'name'], TRUE);
		if ($value) {
			$value = $this->user->get_by_name($value);
		}
		return form_dropdown($field, $pairs, $value, "class='live-field'");
	}

	function _get_multiselect($category, $value, $field)
	{
		$this->load->model('menu_model', 'menu');
		$categories = $this->menu->get_pairs($category, [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$pairs = get_keyed_pairs($categories, [
			'key',
			'value',
		]);
		$output = [];
		$output[] = form_multiselect($field, $pairs, explode(',', $value), "id='$field'");
		$buttons = implode(' ', $output);
		print $buttons . sprintf($field);
	}
}
