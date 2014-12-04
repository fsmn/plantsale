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

    function set_option (&$options, $key)
    {
        if ($value = urldecode($this->input->get($key))) {
            bake_cookie($key, $value);
            $options[$key] = $value;
        } else {
            burn_cookie($key);
        }
    }

    function set_options (&$options, $keys = array())
    {
        foreach ($keys as $key) {
         $this->set_option($options, $key);
        }
    }
}