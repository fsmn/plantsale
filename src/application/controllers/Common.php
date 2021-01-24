<?php
defined("BASEPATH") or exit ("No direct script access allowed");

// common.php Chris Dart Feb 17, 2013 6:21:00 PM chrisdart@cerebratorium.com
class Common extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("common_model", "common");
		$this->load->model("variety_model", "variety");
		$this->load->model("menu_model", "menu");
		$this->load->model("category_model", "category");
		$this->load->model("subcategory_model", "subcategory");
		if (IS_INVENTORY) {
			redirect("inventory");
		}
	}

	function index() {
	}

	function search() {
		if ($this->input->get("find")) {
			$data ["names"] = $this->common->find();
			$data ["title"] = "List of Common Names";
			$data ["target"] = "common/list";
			$data ["full_list"] = TRUE;

			// create the legend for the parameter display
			$variables = [
				"name",
				"genus",
				"category_id",
				"subcategory_id",
				"sunlight",
				"description",
				"year",
			];
			$params = [];
			for ($i = 0; $i < count($variables); $i++) {
				$my_variable = $variables [$i];
				if ($my_value = $this->input->get($my_variable)) {
					$params [$my_variable] = $my_value;
					bake_cookie($my_variable, $my_value);
				}
				else {
					burn_cookie($my_variable);
				}
			}

			$data ["params"] = $params;

			$this->load->view("page/index", $data);
		}
		else {
			$this->_search();
		}
	}

	function _search() {
		$data ["categories"] = get_keyed_pairs($this->category->get_pairs(), [
			"key",
			"value",
		], TRUE);
		$data ["subcategories"] = get_keyed_pairs($this->subcategory->get_pairs(), [
			"key",
			"value",
		], TRUE);
		$data ["sunlight"] = $this->menu->get_pairs("sunlight", [
			"field" => "value",
		]);;
		$data ["common"] = NULL;
		$data ["target"] = "common/search";
		if ($this->input->get("ajax")) {
			$this->load->view("common/search", $data);
		}
		else {
			$this->load->view("page/index", $data);
		}
	}

	function search_by_name() {
		$name = $this->input->get("name");
		$data ["names"] = $this->common->get_by_name($name);
		$data ["full_list"] = FALSE;
		if ($this->input->get("type") == "inline") {
			$target = "common/inline_list";
		}
		else {
			$target = "common/list";
		}
		$this->load->view($target, $data);
	}

	function view($id) {
		$common = $this->common->get($id);
		if ($common) {
			$data ["varieties"] = $this->variety->get_for_common($id);
			$data["relatives"] = $this->common->get_relatives($id, $common->genus);
			$data ["common"] = $common;
			$data ["title"] = sprintf("Viewing Common Name: %s", $common->name);
			$data ["target"] = "common/view";
			$this->load->view("page/index", $data);
		}
		else {
			$data ["target"] = "error";
			$data ["title"] = "Missing Common Record";
			$data ["message"] = "The common record for id $id could not be found.";
			$this->load->view("page/index", $data);
		}
	}

	function get_name($id) {
		$name = $this->common->get_value($id, "name");
		echo $name;
	}

	function create() {

		$data ["categories"] = get_keyed_pairs($this->category->get_pairs(), [
			"key",
			"value",
		], TRUE);
		$data ["subcategories"] = get_keyed_pairs($this->subcategory->get_pairs(), [
			"key",
			"value",
		], TRUE);

		$data ["sunlight"] = $this->menu->get_pairs("sunlight", [
			"field" => "value",
		]);;
		$data ["action"] = "insert";
		$data ["target"] = "common/edit";
		$data ["common"] = NULL;
		$data ["title"] = "Insert a New Common Name";
		$this->load->view($data ["target"], $data);
	}

	function insert() {
		$id = $this->common->insert();
		redirect("common/view/$id");
	}

	function edit($id) {
		$data ["categories"] = get_keyed_pairs($this->category->get_pairs(), [
			"key",
			"value",
		], TRUE);
		$data ["subcategories"] = get_keyed_pairs($this->subcategory->get_pairs(), [
			"key",
			"value",
		], TRUE);
		$data ["sunlight"] = $this->menu->get_pairs("sunlight", [
			"field" => "value",
		]);
		$data ["action"] = "update";
		$data ["target"] = "common/edit";
		$data ["common"] = $this->common->get($id);
		$data ["title"] = "Edit Common Name";
		if ($this->input->get("ajax")) {
			$this->load->view($data ["target"], $data);
		}
		else {
			$this->load->view("page/index", $data);
		}
	}

	function update() {
		$id = $this->input->post("id");
		$this->common->update($id);
		redirect("common/view/$id");
	}

	function update_value() {
		$id = $this->input->post("id");
		$value = $this->input->post("value");
		$field = $this->input->post("field");
		if (is_array($value)) {
			$value = implode(",", $value);
		}
		$values = [
			$field => $value,
		];
		$output = $this->common->update($id, $values);
		if ($output == "") {
			$output = "&nbsp;";
		}
		/*
		 * special tasks for categories: need to return the category name
		 * instead of the value for improved UX
		 */
		if ($category = $this->input->post("category")) {
			switch ($field) {
				case "category_id" :
					$this->load->model("category_model", "category");
					$output = $this->category->get($value)->category;
					break;
				case "subcategory_id" :
					$this->load->model("subcategory_model", "subcategory");
					if ($sub = $this->subcategory->get($value)) {
						$output = $sub->subcategory;
					}
					break;
			}
		}
		echo $output;
	}

	function delete($common_id = NULL) {
		if (!empty($common_id)) {
			$data['varieties'] = $this->variety->get_for_common($common_id);
			$data['common'] = $this->common->get($common_id);
			$data['target'] = 'common/delete';
			$data['title'] = 'Delete a Common Record';
			if($this->input->get('ajax')){
				$this->load->view($data['target'], $data);
			}else {
				$this->load->view('page/index', $data);
			}
		}
		elseif ($id = $this->input->post("id")) {
			if ($this->variety->get_for_common($id) == FALSE) {
				$common = $this->common->get($id);
				$this->common->delete($id);
				$this->session->set_flashdata('alert','Common ' . $common->name . ' ' . $common->genus. ' has been deleted.');
				redirect("index");
			}
		}
	}

}
