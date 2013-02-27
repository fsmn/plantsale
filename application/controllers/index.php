<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data["title"] = "Plant Sale Database";
		$data["target"] = "welcome";
		$this->load->view("page/index", $data);
	}


}