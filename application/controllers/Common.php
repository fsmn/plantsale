<?php
defined ( "BASEPATH" ) or exit ( "No direct script access allowed" );

// common.php Chris Dart Feb 17, 2013 6:21:00 PM chrisdart@cerebratorium.com
class Common extends MY_Controller
	{

		function __construct ()
		{
			parent::__construct ();
			$this->load->model ( "common_model", "common" );
			$this->load->model ( "variety_model", "variety" );
			$this->load->model ( "menu_model", "menu" );
			$this->load->model ( "category_model", "category" );
			$this->load->model ( "subcategory_model", "subcategory" );
			if (IS_INVENTORY) {
				redirect ( "inventory" );
			}
		}

		function index ()
		{
		}

		function search ()
		{
			if ($this->input->get ( "find" )) {
				$data ["names"] = $this->common->find ();
				$data ["title"] = "List of Common Names";
				$data ["target"] = "common/list";
				$data ["full_list"] = TRUE;
				
				// create the legend for the paramter display
				$variables = array (
						"name",
						"genus",
						"category_id",
						"subcategory_id",
						"sunlight",
						"description",
						"year" 
				);
				$params = array ();
				for($i = 0; $i < count ( $variables ); $i ++) {
					$my_variable = $variables [$i];
					if ($my_value = $this->input->get ( $my_variable )) {
						$params [$my_variable] = $my_value;
						bake_cookie ( $my_variable, $my_value );
					}
					else {
						burn_cookie ( $my_variable );
					}
				}
				if (array_key_exists ( "category_id", $params )) {
					$this->load->model ( "category_model", "category" );
					$category = $this->category->get ( $params ["category_id"] )->category;
					$params ["category"] = $category;
					$title_category [] = $category;
					unset ( $params ["category_id"] );
				}
				if (array_key_exists ( "subcategory_id", $params )) {
					$this->load->model ( "subcategory_model", "subcategory" );
					$subcategory = $this->subcategory->get ( $params ["subcategory_id"] )->subcategory;
					$params ["subcategory"] = $subcategory;
					$title_category [] = $subcategory;
					unset ( $params ["subcategory_id"] );
				}
				$data ["params"] = $params;
				
				$this->load->view ( "page/index", $data );
			}
			else {
				$this->_search ();
			}
		}

		function _search ()
		{
			$categories = $this->category->get_pairs ();
			$data ["categories"] = get_keyed_pairs ( $categories, array (
					"key",
					"value" 
			), TRUE );
			$subcategories = $this->subcategory->get_pairs ();
			$data ["subcategories"] = get_keyed_pairs ( $subcategories, array (
					"key",
					"value" 
			), TRUE );
			$sunlight = $this->menu->get_pairs ( "sunlight", array (
					"field" => "value" 
			) );
			$data ["sunlight"] = $sunlight;
			$data ["common"] = NULL;
			$data["title"] = "Common Search Results";
			$data ["target"] = "common/search";
			if ($this->input->get ( "ajax" )) {
				$this->load->view ( "common/search", $data );
			}
			else {
				$this->load->view ( "page/index", $data );
			}
		}

		function search_by_name ()
		{
			$name = $this->input->get ( "name" );
			$data ["names"] = $this->common->get_by_name ( $name );
			$data ["full_list"] = FALSE;
			if ($this->input->get ( "type" ) == "inline") {
				$target = "common/inline_list";
			}
			else {
				$target = "common/list";
			}
			$this->load->view ( $target, $data );
		}

		function view ()
		{
			$id = $this->uri->segment ( 3 );
			$common = $this->common->get ( $id );
			if ($common) {
				$data ["varieties"] = $this->variety->get_for_common ( $id );
				$data ["common"] = $common;
				$data ["title"] = sprintf ( "Viewing Common Name: %s", $common->name );
				$data ["target"] = "common/view";
				$this->load->view ( "page/index", $data );
			}
			else {
				$data ["target"] = "error";
				$data ["title"] = "Missing Common Record";
				$data ["message"] = "The common record for id $id could not be found.";
				$this->load->view ( "page/index", $data );
			}
		}

		function get_name ( $id )
		{
			$name = $this->common->get_value ( $id, "name" );
			echo $name;
		}

		function create ()
		{
			$categories = $this->category->get_pairs ();
			
			$data ["categories"] = get_keyed_pairs ( $categories, array (
					"key",
					"value" 
			), TRUE );
			$subcategories = $this->subcategory->get_pairs ();
			$data ["subcategories"] = get_keyed_pairs ( $subcategories, array (
					"key",
					"value" 
			), TRUE );
			$sunlight = $this->menu->get_pairs ( "sunlight", array (
					"field" => "value" 
			) );
			$data ["sunlight"] = $sunlight;
			$data ["action"] = "insert";
			$data ["target"] = "common/edit";
			$data ["common"] = NULL;
			$data ["title"] = "Insert a New Common Name";
			$this->load->view ( $data ["target"], $data );
		}

		function insert ()
		{
			$id = $this->common->insert ();
			redirect ( "common/view/$id" );
		}

		function edit ()
		{
			$id = $this->uri->segment ( 3 );
			$categories = $this->category->get_pairs ();
			$data ["categories"] = get_keyed_pairs ( $categories, array (
					"key",
					"value" 
			), TRUE );
			$subcategories = $this->subcategory->get_pairs ();
			$data ["subcategories"] = get_keyed_pairs ( $subcategories, array (
					"key",
					"value" 
			), TRUE );
			$sunlight = $this->menu->get_pairs ( "sunlight", array (
					"field" => "value" 
			) );
			$data ["sunlight"] = $sunlight;
			$data ["action"] = "update";
			$data ["target"] = "common/edit";
			$data ["common"] = $this->common->get ( $id );
			$data ["title"] = "Edit Common Name";
			if ($this->input->get ( "ajax" )) {
				$this->load->view ( $data ["target"], $data );
			}
			else {
				$this->load->view ( "page/index", $data );
			}
		}

		function update ()
		{
			$id = $this->input->post ( "id" );
			$this->common->update ( $id );
			redirect ( "common/view/$id" );
		}

		function update_value ()
		{
			$id = $this->input->post ( "id" );
			$value = $this->input->post ( "value" );
			$field = $this->input->post ( "field" );
			if (is_array ( $value )) {
				$value = implode ( ",", $value );
			}
			$values = array (
					$field => $value 
			);
			$output = $this->common->update ( $id, $values );
			if ($output == "") {
				$output = "&nbsp;";
			}
			/*
			 * special tasks for categories: need to return the category name
			 * instead of the value for improved UX
			 */
			if ($category = $this->input->post ( "category" )) {
				switch ($field) {
					case "category_id" :
						$this->load->model ( "category_model", "category" );
						$output = $this->category->get ( $value )->category;
						break;
					case "subcategory_id" :
						$this->load->model ( "subcategory_model", "subcategory" );
						if ($sub = $this->subcategory->get ( $value )) {
							$output = $sub->subcategory;
						}
						break;
				}
			}
			echo $output;
		}

		function delete ()
		{
			if ($id = $this->input->post ( "id" )) {
				if ($this->variety->get_for_common ( $id ) == FALSE) {
					$this->common->delete ( $id );
					redirect ( "index" );
				}
			}
		}
	}