<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Color extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("color_model", "color");
		$this->load->model("common_model", "common");
		$this->load->model("order_model", "order");
		$this->load->model("flag_model","flag");
	}

	function index()
	{
		redirect();
	}

	function create()
	{
		$this->load->model("menu_model","menu");
		$data["target"] = "color/edit";
		$data["color"] = "";
		$data["common_id"] = $this->input->get("common_id");
		$measure_units = $this->menu->get_pairs("measure_unit");
		$data["measure_units"] = get_keyed_pairs($measure_units,array("key","value"),TRUE);
		$data["action"] = "insert";
		$data["title"] = "Add a new color";
		$this->load->view($data["target"], $data);
	}

	function insert()
	{
		$id = $this->color->insert();
		if( $this->input->post("add_order")){
			$data["color_id"] = $id;
			$data["action"] = "insert";
			$this->load->view("order/edit", $data);
		}else{
			redirect("color/view/$id");
		}


	}

	function view()
	{
		$id = $this->uri->segment(3);
		$color = $this->color->get($id);
		$current_order = $this->order->get_for_color($id, get_current_year());
		$data["current_order"] = $current_order;
		$data["orders"] = $this->order->get_for_color($id);
		$data["flags"] = $this->flag->get_for_color($id);
		$data["color"] = $color;
		$data["target"] = "color/view";
		$data["title"] = sprintf("Viewing Info for %s (Color)", $color->color);
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

	function delete()
	{
		$id = $this->input->post("id");
		$common_id = $this->color->get_value($id,"common_id");
		$this->color->delete($id);
		if($this->input->post("ajax")){
			echo $common_id;
		}else{
			redirect("common/view/$common_id");
		}

	}

	function update_value()
	{

		$id = $this->input->post("id");
		$values =	array($this->input->post("field") => $value = $this->input->post("value"));
		$this->color->update($id, $values);
		echo $this->input->post("value");
	}

	function add_flag()
	{
		$id = $this->input->get("id");
		$flags = $this->flag->get_missing($id);
		$data["flags"] = get_keyed_pairs($flags, array("key","value"),TRUE);
		$this->load->view("flag/edit",$data);
	}

	function insert_flag()
	{
		$id = $this->flag->insert();
		$this->get_flags($this->input->post("color_id"));
	}

	function get_flags($id)
	{
		$data["flags"] = $this->flag->get_for_color($id);
		$this->load->view("flag/list",$data);
	}

	function delete_flag()
	{
		$id = $this->input->post("id");
		$this->flag->delete($id);
		$this->get_flags( $this->input->post("color_id"));
	}

}