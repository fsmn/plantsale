<?php
defined('BASEPATH') or exit('No direct script access allowed');

class grower_model extends MY_Model
{
    var $id;
    var $name;
    var $street;
    var $unit_type;
    var $unit;
    var $city;
    var $state;
    var $zip;
    var $country;
    var $phone;
    var $email;
    var $website;
    var $contact_id;
    var $billing_id;
    var $account;
    var $payment_method;
    var $shipping_id;
    var $shipping_notes;
    var $rec_modifier;
    var $rec_modified;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ()
    {
        $variables = array(
                "id",
                "name",
                "street",
                "unit_type",
                "unit",
                "city",
                "state",
                "zip",
                "country",
                "phone",
                "email",
                "website",
                "contact_id",
                "billing_id",
                "account",
                "payment_method",
                "shipping_id",
                "shipping_notes"
        );

        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->post($my_variable)) {
                $this->$my_variable = $this->input->post($my_variable);
            }
        }

        $this->rec_modified = mysql_timestamp();
        $this->rec_modifier = $this->session->userdata('user_id');
    }

    function insert ()
    {
        $this->prepare_variables();
        return $this->_insert("grower");
    }

    function update ($id, $values = array())
    {
        return $this->_update("grower", $id, $values);
    }

    function get_value ( $id, $field)
    {
        return $this->_get_value("grower",$id,$field);
    }


    function get ($id, $values = NULL)
    {
        $this->db->from("grower");
        $this->db->where("id", $id);
        $result = $this->db->get()->row();
        return $result;
    }

    function delete ($id)
    {
        return $this->_delete("grower", $id);
    }

    function get_ids ($year = NULL)
    {
        $this->db->from("order");
        if ($year) {
            $this->db->where("year", $year);
        }
        $this->db->select("grower_id");
        $this->db->order_by("grower_id", "ASC");
        $this->db->group_by("grower_id");
        $result = $this->db->get()->result();
        return $result;
    }

    function get_totals ($id, $year)
    {
        $query = sprintf(
                "SELECT sum(`o`.`total`) as `total`, `grower`.* FROM (SELECT `grower_id`, (`count_presale` + `count_midsale`) * `flat_cost` as `total` FROM (`order`) WHERE `year` = '%s' AND `order`.`grower_id` = '%s' )  as `o` JOIN `grower` on `grower`.`id` = `o`.`grower_id` GROUP BY `o`.`grower_id`",
                $year, $id);
        $result = $this->db->query($query)->result();
       // $this->_log("notice");
        return $result;
    }
}