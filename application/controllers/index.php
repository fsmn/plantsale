<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{

    function __construct ()
    {
        parent::__construct();
    }

    function index ()
    {
        $this->load->model("grower_model","grower");
        $data["title"] = "Plant Sale Database";
        $data["target"] = "welcome";
        $data["orphan_count"] = count($this->grower->get_orphans());
        $this->load->view("page/index", $data);
    }

    function test ()
    {
        $data["target"] = "test";
        $data["title"] = "Test";
        $this->load->view("page/index", $data);
    }

    /**
     * test which users are more adventurous and willing to click buttons
     * that aren't part of their direct work flow.
     * This is a way to find
     * out how users learn an interface
     */
    function user_test ()
    {
        $this->db->insert("user_log",
                array(
                        "username" => $this->session->userdata("username"),
                        "action" => "shmallow"
                ));
    }

    function show_set_year ()
    {
        $data["uri"] = $this->input->get("uri");
        $this->load->view("utility/sale_year", $data);
    }

    function set_year ()
    {
        $year = $this->input->get("sale_year");
        bake_cookie("sale_year", $year);
        redirect($this->input->get("uri"));
    }

    function get_order_totals ()
    {
        $sale_year = get_cookie("sale_year");
        if (! $sale_year) {
            $sale_year = get_current_year();
            bake_cookie("sale_year", $sale_year);
        }
        $totals = new stdClass();
        $this->load->model("order_model", "order");
        $this->load->model("variety_model", "variety");
        $data["sale_year"] = $sale_year;
        $totals->total["current"] = $this->order->get_plant_total($sale_year);
        $totals->total["previous"] = $this->order->get_plant_total($sale_year - 1);
        $totals->price_range["current"] = $this->order->get_price_range($sale_year);
        $totals->price_range["previous"] = $this->order->get_price_range($sale_year - 1);
        $totals->new_varieties["current"] = $this->variety->get_new_varieties($sale_year);
        $totals->new_varieties["previous"] = $this->variety->get_new_varieties($sale_year - 1);
        $totals->varieties["current"] = $this->variety->get_varieties_for_year($sale_year);
        $totals->varieties["previous"] = $this->variety->get_varieties_for_year($sale_year - 1);

        $data["totals"] = $totals;

        $this->load->view("order/totals", $data);
    }

    function get_categories ()
    {
        $this->load->model("variety_model", "variety");
        $sale_year = get_cookie("sale_year");
        if (! $sale_year) {
            $sale_year = get_current_year();
            bake_cookie("sale_year", $sale_year);
        }
        $categories["current"] = $this->variety->get_category_totals($sale_year);
        $categories["previous"] = $this->variety->get_category_totals($sale_year - 1);
        $data["categories"] = $categories;
        $this->load->view("variety/category_totals", $data);
    }

    function get_flats ()
    {
        $this->load->model("variety_model", "variety");
        $sale_year = get_cookie("sale_year");
        if (! $sale_year) {
            $sale_year = get_current_year();
        }
        $categories["current"] = $this->variety->get_flat_totals($sale_year);
        $categories["previous"] = $this->variety->get_flat_totals($sale_year - 1);
        $data["categories"] = $categories;
        $this->load->view("order/flat_totals", $data);
    }
}