<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("menu_model", "menu");
	}
	function get_dropdown()
	{
		$category = $this->input->get("category");
		$value = $this->input->get("value");
		$field = $this->input->get("field");
		$categories = $this->menu->get_pairs($category, array("field"=>"value","direction"=>"ASC"));
		$pairs = get_keyed_pairs($categories, array("key","value"));
		echo form_dropdown($field, $pairs, $value, "class='save-field'");
	}

}