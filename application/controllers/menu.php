<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model("menu_model", "menu");
        $this->load->model("category_model", "category");
        $this->load->model("subcategory_model", "subcategory");
    }

    function edit_value ()
    {
        $data["name"] = $this->input->get("field");

        $value = $this->input->get("value");
        if ($value != "&nbsp;") {
            $data["value"] = $value;
        } else {
            $data['value'] = "";
        }
        if (is_array($value)) {
            $data["value"] = implode(",", $value);
        }
        $data["id"] = $this->input->get("id");
        $data["size"] = strlen($data["value"]) + 5;
        $data["type"] = $this->input->get("type");
        $data["category"] = $this->input->get("category");

        switch ($data["type"]) {
            case "dropdown":
                $output = $this->_get_dropdown($data["category"], $data["value"], $data["name"]);
                break;
            case "category-dropdown":
            	$this->load->model("common_model","common");
            	$common = $this->common->get($data["id"]);
            	$output = $this->_get_dropdown($data["category"],$common->category_id,$data["name"]);
            	break;
            case "subcategory-dropdown":
            	$this->load->model("common_model","common");
            	$common =  $this->common->get($data["id"]);
            	$output = $this->_get_dropdown($data["category"],$common->subcategory_id,$data["name"],$common->category_id);
            	break;
            case "multiselect":
                $output = $this->_get_multiselect($data["category"], $data["value"], $data["name"]);
                break;
            case "textarea":
                $output = form_textarea($data, $data["value"]);
                break;
            case "autocomplete":
                $data["type"] = "text";
                $output = form_input($data, $data["value"], "class='autocomplete'");
                break;
            case "time":
                $output = sprintf("<input type'%s' name='%s' id='%s' value='%s' size='%s'", $data['type'], $data['name'], $data['id'], $data['value'],
                        $data['size']);
                break;
                case "email":
                    $output = sprintf("<input type'%s' name='%s' id='%s' value='%s' size='%s'", $data['type'], $data['name'], $data['id'], $data['value'],
                    $data['size']);
                    break;
            default:
                $output = form_input($data);
        }

        echo $output;
    }

    /**
     * AJAX function to create quick-edit dropdown <select> fields (for use with
     * the field editing AJAX functions in general.js
     */
    function get_dropdown ()
    {
        $category = $this->input->get("category");
        $value = $this->input->get("value");
        $field = $this->input->get("field");

        echo $this->_get_dropdown($category, $value, $field, $this->input->get("parent"));
        die();
        switch ($category) {
            case "category":
                $categories = $this->category->get_pairs();
                break;
            case "subcategory":
                if($category_id = $this->input->get("parent")){
                    $categories = $this->subcategory->get_pairs($category_id);
                }else{
                    $categories = $this->subcategory->get_pairs();
                }
                //array_unshift($categories,(object)array("key"=>0,"value"=>""));

                break;
            default:

                $categories = $this->menu->get_pairs($category, array(
                        "field" => "value",
                        "direction" => "ASC"
                ));
        }

        $pairs = get_keyed_pairs($categories, array(
                "key",
                "value"
        ),TRUE);
        echo form_dropdown($field, $pairs, $value, "class='save-field'");
    }

    /**
     * AJAX function to create a quick-edit multiselect <select
     * multiple="multiple"> fields
     * (for use with the field editing AJAX functions in general.js
     */
    function get_multiselect ()
    {
        $category = $this->input->get("category");
        $value = explode(",", $this->input->get("value"));
        $field = $this->input->get("field");
        $categories = $this->menu->get_pairs($category, array(
                "field" => "value",
                "direction" => "ASC"
        ));
        $pairs = get_keyed_pairs($categories, array(
                "key",
                "value"
        ));
        $output = array();
        $output[] = form_multiselect($field, $pairs, $value, "id='$field'");
        $buttons = implode(" ", $output);
        echo $buttons . sprintf("<span class='button save-multiselect' target='%s'>Save</span>", $field);
    }

    /**
     * This function is not currently used because parsing check boxes in AJAX
     * is a pain in the ass.
     */
    function get_checkbox ()
    {
        $category = $this->input->get("category");
        $value = $this->input->get("value");
        $field = $this->input->get("field");
        $categories = $this->menu->get_pairs($category, array(
                "field" => "value",
                "direction" => "ASC"
        ));
        $pairs = get_keyed_pairs($categories, array(
                "key",
                "value"
        ));

        $output = array();
        for ($i = 0; $i < count($categories); $i ++) {
            $checked = "";
            $item = $categories[$i];
            if ($item->value == $value) {
                $checked = "checked";
            }

            $output[] = sprintf("<label for='%s'>%s</label><input type='checkbox' name='%s[$i]' id='%s' value='%s' %s/>", $item->value, $item->value, $field,
                    $field, $item->value, $checked);
        }
        $buttons = implode(" ", $output);
        echo $buttons . sprintf("<span class='button save-checkbox' target='%s'>Save</span>", $field);
    }

    function get_autocomplete ()
    {
        $category = $this->input->get("category");
        $value = $this->input->get("value");
        $id = $this->input->get("id");
        $is_live = FALSE;
        if ($this->input->get("is_live")) {
            $is_live = $this->input->get("is_live");
        }
    switch ($category) {
            case "category":
                $categories = $this->category->get_pairs();
                break;
            case "subcategory":
                $category_id = $this->category->get_id($this->input->get("parent"));
                $categories = $this->subcategory->get_pairs($category_id);
                break;
            default:

                $categories = $this->menu->get_pairs($category, array(
                        "field" => "value",
                        "direction" => "ASC"
                ));
        }

        // $this->session->set_flashdata("notice",$this->db->last_query());
        // echo create_autocomplete($categories, $value, $id, $is_live);
        echo create_list($categories);
        // echo form_dropdown ( $field, $pairs, $value, "class='save-field'" );
    }

    function _get_dropdown ($category, $value, $field,$parent_id = FALSE)
    {
    	switch ($category) {
    		case "category":
    			$categories = $this->category->get_pairs();
    			break;
    		case "subcategory":
    			if($parent_id){
    				$categories = $this->subcategory->get_pairs($parent_id);
    			}else{
    				$categories = $this->subcategory->get_pairs();
    			}

    			break;
    		default:

    			$categories = $this->menu->get_pairs($category, array(
    			"field" => "value",
    			"direction" => "ASC"
    					));
    	}

        $pairs = get_keyed_pairs($categories, array(
                "key",
                "value"
        ),TRUE);
        return form_dropdown($field, $pairs, $value, "class='live-field'");
    }

    function _get_multiselect ($category, $value, $field)
    {
        $this->load->model("menu_model", "menu");
        $categories = $this->menu->get_pairs($category, array(
                "field" => "value",
                "direction" => "ASC"
        ));
        $pairs = get_keyed_pairs($categories, array(
                "key",
                "value"
        ));
        $output = array();
        $output[] = form_multiselect($field, $pairs, explode(",", $value), "id='$field'");
        $buttons = implode(" ", $output);
        echo $buttons . sprintf("<span class='button save-multiselect' target='%s'>Save</span>", $field);
    }
}