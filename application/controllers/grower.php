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

    function view ($id)
    {
        if ($grower = $this->grower->get($id)) {
            $data["grower"] = $grower;
            $data["target"] = "grower/view";
            $data["title"] = sprintf("Viewing Details for %s", $id);
            $this->load->view("page/index", $data);
        } else {
            show_error(
                    "The grower with ID $id could not be found. Press the back arrow, and notify the database administrator if you believe this error is a mistake.");
        }
    }

    function update_value ()
    {
        $id = $this->input->post ( "id" );
        $value = $this->input->post ( "value" );
        $field = $this->input->post ( "field" );
        if (is_array ( $value ))
        {
            $value = implode ( ",", $value );
        }
        $values = array (
                $field => $value
        );
        $output = $this->grower->update ( $id, $values );
        if ($output == "")
        {
            $output = "&nbsp;";
        }

        echo $output;
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
$data["year"] = $year;
        $data["title"] = "Totals Report by Grower for $year";
        $data["target"] = "grower/report/list";
        $this->load->view("page/index", $data);
    }
}