<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Variety_Model extends MY_Model
{
    var $common_id;
    var $species;
    var $variety;
    var $min_height;
    var $max_height;
    var $min_width;
    var $max_width;
    var $height_unit;
    var $width_unit;
    var $plant_color;
    var $note;
    var $new_year;
    var $rec_modifier;
    var $rec_modified;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ()
    {
        $variables = array(
                "species",
                "variety",
                "min_height",
                "max_height",
                "min_width",
                "max_width",
                "height_unit",
                "width_unit",
                "note",
                "new_year",
                "common_id"
        );

        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->post($my_variable)) {
                $this->$my_variable = urldecode($this->input->post($my_variable));
            }
        }

        if ($this->input->post("plant_color")) {
            $this->plant_color = implode(",", $this->input->post("plant_color"));
        }

        $this->rec_modified = mysql_timestamp();
        $this->rec_modifier = $this->session->userdata('user_id');
    }

    function insert ()
    {
        $this->prepare_variables();
        return $this->_insert("variety");
    }

    function update ($id, $values = array())
    {
        return $this->_update("variety", $id, $values);
    }

    function get ($id)
    {
        $this->db->where("variety.id", $id);
        $this->db->from("variety");
        $this->db->join("common", "variety.common_id = common.id");
        $this->db->join("category", "common.category_id = category.id", "LEFT");
        $this->db->join("subcategory", "common.subcategory_id = subcategory.id", "LEFT");
        $this->db->join("image", "variety.id=image.variety_id", "LEFT");
        $this->db->select(
                "variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,subcategory.subcategory,  category.category, common.description, common.sunlight, common.extended_description, common.other_names");
        $this->db->select("image.id as image_id, image_name");
        $result = $this->db->get()->row();
        return $result;
    }

    function get_by_common ($common_id)
    {
        $query = "SELECT v.*, o.year
            FROM `variety` v
                LEFT JOIN
                    (SELECT n.variety_id, MAX(n.year) AS max_year  FROM `order` n GROUP BY n.variety_id) y
                        ON y.variety_id = v.id
                 LEFT JOIN `order` o ON `o`.`variety_id` = `v`.`id` AND `o`.`year`=`y`.`max_year`
                 WHERE `v`.`common_id` = $common_id ORDER BY `v`.`variety` ASC";
        $result = $this->db->query($query)->result();
        return $result;
    }

    function get_by_name ($name)
    {
        $this->db->where("`variety` LIKE '%$name%' OR `common`.`name` LIKE '%$name%' OR `variety`.`species` LIKE '%$name%' OR `common`.`genus` LIKE '%$name%'");
        $this->db->join("common", "variety.common_id=common.id");
        $this->db->join("category", "common.category_id = category.id", "LEFT");
        $this->db->join("subcategory", "common.subcategory_id = subcategory.id", "LEFT");
        $this->db->order_by("variety", "ASC");
        $this->db->order_by("common.name", "ASC");
        $this->db->select(
                "variety.*, variety.id as id, variety.common_id as common_id, common.name as common_name, common.genus,  category.category, subcategory.subcategory, common.description");

        $result = $this->db->get("variety")->result();
        return $result;
    }

    function get_value ($id, $field)
    {
        $this->db->where("id", $id);
        $this->db->select($field);
        $this->db->from("variety");
        $output = $this->db->get()->row();
        return $output->$field;
    }

    function get_new_varieties ($year)
    {
        $this->db->where("new_year", $year);
        $this->db->from("variety");
        $this->db->select("new_year");
        $result = $this->db->get()->num_rows();
        return $result;
    }

    function is_new ($id, $year = NULL)
    {
        if (! $year) {
            $year = get_cookie("sale_year");
        }
        $query = sprintf(
                "select * from `order`,variety where `order`.`variety_id` = %s and variety.id = `order`.variety_id  and  not exists(select `year` from `order` where `year` < %s and variety_id = %s)  having `order`.`year` = %s",
                $id, $year, $id, $year);
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function update_all ($year)
    {
        if (IS_EDITOR) {
            $output = array();
            $this->db->select("id");
            $this->db->from("variety");
            // $this->db->where("new_year IS NULL", NULL, false);
            $varieties = $this->db->get()->result();
            $flashes = array();
            foreach ($varieties as $variety) {
                $query = sprintf(
                        "SELECT `order`.`year` FROM `order`,`variety` WHERE `order`.`variety_id` = %s AND variety.id = `order`.variety_id  AND NOT EXISTS(SELECT `year` FROM `order` WHERE `year` < %s AND variety_id = %s)  HAVING `order`.`year` = %s;",
                        $variety->id, $year, $variety->id, $year);
                $new_year = $this->db->query($query)->row();
                if ($new_year) {
                    $this->update_status($variety->id, $year);
                    $output[] = $this->get($variety->id);
                }
            }
        }
        return $output;
    }

    function update_status ($id, $year)
    {
        $this->db->where("id", $id);
        $update = array(
                "new_year" => $year
        );
        $this->db->update("variety", $update);
    }

    function get_varieties_for_year ($year)
    {
        $this->db->from("variety");
        $this->db->join("order", "variety.id=order.variety_id");
        $this->db->where("order.year", $year);
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     *
     * @param int(4) $year get the varieties that are renewals from a previous
     *        year.
     */
    function get_reorders ($year)
    {
        $this->db->from("variety as v");
        $this->db->from("order as o");
        $this->db->join("common as c", "v.common_id = c.id");
        $this->db->join("category", "c.category_id = category.id", "LEFT");
        $this->db->join("subcategory", "c.subcategory_id = subcategory.id", "LEFT");
        $this->db->select("v.*");
        $this->db->select("o.year,o.id as order_id");
        $this->db->select("c.name,c.sunlight,c.genus");
        $this->db->where("o.variety_id = v.id", NULL, FALSE);
        $this->db->where("o.year", $year);
        $this->db->where("v.new_year !=", $year);
        $this->db->order_by("category.category,c.name,c.genus,v.variety");
        $result = $this->db->get()->result();
        return $result;
    }

    function get_category_totals ($year)
    {
        $this->db->from("variety");
        $this->db->join("order", "variety.id=order.variety_id");
        $this->db->join("common", "common.id=variety.common_id");
        $this->db->join("category", "common.category_id = category.id", "LEFT");
        $this->db->join("subcategory", "common.subcategory_id = subcategory.id", "LEFT");
        $this->db->where("order.year", $year);
        $this->db->not_like("order.pot_size", "bare");
        $this->db->group_by("common.category_id");
        $this->db->order_by("category.category");
        $this->db->select("count(`variety`.`id`) as count,category.category,category.id");
        $result = $this->db->get()->result();
       // $this->_log("notice");
        return $result;
    }

    function get_flat_totals ($year)
    {
        $this->db->from("variety");
        $this->db->join("order", "variety.id=order.variety_id");
        $this->db->join("common", "common.id=variety.common_id");
        $this->db->join("category", "common.category_id = category.id", "LEFT");
        $this->db->where("order.year", $year);
        $this->db->where("NOT (`order`.`pot_size` LIKE '%bareroot%' AND `category`.`category` = 'perennials')", NULL, FALSE);
        $this->db->group_by("common.category_id");
        $this->db->order_by("category.category");
        // $this->db->select("sum(`order`.`count_presale` +
        // `order`.`count_midsale`) as count");
        $this->db->select("sum(`order`.`count_presale`) as presale_count");
        $this->db->select("sum(`order`.`count_midsale`) as midsale_count");
        $this->db->select("category.category,category.id as category_id");
        $result = $this->db->get()->result();
        //$this->_log("notice");
        return $result;
    }

    function find ($variables, $order_by)
    {
        $my_parameters = (object) array();
        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->get($my_variable) && $this->input->get($my_variable) != "") {
                $my_value = $this->input->get($my_variable);
                if ($my_value) {
                    $my_parameters->$my_variable = new stdClass();

                    $my_parameters->$my_variable->key = $my_variable;
                    $my_parameters->$my_variable->value = $my_value;
                }
            }
        }
        if (! is_array($order_by)) {
            $order_by = array(
                    $order_by
            );
        }
        for ($i = 0; $i < count($order_by["fields"]); $i ++) {
            $order_field = "catalog_number";
            if (array_key_exists("fields", $order_by) && ! empty($order_by["fields"][$i])) {
                $order_field = $order_by["fields"][$i];
            }

            $order_direction = "ASC";
            if (array_key_exists("direction", $order_by) && ! empty($order_by["direction"][$i])) {
                $order_direction = $order_by["direction"][$i];
            }
            $this->db->order_by($order_field, $order_direction);
        }
        $this->db->from("variety");
        $this->db->join("common", "variety.common_id = common.id");
        $this->db->join("category", "common.category_id = category.id", "LEFT");
        $this->db->join("subcategory", "common.subcategory_id = subcategory.id", "LEFT");
        $this->db->join("flag", "variety.id = flag.variety_id", "LEFT");
        $this->db->join("order", "variety.id = order.variety_id", "RIGHT");
        if ($this->input->get("no_image")) {
            $this->db->join("image", "variety.id = image.variety_id", "LEFT");
            $this->db->where("image.id IS NULL", NULL, FALSE);
        }
        foreach ($my_parameters as $parameter) {
            if ($parameter->key == "sunlight") {
                if ($this->input->get("sunlight-boolean") == "or") {
                    $my_list = $parameter->value;
                    foreach ($parameter->value as $my_item) {
                        $this->db->or_like("sunlight", "$my_item");
                    }
                } elseif ($this->input->get("sunlight-boolean") == "only") {
                    $this->db->where("sunlight", implode(",", $parameter->value));
                } else {
                    $this->db->like("sunlight", implode(",", $parameter->value));
                }
            } elseif ($parameter->key == "name") {
                $this->db->like("common.name", $parameter->value);
            } elseif ($parameter->key == "flag") {
                if ($this->input->get("not_flag") == 1) {
                    $this->db->where(
                            sprintf("NOT EXISTS(SELECT 1 from flag where `flag`.`name` ='%s' AND `variety`.`id` = `flag`.`variety_id`)",
                                    urldecode($parameter->value)), NULL, FALSE);
                } else {
                    $this->db->where("flag.name", urldecode($parameter->value));
                }
            } elseif ($parameter->key == "year") {
                $this->db->where("order.year", $parameter->value);
            } elseif (in_array($parameter->key,
                    array(
                            "variety",
                            "genus",
                            "species",
                            "description"
                    ))) {
                $this->db->like($parameter->key, $parameter->value);
            } elseif ($parameter->key == "print_omit") {
                $this->db->where("(order.print_omit is NULL OR order.print_omit != 1)", NULL, FALSE);
            } elseif ($parameter->key == "not_flag") {
                // no action taken
            } elseif ($parameter->key == "category_id") {
                $this->db->where("common.category_id", $parameter->value);
            } else {
                $this->db->where($parameter->key, $parameter->value);
            }
        }
        // select common fields
        $this->db->select("common.name,common.genus, common.sunlight, category.category, subcategory.subcategory");
        // include all variety fields (maybe change this).
        $this->db->select("variety.*");

        // select order fields
        $this->db->select("order.id as order_id,year,flat_size,flat_cost,plant_cost,pot_size,price,count_presale,count_midsale,count_dead,print_omit");
        $this->db->select("sellout_friday,sellout_saturday,remainder_friday,remainder_saturday,remainder_sunday,grower_code,grower_id,catalog_number");
        $this->db->group_by("variety.id");
        $result = $this->db->get()->result();
        return $result;
    }



    function delete ($id)
    {
        if ($this->ion_auth->in_group(array(
                1,
                2
        ))) {

            $this->db->delete("variety", array(
                    'id' => $id
            ));
            $this->db->delete("order", array(
                    'variety_id' => $id
            ));
            $this->db->delete("flag", array(
                    'variety_id' => $id
            ));
        } else {
            return FALSE;
        }
    }
}