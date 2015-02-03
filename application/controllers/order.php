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
        print_r(get_cookie("sorting_fields"));
        print_r(get_cookie("sorting_direction"));
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
            $this->load->model("category_model", "category");
            $this->load->model("subcategory_model", "subcategory");
            $categories = $this->category->get_pairs();

            $pot_sizes = $this->order->get_pot_sizes();
            $data["pot_sizes"] = get_keyed_pairs($pot_sizes, array(
                    "pot_size",
                    "pot_size"
            ));
            $data["categories"] = get_keyed_pairs($categories, array(
                    "key",
                    "value"
            ), TRUE);
            $subcategories = $this->subcategory->get_pairs();
            $data["subcategories"] = get_keyed_pairs($subcategories, array(
                    "key",
                    "value"
            ), TRUE);

            $this->load->view("order/search", $data);
        } else {
            bake_cookie("order_search", $_SERVER['QUERY_STRING']);
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
                    "category_id",
                    "subcategory_id",
                    "name",
                    "genus",
                    "variety",
                    "species",
                    "grower_id",
                    "pot_size",
                    "flat_size",
                    "crop_failure",
                    "show-non-reorders",
                    "grower_code",
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
                bake_cookie("sorting_fields", serialize($sorting["fields"]));
                bake_cookie("sorting_direction", serialize($sorting["direction"]));
            }

            if ($this->input->get("export_type") == "grower") {
                $sorting["fields"] = array(
                        "grower_id",
                        "grower_code",
                        "genus",
                        "common.name",
                        "variety",
                        "species"
                );
                $sorting["direction"] = array(
                        "ASC",
                        "ASC",
                        "ASC",
                        "ASC",
                        "ASC",
                        "ASC"
                );
                bake_cookie("sorting_fields", serialize($sorting["fields"]));
                bake_cookie("sorting_direction", serialize($sorting["direction"]));
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
            foreach ($orders as $order) {
                $order->latest_order = $this->order->is_latest($order->variety_id, $order->year);
            }
            if ($show_last_only = $this->input->get("show_last_only")) {
                bake_cookie("show_last_only", $show_last_only);
                $options["Hiding Plants with Reorders Next Sale"] = "Yes";
            }
            $title_category = array();
            if (array_key_exists("category_id", $options)) {
                $this->load->model("category_model", "category");
                $category = $this->category->get($options["category_id"])->category;
                $options["category"] = $category;
                $title_category[] = $category;
                unset($options["category_id"]);
            }
            if (array_key_exists("subcategory_id", $options)) {
                $this->load->model("subcategory_model", "subcategory");
                $subcategory = $this->subcategory->get($options["subcategory_id"])->subcategory;
                $options["subcategory"] = $subcategory;
                $title_category[] = $subcategory;
                unset($options["subcategory_id"]);
            }
            $data["options"] = $options;
            $data["orders"] = $orders;

            if (! empty($title_category)) {
                $category = implode(" ", $title_category);
            } else {
                $category = "All";
            }
            $data["title"] = "List of $category orders for $sale_year";
            if ($this->input->get("export")) {
                $data["export_type"] = "standard";
                $data["filename"] = "order_export.csv";

                if ($export_type = $this->input->get("export_type")) {
                    if ($this->input->get("grower_id")) {
                        $data["filename"] = $this->input->get("grower_id") . "-export.csv";
                    }
                    $data["export_type"] = $export_type;
                }
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
        if ($ajax = $this->input->get("basic_sort")) {
            $data["basic_sort"] = TRUE;
            $this->load->view("order/sort", $data);
        }
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

    function set_catalog_numbers ($year = NULL)
    {
        if (! $year) {
            $year = get_cookie("sale_year");
        }
        $count = 0;
        $categories = $this->category->get_all();
        foreach ($categories as $category) {
            $orders = $this->order->get_for_catalog($year, $category->id);
            $t = 1;
            foreach ($orders as $order) {
                $count ++;

                $letter = ucfirst(substr($order->category, 0, 1));
                switch ($t) {
                    case $t < 10:
                        $cat = $letter . "00" . $t;
                        break;
                    case $t < 100:
                        $cat = $letter . "0" . $t;
                        break;
                    default:
                        $cat = $letter . $t;
                }
                $this->order->update($order->id, array(
                        "catalog_number" => $cat
                ));
                $t ++;
            }
        }
        $this->session->set_flashdata("notice", sprintf("%s orders have had their catalog number updated", $count));
        redirect("index");
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
        ),NULL,TRUE);
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

    function batch_update ()
    {
        if (IS_ADMIN) {
            if ($this->input->post("action") == "edit") {
                $data["ids"] = $this->input->post("ids");
                $pot_sizes = $this->order->get_pot_sizes();
                $data["pot_sizes"] = get_keyed_pairs($pot_sizes,
                        array(
                                "pot_size",
                                "pot_size"
                        ));
                $this->load->view("order/batch_update", $data);
            } elseif ($this->input->post("action") == "update") {
                $target = $this->input->post("target");
                $ids = $this->input->post("ids");
                $fields = array(
                        "crop_failure",
                        "flat_size",
                        "flat_cost",
                        "plant_cost",
                        "count_presale",
                        "count_midsale",
                        "pot_size",
                        "price"
                );
                $values = array();
                foreach ($fields as $field) {
                    if ($this->input->post($field)) {
                        // $values[] = sprintf("`%s` = '%s'",$field,
                        // urldecode($this->input->post($field)));
                        $my_value = urldecode($this->input->post($field));
                        switch ($field) {
                            case "flat_cost":
                            case "plant_cost":
                            case "price":
                                $values[$field] = preg_replace("/[^0-9,.]/", "", $my_value);
                                break;
                            default:
                                $values[$field] = $my_value;
                        }
                    }
                }
                if ($values) {
                    $result = $this->order->batch_update($ids, $values);
                } else {
                    $result = array(
                            "No Changes Made"
                    );
                }
                print_r($result);
                $order_search = get_cookie("order_search");
                redirect("order/search?$order_search");
            }
        }
    }
}