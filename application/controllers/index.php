<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index extends MY_Controller {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		$data ["title"] = "Plant Sale Database";
		$data ["target"] = "welcome";
		$this->load->model ( "order_model", "order" );
		
		if (! get_cookie ( "sale_year" )) {
			$this->load->model ( "order_model", "order" );
			bake_cookie ( "sale_year", $this->order->get_current_year () );
		}
		$sale_year = get_cookie("sale_year");
		
		$totals = new stdClass();
		$data["sale_year"] = $sale_year;
		$totals->total["current"] = $this->order->get_plant_total($sale_year);
		$totals->total["previous"] = $this->order->get_plant_total($sale_year-1);
		$totals->price_range["current"] = $this->order->get_price_range($sale_year);
		$totals->price_range["previous"] = $this->order->get_price_range($sale_year-1);
		$this->load->model("color_model","color");
		$totals->new_colors["current"] = $this->color->get_new_colors($sale_year);
		$totals->new_colors["previous"] = $this->color->get_new_colors($sale_year -1);
		$totals->colors["current"] =  $this->color->get_colors_for_year($sale_year);
		$totals->colors["previous"] = $this->color->get_colors_for_year($sale_year -1);
		$totals->categories["current"] = $this->color->get_category_totals($sale_year);
		$totals->categories["previous"] = $this->color->get_category_totals($sale_year -1);
		$data["totals"] = $totals;
		
		$this->load->view ( "page/index", $data );
	}
}