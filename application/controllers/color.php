<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Color extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("color_model", "color");
		$this->load->model("common_model", "common");
		$this->load->model("order_model", "order");
	}

	function index()
	{
		redirect();
	}

	function create()
	{
		$data["target"] = "color/edit";
		$data["color"] = "";
		$data["common_id"] = $this->input->get("common_id");
		$data["action"] = "insert";
		$data["title"] = "Add a new color";
		$this->load->view($data["target"], $data);
	}

	function insert()
	{
		$id = $this->color->insert();
		redirect("color/view/$id");
	}

	function view()
	{
		$id = $this->uri->segment(3);
		$color = $this->color->get($id);
		$data["color"] = $color;
		$data["target"] = "color/view";
		$data["title"] = sprintf("Viewing Info for %s (Color)", $color->name);
		$this->load->view("page/index", $data);


	}

	function edit()
	{

	}

	function update()
	{
		$id = $this->input->post("id");
		$this->color->update("id");
		redirect("color/view/$id");
	}

	function update_value()
	{

		$id = $this->input->post("id");
		$values =	array($this->input->post("field") => $value = $this->input->post("value"));
		$this->color->update($id, $values);
		echo $this->input->post("value");
	}

}