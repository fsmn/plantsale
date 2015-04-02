<?php
defined('BASEPATH') or exit('No direct script access allowed');

// contact.php Chris Dart Mar 5, 2015 2:45:19 PM chrisdart@cerebratorium.com
class Contact extends MY_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model("contact_model", "contact");
    }

    function edit ($id)
    {
        $data["contact"] = $this->contact->get($id);
        $data["target"] = "contact/edit";
        $data["title"] = "Editing a Contact";
        $data["action"] = "update";
        if ($this->input->get("ajax") == 1) {
            $page = $data["target"];
        } else {
            $page = "page/index";
        }
        $this->load->view($page, $data);
    }

    function update ()
    {
        if ($id = $this->input->post("id")) {
            $this->contact->update($id);
            $contact = $this->contact->get($id);
            redirect("grower/view/$contact->grower_id");
        }
    }

    function create ($grower_id)
    {
        $data["grower_id"] = $grower_id;
        $data["contact"] = NULL;
        $data["target"] = "contact/edit";
        $data["title"] = "Creating a Contact";
        $data["action"] = "insert";
        if ($this->input->get("ajax") == 1) {
            $page = $data["target"];
        } else {
            $page = "page/index";
        }
        $this->load->view($page, $data);
    }

    function insert ()
    {
        if ($grower_id = $this->input->post("grower_id")) {
            $this->contact->insert();
            redirect("grower/view/$grower_id");
        }
    }

    function delete ()
    {
        if (IS_ADMIN) {
            if ($id = $this->input->post("id")) {
                $contact = $this->contact->get($id);

                $this->contact->delete($id);
                redirect("grower/view/$contact->grower_id");
            }
        }
    }
}