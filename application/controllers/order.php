<?php
defined('BASEPATH') or exit('No direct script access allowed');

// order.php Chris Dart Feb 28, 2013 9:38:32 PM chrisdart@cerebratorium.com
class Order extends MY_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model("order_model", "order");
        $this->load->model("category_model", "category");
    }

    function index ()
    {
    }

    function view ()
    {
        $id = $this->uri->segment(3);
        $order = $this->order->get($id);
        $data["order"] = $order;
        $data["target"] = "order/view";
        $data["title"] = "Viewing Order Details";
        $this->load->view("page/index", $data);
    }

    function search ()
    {
        if ($this->input->get("find")) {
            $this->load->model("menu_model", "menu");
            $categories = $this->category->get_pairs();

            $pot_sizes = $this->order->get_pot_sizes();
            $data["pot_sizes"] = get_keyed_pairs($pot_sizes,
                    array(
                            "pot_size",
                            "pot_size"
                    ));
            $this->load->view("order/search", $data);
        } else {
            $options = array();

            if (! $sale_year = $this->input->get("year")) {
                $sale_year = get_cookie("sale_year");
            } else {
                $options['year'] = $sale_year;
                // bake_cookie("sale_year", $sale_year);
            }

            if ($new_year = $this->input->get("new_year")) {
                $options['new_year'] = $new_year;
                bake_cookie("new_year", $new_year);
            } else {
                burn_cookie("new_year");
            }
            $keys = array(
                    "category",
                    "subcategory",
                    "name",
                    "genus",
                    "variety",
                    "species",
                    "grower_id",
                    "potsize",
                    "flat_size",
                    "crop_failure"
            );

            $this->set_options($options, $keys);

            if ($is_inventory = $this->input->get("is_inventory")) {
                bake_cookie("is_inventory", $is_inventory);
                $special_options["is_inventory"] = $is_inventory;
            } else {
                burn_cookie("is_inventory");
            }

            if ($show_last_only = $this->input->get("show_last_only")) {
                bake_cookie("show_last_only", $show_last_only);
            } else {
                burn_cookie("show_last_only");
            }

            $sorting["fields"] = array(
                    "catalog_number"
            );
            $sorting["direction"] = array(
                    "ASC"
            );

            if ($this->input->get("sorting")) {
                $sorting["fields"] = $this->input->get("sorting");
                $sorting["direction"] = $this->input->get("direction");
            }

            if ($this->input->get("show_names") == 1) {
                $data["show_names"] = TRUE;
            }

            $data["is_inventory"] = FALSE;
            if ($this->input->get("is_inventory") == 1) {
                $data["is_inventory"] = TRUE;
            }

            bake_cookie("sorting", implode(",", $sorting["fields"]));
            bake_cookie("direction", implode(",", $sorting["direction"]));
            $orders = $this->order->get_totals($sale_year, $options, $sorting);
            // $this->session->set_flashdata("notice",$this->db->last_query());
            foreach ($orders as $order) {
                $order->latest_order = $this->order->is_latest($order->variety_id, $order->year);
            }
            if ($show_last_only = $this->input->get("show_last_only")) {
                bake_cookie("show_last_only", $show_last_only);
                $options["Hiding Plants with Reorders Next Sale"] = "Yes";
            }
            $data["options"] = $options;
            $data["orders"] = $orders;
            if(!$category = $this->input->get("category")){
                $category = "All";
            }
            $data["title"] = "List of $category orders for $sale_year";
            if ($this->input->get("export")) {
                $this->load->helper("download");
                $this->load->view("order/export", $data);
            } else {
                $data["target"] = "order/full_list";
                $data["show_names"] = TRUE;
                $this->load->view("page/index", $data);
            }
        }
    }

    function show_sort ()
    {
        $this->load->view("order/sort");
    }

    function update_value ()
    {
        $id = $this->input->post("id");

        $values = array(
                $this->input->post("field") => $value = urldecode($this->input->post("value"))
        );
        $output = $this->order->update($id, $values);

        if ($this->input->post("format") == "currency") {
            $output = get_as_price($output);
        }
        echo $output;
    }

    function edit_cost ()
    {
        $id = $this->input->post("id");
        $data["order"] = $this->order->get($id);
        $this->load->view("order/edit_cost", $data);
    }

    function create ()
    {
        $data["variety_id"] = $this->input->get("variety_id");
        $data["order"] = $this->order->get_previous_year($data["variety_id"], get_current_year());
        if (empty($data["order"])) {
            $this->load->model("variety_model", "variety");
            $order = new stdClass();
            $order->variety = $this->variety->get($data["variety_id"])->variety;
            $data["order"] = $order;
        }
        $pot_sizes = $this->order->get_pot_sizes();
        $data["pot_sizes"] = get_keyed_pairs($pot_sizes, array(
                "pot_size",
                "pot_size"
        ));
        $data["action"] = "insert";
        $data["target"] = "order/edit";
        $data['title'] = "Insert New Order";
        $this->load->view($data["target"], $data);
    }

    function edit ($id)
    {
        $data["order"] = $this->order->get($id);
        $data["variety_id"] = $data["order"]->variety_id;
        $pot_sizes = $this->order->get_pot_sizes();
        $data["pot_sizes"] = get_keyed_pairs($pot_sizes, array(
                "pot_size",
                "pot_size"
        ));
        $data["action"] = "update";
        $data["target"] = "order/edit";
        $data['title'] = "Update Order";
        $this->load->view($data["target"], $data);
    }

    function insert ()
    {
        $order_id = $this->order->insert();
        // $variety_id = $this->input->post ( "variety_id" );
        redirect($this->input->post("redirect_url"));
    }

    function update ()
    {
        $id = $this->input->post("id");
        $variety_id = $this->input->post("variety_id");
        $this->order->update($id);
        // redirect ( "variety/view/$variety_id" );
        redirect($this->input->post("redirect_url"));
    }

    /**
     * this is one ugly function.
     * It should be more elegant if I were to use the update function, but it
     * isn't working correctly.
     */
    function update_cost ()
    {
        $id = $this->input->post("id");
        $plant_cost = $this->input->post("plant_cost");
        $flat_cost = $this->input->post("flat_cost");
        $flat_size = $this->input->post("flat_size");
        $this->order->update($id,
                array(
                        "flat_size" => $flat_size,
                        "flat_cost" => $flat_cost,
                        "plant_cost" => $plant_cost
                ));
        redirect($this->input->post("redirect_url"));
    }

    function delete ()
    {
        if ($id = $this->input->post("id")) {
            echo $this->order->delete($id);
        }
    }

    function get_pot_sizes ()
    {
        $pot_sizes = $this->order->get_pot_sizes();
        foreach ($pot_sizes as $pot_size) {
            $output[] = $pot_size->pot_size;
        }
        echo json_encode($output);
    }
}