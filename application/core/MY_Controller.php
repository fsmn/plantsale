<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if(!is_logged_in($this->session->all_userdata())){
			//determine the query to redirect after login. 
			$uri = $_SERVER["REQUEST_URI"];
			if($uri != "/auth"){
				bake_cookie("uri", $uri);
			}
			redirect("auth");
			die();
		}else{
			define("DB_ROLE",$this->session->userdata("db_role"));
		}
	}

	function index()
	{
		redirect();
	}

}