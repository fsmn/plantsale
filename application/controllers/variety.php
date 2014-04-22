<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Variety extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("variety_model", "variety");
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
		$data["target"] = "variety/edit";
		$data["variety"] = "";
		$data["common_id"] = $this->input->get("common_id");
		$measure_units = $this->menu->get_pairs("measure_unit");
		$data["measure_units"] = get_keyed_pairs($measure_units,array("key","value"),TRUE);
		$plant_colors = $this->menu->get_pairs("plant_color",array("field"=>"value","direction"=>"ASC"));
		$data["plant_colors"] = get_keyed_pairs($plant_colors, array("key","value"));
		$data["action"] = "insert";
		$data["title"] = "Add a new variety";
		$this->load->view($data["target"], $data);
	}

	function insert()
	{
		$id = $this->variety->insert();
		if( $this->input->post("add_order")){
			$data["variety_id"] = $id;
			$data["order"] = NULL;
			$data["action"] = "insert";
			$this->load->view("order/edit", $data);
		}else{
			redirect("variety/view/$id");
		}


	}

	function view()
	{
		$id = $this->uri->segment(3);
		$variety = $this->variety->get($id);
		$current_order = $this->order->get_for_variety($id, get_current_year());
		$data["current_order"] = $current_order;
		$data["orders"] = $this->order->get_for_variety($id);
		$data["flags"] = $this->flag->get_for_variety($id);
		$data["variety"] = $variety;
		$data["target"] = "variety/view";
		$data["title"] = sprintf("Viewing Info for %s (variety)", $variety->variety);
		$this->load->view("page/index", $data);


	}
	
	function search_by_name()
	{
		$name = $this->input->get("name");
		$data["names"] = $this->variety->get_by_name($name);
		$data["full_list"] = FALSE;
		if($this->input->get("type") == "inline"){
			$target = "variety/inline_list";
		}else{
			$target = "variety/list";
		}
		$this->load->view($target, $data);
	}

	function edit()
	{

	}

	function update()
	{
		$id = $this->input->post("id");
		$this->variety->update("id");
		redirect("variety/view/$id");
	}

	function delete()
	{
		$id = $this->input->post("id");
		$common_id = $this->variety->get_value($id,"common_id");
		$this->variety->delete($id);
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
		$this->variety->update($id, $values);
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
		$this->get_flags($this->input->post("variety_id"));
	}

	function get_flags($id)
	{
		$data["flags"] = $this->flag->get_for_variety($id);
		$this->load->view("flag/list",$data);
	}

	function delete_flag()
	{
		$id = $this->input->post("id");
		$this->flag->delete($id);
		$this->get_flags( $this->input->post("variety_id"));
	}

}