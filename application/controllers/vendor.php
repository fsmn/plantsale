<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("vendor_model","vendor");
		$this->load->model("contact_model","contact");
		
	}
	
	
}