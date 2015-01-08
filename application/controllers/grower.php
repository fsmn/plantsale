<?php
defined('BASEPATH') or exit('No direct script access allowed');

class grower extends MY_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model("grower_model", "grower");
        $this->load->model("contact_model", "contact");
    }

    function totals ($year = NULL)
    {
        if (! $year) {
            $year = get_current_year();
        }
        $ids = $this->grower->get_ids($year);
        foreach ($ids as $id) {
            $data["growers"][] = $this->grower->get_totals($id->grower_id, $year);
        }

        $data["title"] = "Totals Report by Grower for $year";
        $data["target"] = "grower/report/list";
        $this->load->view("page/index", $data);
    }
}