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
		
		$pot_sizes = $this->order->get_pot_sizes ();
		$data ["pot_sizes"] = get_keyed_pairs ( $pot_sizes, array (
				"pot_size",
				"pot_size" 
		) );
		$this->load->view ( "order/search", $data );
	
	}

	function totals() {

		$options = array ();
		
		if (! $sale_year = $this->input->get ( "sale_year" )) {
			$sale_year = get_cookie ( "sale_year" );
		}
		
		if ($category = $this->input->get ( "category" )) {
			bake_cookie ( "category", $category );
			$options ["category"] = $category;
		} else {
			burn_cookie ( "category" );
		}
		if ($grower_id = $this->input->get ( "grower_id" )) {
			bake_cookie ( "grower_id", $grower_id );
			$options ["grower_id"] = $grower_id;
		} else {
			burn_cookie ( "grower_id" );
		}
		if ($pot_size = urldecode ( $this->input->get ( "pot_size" ) )) {
			bake_cookie ( "pot_size", $pot_size );
			$options ["pot_size"] = $pot_size;
		} else {
			burn_cookie ( "pot_size" );
		}
		
		if ($flat_size = $this->input->get ( "flat_size" )) {
			bake_cookie ( "flat_size", $flat_size );
			$options ["flat_size"] = $flat_size;
		} else {
			burn_cookie ( "flat_size" );
		}
		
		$sorting ["fields"] = array (
				"catalog_number" 
		);
		$sorting ["direction"] = array (
				"ASC" 
		);
		
		if ($this->input->get ( "sorting" )) {
			$sorting ["fields"] = $this->input->get ( "sorting" );
			$sorting ["direction"] = $this->input->get ( "direction" );
		}
		
		bake_cookie ( "sorting", implode ( ",", $sorting ["fields"] ) );
		bake_cookie ( "direction", implode ( ",", $sorting ["direction"] ) );
		
		$orders = $this->order->get_totals ( $sale_year, $options, $sorting );
		$data ["options"] = $options;
		$data ["orders"] = $orders;
		$data ["title"] = "List of $category orders for $sale_year";
		$data ["target"] = "order/full_list";
		$data ["show_names"] = TRUE;
		$this->load->view ( "page/index", $data );
	
	}

	function show_sort() {

		$this->load->view ( "order/sort" );
	
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
		$pot_sizes = $this->order->get_pot_sizes ();
		$data ["pot_sizes"] = get_keyed_pairs ( $pot_sizes, array (
				"pot_size",
				"pot_size" 
		) );
		$data ["action"] = "insert";
		$data ["target"] = "order/edit";
		$data ['title'] = "Insert New Order";
		$this->load->view ( $data ["target"], $data );
	
	}

	function edit() {

		$id = $this->input->get ( "id" );
		$data ["order"] = $this->order->get ( $id );
		$data ["variety_id"] = $data ["order"]->variety_id;
		$pot_sizes = $this->order->get_pot_sizes ();
		$data ["pot_sizes"] = get_keyed_pairs ( $pot_sizes, array (
				"pot_size",
				"pot_size" 
		) );
		$data ["action"] = "update";
		$data ["target"] = "order/edit";
		$data ['title'] = "Update Order";
		$this->load->view ( $data ["target"], $data );
	
	}

	function insert() {

		$order_id = $this->order->insert ();
		$variety_id = $this->input->post ( "variety_id" );
		redirect ( "variety/view/$variety_id" );
	
	}

	function update() {

		$id = $this->input->post ( "id" );
		$variety_id = $this->input->post ( "variety_id" );
		$this->order->update ( $id );
		redirect ( "variety/view/$variety_id" );
	
	}

	function delete() {

		if ($id = $this->input->post ( "id" )) {
			echo $this->order->delete ( $id );
		}
	
	}

}