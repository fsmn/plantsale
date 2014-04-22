<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Index extends MY_Controller {
	function __construct() {
		parent::__construct ();
	}

	function index() {
		$data ["title"] = "Plant Sale Database";
		$data ["target"] = "welcome";
		$this->load->model ( "order_model", "order" );

		if (! get_cookie ( "sale_year" )) {
			bake_cookie ( "sale_year", $this->order->get_current_year () );
		}
		$sale_year = get_cookie("sale_year");
		$this->load->model("variety_model","variety");
		$totals = new stdClass();
		$data["sale_year"] = $sale_year;
		$totals->total["current"] = $this->order->get_plant_total($sale_year);
		$totals->total["previous"] = $this->order->get_plant_total($sale_year-1);
		$totals->price_range["current"] = $this->order->get_price_range($sale_year);
		$totals->price_range["previous"] = $this->order->get_price_range($sale_year-1);
		$totals->new_varietys["current"] = $this->variety->get_new_varietys($sale_year);
		$totals->new_varietys["previous"] = $this->variety->get_new_varietys($sale_year -1);
		$totals->varietys["current"] =  $this->variety->get_varietys_for_year($sale_year);
		$totals->varietys["previous"] = $this->variety->get_varietys_for_year($sale_year -1);

		$data["totals"] = $totals;

		$this->load->view ( "page/index", $data );
	}

	function show_set_year(){
		$data["uri"] = $this->input->get("uri");
		$this->load->view("utility/sale_year", $data);
	}


	function set_year(){

		$year = $this->input->get("sale_year");
		bake_cookie("sale_year", $year);
		redirect($this->input->get("uri"));
	}

	function get_categories(){
	    $this->load->model("variety_model","variety");
	    $sale_year = get_cookie("sale_year");
	    $categories["current"] = $this->variety->get_category_totals($sale_year);
	    $categories["previous"] = $this->variety->get_category_totals($sale_year -1);
	    $data["categories"] = $categories;
	    $this->load->view("variety/totals", $data);
	}
}