<?php defined('BASEPATH') OR exit('No direct script access allowed');

class grower extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("grower_model","grower");
		$this->load->model("contact_model","contact");
		
	}
	
	
}