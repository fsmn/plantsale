<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct(){
		parent::__construct();
		
		if(!$this->ion_auth->logged_in()){
			define("DB_ROLE",0);
			$uri = $_SERVER["REQUEST_URI"];
			if($uri != "/auth"){
				bake_cookie("uri", $uri);
			}
			redirect("auth/login");
		}else{
			$this->load->model("ion_auth_model");
			define("DB_ROLE",$this->ion_auth_model->get_users_groups ()->row ()->id);
		}
	}

}