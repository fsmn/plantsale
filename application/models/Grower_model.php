<?php
defined('BASEPATH') or exit('No direct script access allowed');

class grower_model extends MY_Model
{
    var $id;
    var $grower_name;
    var $street_address;
    var $po_box;
    var $city;
    var $state;
    var $zip;
    var $country;
    var $phone;
    var $email;
    var $website;
   // var $contact_id;
   // var $billing_id;
   // var $account;
   // var $payment_method;
   // var $shipping_id;
    var $shipping_notes;
   // var $rec_modifier;
  //  var $rec_modified;

    function __construct ()
    {
        parent::__construct();
    }

    function prepare_variables ()
    {
        $variables = array(
                "id",
                "grower_name",
                "street_address",
                "po_box",
                "city",
                "state",
                "zip",
                "country",
                "phone",
                "email",
                "website",
                "shipping_notes"
        );

        for ($i = 0; $i < count($variables); $i ++) {
            $my_variable = $variables[$i];
            if ($this->input->post($my_variable)) {
                $this->$my_variable = $this->input->post($my_variable);
            }
        }

       // $this->rec_modified = mysql_timestamp();
        //$this->rec_modifier = $this->session->userdata('user_id');
    }

    function insert ()
    {
        $this->prepare_variables();
        return $this->_insert("grower");
    }

    function is_unique($id){
         return $this->db->query("SELECT id FROM grower WHERE id='$id'")->num_rows();

    }

    function update ($id, $values = array())
    {
        return $this->_update("grower", $id, $values);
    }

    function get_value ( $id, $field)
    {
        return $this->_get_value("grower",$id,$field);
    }

    function get_orphans ()
    {
        $this->db->select("order.grower_id");
        $this->db->from("order");
        $this->db->join("grower", "order.grower_id = grower.id", "LEFT");
        $this->db->where("grower.id IS NULL", NULL, FALSE);
        $this->db->where("order.grower_id !=", "");
        $this->db->where("order.year",get_cookie("sale_year"));
        $this->db->group_by("grower_id");
        $result = $this->db->get()->result();
        return $result;

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
        $this->db->from("grower");
        if ($year) {
            $this->db->where("year", $year);
        }
        $this->db->join("order","grower.id = order.grower_id");
        $this->db->select("grower.id");
        $this->db->order_by("grower.id", "ASC");
        $this->db->group_by("grower.id");
        $result = $this->db->get()->result();
       // $this->_log("alert");
        return $result;
    }

    function get_totals ($id, $year)
    {
/*         $query = sprintf(
                "SELECT sum(`o`.`total`) as `total`, `grower`.* FROM (SELECT `grower_id`, (IFNULL(`count_presale`,0) + IFNULL(`count_midsale`,0)) * `flat_cost` as `total` FROM (`order`) WHERE `year` = '%s' AND `order`.`grower_id` = '%s' )  as `o` LEFT JOIN `grower` on `grower`.`id` = `o`.`grower_id` GROUP BY `o`.`grower_id`",
                $year, $id); */

        $query = sprintf( "SELECT sum(`o`.`total`) as `total`, `grower`.*,
                `shipping`.`name` AS `shipping_name`,`shipping`.`phone1` AS `shipping_phone1`, `shipping`.`phone2` AS `shipping_phone2`, `shipping`.`email` AS `shipping_email`,
                `ordering`.`name` AS `ordering_name`,`ordering`.`phone1` AS `ordering_phone1`, `ordering`.`phone2` AS `ordering_phone2`, `ordering`.`email` AS `ordering_email`
                FROM (SELECT `grower_id`, (IFNULL(`count_presale`,0) + IFNULL(`count_midsale`,0)) * `flat_cost` as `total` FROM (`order`)
                WHERE `year` = '%s' AND `order`.`grower_id` = '%s' ) as `o`
                LEFT JOIN `grower` ON `grower`.`id` = `o`.`grower_id`
                LEFT JOIN `contact` AS `shipping` ON `shipping`.`grower_id` = `grower`.`id` AND `shipping`.`contact_type` = 'shipping'
                LEFT JOIN `contact` AS `ordering` ON `ordering`.`grower_id` = `grower`.`id` AND `ordering`.`contact_type` = 'ordering'
                GROUP BY `o`.`grower_id`",$year, $id);
        $result = $this->db->query($query)->row();
        $this->_log("alert");
        return $result;
    }
}