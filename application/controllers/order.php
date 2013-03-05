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
		$this->load->view("order/row", $data);
		
	}
	
	function insert()
	{
		$order_id = $this->order->insert();
		$color_id = $this->input->post("color_id");
		redirect("color/view/$color_id");
	}

}