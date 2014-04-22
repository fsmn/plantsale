<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// order.php Chris Dart Feb 28, 2013 9:38:32 PM chrisdart@cerebratorium.com
class Order extends MY_Controller {

	function __construct() {

		parent::__construct ();
		$this->load->model ( "order_model", "order" );
	
	}

	function index() {

	
	}

	function view() {

		$id = $this->uri->segment ( 3 );
		$order = $this->order->get ( $id );
		$data ["order"] = $order;
		$data ["target"] = "order/view";
		$data ["title"] = "Viewing Order Details";
		$this->load->view ( "page/index", $data );
	
	}

	function search() {

		$this->load->model ( "menu_model", "menu" );
		$categories = $this->menu->get_pairs ( "common_category", array (
				"field" => "value",
				"direction" => "ASC" 
		) );
		$data ["categories"] = get_keyed_pairs ( $categories, array (
				"key",
				"value" 
		), TRUE );
		$this->load->view ( "order/search", $data );
	
	}

	function totals() {

		if ($category = $this->input->get ( "category" )) {
			bake_cookie ( "category", $category );
			$options ["category"] = $category;
		}
		if ($vendor_id = $this->input->get ( "vendor_id" )) {
			bake_cookie ( "vendor_id", $vendor_id );
			$options ["vendor_id"] = $vendor_id;
		}
		if (! $sale_year = $this->input->get ( "sale_year" )) {
			$sale_year = get_cookie ( "sale_year" );
		}
		$orders = $this->order->get_totals ( $sale_year, $options );
		$data ["options"] = $options;
		$data ["orders"] = $orders;
		$data ["title"] = "List of $category orders for $sale_year";
		$data ["target"] = "order/full_list";
		$data ["show_names"] = TRUE;
		$this->load->view ( "page/index", $data );
	
	}

	function update_value() {

		$id = $this->input->post ( "id" );
		$values = array (
				$this->input->post ( "field" ) => $value = $this->input->post ( "value" ) 
		);
		$output = $this->order->update ( $id, $values );
		if ($this->input->post ( "format" ) == "currency") {
			$output = get_as_price ( $output );
		}
		echo $output;
	
	}

	function create() {

		$data ["variety_id"] = $this->input->get ( "variety_id" );
		$data ["order"] = $this->order->get_previous_year ( $data ["variety_id"], get_current_year () );
		$data ["action"] = "insert";
		$data ["target"] = "order/edit";
		$data ['title'] = "Insert New Order";
		$this->load->view ( $data ["target"], $data );
	
	}

	function insert() {

		$order_id = $this->order->insert ();
		$variety_id = $this->input->post ( "variety_id" );
		redirect ( "variety/view/$variety_id" );
	
	}

}