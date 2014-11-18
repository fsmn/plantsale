<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct ()
    {
        parent::__construct();

        if (! $this->ion_auth->logged_in()) {
            define("IS_EDITOR", 0);
            define("IS_ADMIN", 0);
            $uri = $_SERVER["REQUEST_URI"];
            if ($uri != "/auth") {
                bake_cookie("uri", $uri);
            }
            redirect("auth/login");
        } else {
            $this->load->model("ion_auth_model");
            define("IS_EDITOR", $this->ion_auth->in_group(array(
                    1,
                    2
            )));
            define("IS_ADMIN", $this->ion_auth->in_group(array(
                    1
            )));
        }
    }
}