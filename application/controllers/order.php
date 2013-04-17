<?php defined('BASEPATH') OR exit('No direct script access allowed');

// order.php Chris Dart Feb 28, 2013 9:38:32 PM chrisdart@cerebratorium.com

class Order extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("order_model", "order");
	}
	
	function index()
	{
		
	}
	
	function view()
	{
		$id = $this->uri->segment(3);
		$order = $this->order->get($id);
		$data["order"] = $order;
		$data["target"] = "order/view";
		$data["title"] = "Viewing Order Details";
		$this->load->view("page/index", $data);
	}

	function update_value()
	{

		$id = $this->input->post("id");
		$values = array($this->input->post("field") => $value = $this->input->post("value"));
		$output = $this->order->update($id, $values);
		if($this->input->post("format") == "currency"){
			$output = get_as_price($output);
		}
		echo $output;
	}
	
	function create()
	{
		$data["color_id"] = $this->input->get("color_id");
		$data["action"] = "insert";
		$data["target"] = "order/edit";
		$data['title'] = "Insert New Order";
		$this->load->view($data["target"], $data);
		
	}
	
	function insert()
	{
		$order_id = $this->order->insert();
		$color_id = $this->input->post("color_id");
		redirect("color/view/$color_id");
	}

}