<?php defined("BASEPATH") OR exit("No direct script access allowed");

// common.php Chris Dart Feb 17, 2013 6:21:00 PM chrisdart@cerebratorium.com

class Common extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("common_model","common");
		$this->load->model("color_model","color");
		$this->load->model("menu_model","menu");

	}

	function index()
	{
		redirect();
	}

	function search()
	{
		$categories = $this->menu->get_pairs("common_category",array("field"=>"value","direction"=>"ASC"));
		$data["categories"] = get_keyed_pairs($categories, array("key","value"));
		$sunlight = $this->menu->get_pairs("sunlight",array("field"=>"value"));
		$data["sunlight"] = $sunlight;
		$data["common"] = NULL;
		$this->load->view("common/search",$data);
	}

	function find()
	{
		$output = $this->common->find();
	}

	function search_by_name()
	{
		$name = $this->input->get("name");
		$data["names"] = $this->common->get_by_name($name);
		$data["full_list"] = FALSE;
		$target = "common/list";
		$this->load->view($target, $data);
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$common = $this->common->get($id);
		$data["colors"] = $this->color->get_by_common($id);
		$data["common"] = $common;
		$data["title"] = sprintf("Viewing Common Name: %s",$common->name);
		$data["target"] = "common/view";
		$this->load->view("page/index", $data);
	}

	function create()
	{
		$categories = $this->menu->get_pairs("common_category",array("field"=>"value","direction"=>"ASC"));
		$data["categories"] = get_keyed_pairs($categories, array("key","value"));
		$sunlight = $this->menu->get_pairs("sunlight",array("field"=>"value"));
		$data["sunlight"] = $sunlight;
		$data["action"] = "insert";
		$data["target"] = "common/edit";
		$data["common"] = NULL;
		$data["title"] = "Insert a New Common Name";
		$this->load->view($data["target"],$data);

	}

	function insert()
	{
		$id = $this->common->insert();
		redirect("common/view/$id");

	}

	function edit()
	{
		$id = $this->uri->segment(3);
		$categories = $this->menu->get_pairs("common_category",array("field"=>"value","direction"=>"ASC"));
		$data["categories"] = get_keyed_pairs($categories, array("key","value"));
		$sunlight = $this->menu->get_pairs("sunlight",array("field"=>"value"));
		$data["sunlight"] = $sunlight;
		$data["action"] = "update";
		$data["target"] = "common/edit";
		$data["common"] = $this->common->get($id);
		$data["title"] = "Edit Common Name";
		if($this->input->get("ajax")){
			$this->load->view($data["target"], $data);
		}else{
			$this->load->view("page/index",$data);
		}
	}

	function update()
	{
		$id = $this->input->post("id");
		$this->common->update($id);
		redirect("common/view/$id");
	}

	function update_value()
	{
		$id = $this->input->post("id");
		$value = $this->input->post("value");
		$field = $this->input->post("field");
		if($this->input->post("format") == "checkbox"){
			$value = implode(",", $this->input->post("value"));
		}
		$values = array($this->input->post("field") => $value);
		echo $this->common->update($id, $values);
	}
}