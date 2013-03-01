<?php defined('BASEPATH') OR exit('No direct script access allowed');

// order.php Chris Dart Feb 28, 2013 9:38:32 PM chrisdart@cerebratorium.com

class Order extends MY_Controller
{
	function __construct()
	{
		parent::_construct();
		$this->load->model("order_model", "order");
	}
	
	function index()
	{
		echo "Hello World";
	}

	function update_value()
	{
		echo $this->input->get("value");
		die();
		$id = $this->input->get("id");
		$values = array($this->input->get("field") => $value = $this->input->get("value"));
		$this->order->update($id, $values);
	}

}