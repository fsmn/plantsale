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

	function get_checkbox()
	{
		$category = $this->input->get("category");
		$value = $this->input->get("value");
		$field = $this->input->get("field");
		$categories = $this->menu->get_pairs($category, array("field"=>"value","direction"=>"ASC"));
		$pairs = get_keyed_pairs($categories, array("key","value"));
		$output = array();
		for($i = 0; $i < count($categories); $i++){
			$checked = "";
			if($categories[$i]->value == $value){
				$checked = "checked";
			}
			$output[] = sprintf("<label for='%s'>%s</label><input type='checkbox' name='%s[]' value='%s' %s/>", $categories[$i]->value,$categories[$i]->key,$field,  $categories[$i]->value, $checked);
		}
		$buttons =  implode(" ", $output);
		echo $buttons . sprintf("<span class='button save-checkbox' target='%s[]'>Save</span>", $field);
	}

}