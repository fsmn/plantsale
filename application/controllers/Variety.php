<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Variety extends MY_Controller
	{

		function __construct ()
		{
			parent::__construct ();
			if (IS_INVENTORY) {
				redirect ( "inventory" );
			}
			$this->load->model ( "variety_model", "variety" );
			$this->load->model ( "common_model", "common" );
			$this->load->model ( "order_model", "order" );
			$this->load->model ( "flag_model", "flag" );
			$this->load->library ( "field" );
		}

		function index ()
		{
			$this->variety->update_needs_bag ();
		}

		function create ()
		{
			$this->load->model ( "menu_model", "menu" );
			$data ["target"] = "variety/edit";
			$data ["variety"] = "";
			$data ["common_id"] = $this->input->get ( "common_id" );
			$measure_units = $this->menu->get_pairs ( "measure_unit" );
			$data ["measure_units"] = get_keyed_pairs ( $measure_units, array (
					"key",
					"value" 
			), TRUE );
			$plant_colors = $this->menu->get_pairs ( "plant_color", array (
					"field" => "value",
					"direction" => "ASC" 
			) );
			$data ["plant_colors"] = get_keyed_pairs ( $plant_colors, array (
					"key",
					"value" 
			) );
			$data ["action"] = "insert";
			$data ["title"] = "Add a new variety";
			$this->load->view ( $data ["target"], $data );
		}

		function insert ()
		{
			$id = $this->variety->insert ();
			if ($this->input->post ( "add_order" )) {
				$data ["variety_id"] = $id;
				$data ["order"] = $this->order->get_previous_year ( $data ["variety_id"], get_current_year () );
				$pot_sizes = $this->order->get_pot_sizes ();
				$data ["pot_sizes"] = get_keyed_pairs ( $pot_sizes, array (
						"pot_size",
						"pot_size" 
				) );
				$data ["action"] = "insert";
				$this->load->view ( "order/edit", $data );
			}
			else {
				redirect ( "variety/view/$id" );
			}
		}

		function view ()
		{
			// $this->output->enable_profiler(TRUE);
			$id = $this->uri->segment ( 3 );
			$formats = array (
					"statement",
					"tabloid",
					"letter",
					"shovel_foot",
					"thumbnail" 
			);
			// foreach ($formats as $format) {
			$this->resize_image ( $id, "statement", TRUE );
			// }
			
			$variety = $this->variety->get ( $id );
			$current_order = $this->order->get_for_variety ( $id, get_current_year () );
			$data ["current_order"] = $current_order;
			$data ["orders"] = $this->order->get_for_variety ( $id );
			$data ["flags"] = $this->flag->get_for_variety ( $id );
			$data ["is_new"] = $variety->new_year == get_current_year ();
			$data ["variety"] = $variety;
			$data ["target"] = "variety/view";
			$data ["title"] = sprintf ( "Viewing Info for %s (variety)", $variety->variety );
			$data ["variety_id"] = $id;
			if ($data ["mini_view"] = $this->input->get ( "ajax" ) == 1) {
				$this->load->view ( "variety/mini_view", $data );
			}
			else {
				$data ["mini_view"] = FALSE;
				$this->load->view ( "page/index", $data );
			}
		}

		function search ()
		{
			if ($this->input->get ( "find" )) {
				$action = implode ( "", $this->input->get ( "action" ) );
				$variables = array (
						"name",
						"variety",
						"genus",
						"species",
						"category_id",
						"subcategory_id",
						"flag",
						"plant_color",
						"sunlight",
						"description",
						"year",
						"grower_id",
						"new_year",
						"omit",
						"web_description",
						"print_description",
						"needs_bag",
						"crop_failure",
						"catalog_number" 
				);
				$options = array ();
				for($i = 0; $i < count ( $variables ); $i ++) {
					$my_variable = $variables [$i];
					if ($my_value = $this->input->get ( $my_variable )) {
						switch ($my_variable) {
							case "category_id" :
								$this->load->model ( "category_model", "category" );
								$options ["category"] = $this->category->get ( $my_value )->category;
								break;
							case "subcategory_id" :
								$this->load->model ( "subcategory_model", "subcategory" );
								$options ["subcategory"] = $this->subcategory->get ( $my_value )->subcategory;
								break;
							case "sunlight" :
								bake_cookie ( $my_variable, implode ( ",", $my_value ) );
								$options [$my_variable] = implode ( ",", $my_value );
								break;
							
							default :
								$options [$my_variable] = $my_value;
						}
						bake_cookie ( $my_variable, $my_value );
					}
					else {
						burn_cookie ( $my_variable );
					}
				}
				
				if ($not_flag = $this->input->get ( "not_flag" )) {
					bake_cookie ( "not_flag", $not_flag );
				}
				else {
					burn_cookie ( "not_flag" );
				}
				
				if ($sunlight_boolean = $this->input->get ( "sunlight-boolean" )) {
					if (array_key_exists ( "sunlight", $options )) {
						$options ["sunlight_boolean"] = $sunlight_boolean;
					}
					bake_cookie ( "sunlight-boolean", $sunlight_boolean );
				}
				else {
					burn_cookie ( "sunlight-boolean" );
				}
				$sorting ["fields"] = array (
						"catalog_number" 
				);
				$sorting ["direction"] = array (
						"ASC" 
				);
				
				if ($this->input->get ( "sorting" )) {
					$sorting ["fields"] = $this->input->get ( "sorting" );
					$sorting ["direction"] = $this->input->get ( "direction" );
				}
				$data ["options"] = $options;
				bake_cookie ( "sorting", implode ( ",", $sorting ["fields"] ) );
				bake_cookie ( "direction", implode ( ",", $sorting ["direction"] ) );
				$data ["plants"] = $this->variety->find ( $variables, $sorting );
				if ($no_image = $this->input->get ( 'no_image' )) {
					bake_cookie ( "no_image", $no_image );
				}
				else {
					burn_cookie ( "no_image" );
				}
				$data ["options"] ["no_image"] = $no_image;
				$print_list = array ();
				foreach ( $data ["plants"] as $plant ) {
					$print_list [] = $plant->id;
					if ($action == "history") {
						$plant->orders = $this->order->get_for_variety ( $plant->id );
					}
					elseif ($action == "flags") {
						$plant->flags = $this->flag->get_for_variety ( $plant->id );
					}
				}
				$this->session->set_userdata ( "print_list", $print_list );
				$data ["title"] = "List of Varieties";
				
				$data ["target"] = "variety/list/$action";
				$data ["full_list"] = TRUE;
				
				$this->load->view ( "page/index", $data );
			}
			else {
				$this->_search ();
			}
		}

		function _search ()
		{
			$this->load->model ( "menu_model", "menu" );
			$this->load->model ( "category_model", "category" );
			$this->load->model ( "subcategory_model", "subcategory" );
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
			$plant_colors = $this->menu->get_pairs ( "plant_color", array (
					"field" => "value",
					"direction" => "ASC" 
			) );
			$data ["plant_colors"] = get_keyed_pairs ( $plant_colors, array (
					"key",
					"value" 
			), TRUE, FALSE, array (
					"name" => "NULL",
					"value" => "NULL--No Color Selected" 
			) ); // include option to search for an empty color
			$flags = $this->menu->get_pairs ( "flag", array (
					"field" => "value" 
			) );
			$data ["flags"] = get_keyed_pairs ( $flags, array (
					"key",
					"value" 
			), TRUE );
			$data ["variety"] = NULL;
			$data ["title"] = "Variety Search";
			$data ["target"] = "variety/search";
			if ($this->input->get ( "ajax" )) {
				$this->load->view ( "variety/search", $data );
			}
			else {
				
				$this->load->view ( "page/index", $data );
			}
		}

		function search_by_name ()
		{
			$name = $this->input->get ( "name" );
			$data ["names"] = $this->variety->get_by_name ( $name );
			$data ["full_list"] = FALSE;
			if ($this->input->get ( "type" ) == "inline") {
				$target = "variety/list/inline";
			}
			else {
				$target = "variety/list/list";
			}
			$this->load->view ( $target, $data );
		}

		function edit ()
		{
		}

		function update ()
		{
			$id = $this->input->post ( "id" );
			$this->variety->update ( "id" );
			redirect ( "variety/view/$id" );
		}

		function delete ()
		{
			$id = $this->input->post ( "id" );
			$common_id = $this->variety->get_value ( $id, "common_id" );
			$this->variety->delete ( $id );
			if ($this->input->post ( "ajax" )) {
				echo $common_id;
			}
			else {
				redirect ( "common/view/$common_id" );
			}
		}

		/**
		 * show all the plants that have been reordered from previous years.
		 *
		 * @param int(4) $year        	
		 */
		function show_reorders ( $year )
		{
			$data ['plants'] = $this->variety->get_reorders ( $year );
			foreach ( $data ['plants'] as $plant ) {
				$plant->omit = 0;
			}
			$data ['target'] = "variety/list/full";
			$data ['title'] = "List of reordered plants for $year";
			$this->load->view ( "page/index", $data );
		}

		function edit_common_id ()
		{
			if ($this->ion_auth->in_group ( 1 )) {
				if ($this->input->get ( "edit" )) {
					$id = $this->input->get ( "id" );
					$data ["variety"] = $this->variety->get ( $id );
					$this->load->view ( "variety/edit_common", $data );
				}
				else {
					$id = $this->input->post ( "id" );
					$common_id = $this->input->post ( "common_id" );
					$this->variety->update ( $id, array (
							"common_id" => $common_id 
					) );
					redirect ( "variety/view/$id" );
				}
			}
			else {
				echo "You do not have permission to edit this!";
			}
		}

		function edit_value ()
		{
			$data ["name"] = $this->input->get ( "field" );
			
			$value = $this->input->get ( "value" );
			$data ["value"] = $value;
			if (is_array ( $value )) {
				$data ["value"] = implode ( ",", $value );
			}
			$data ["id"] = $this->input->get ( "id" );
			$data ["size"] = strlen ( $data ["value"] ) + 5;
			$data ["type"] = $this->input->get ( "type" );
			$data ["category"] = $this->input->get ( "category" );
			
			switch ($data ["type"]) {
				case "dropdown" :
					$output = $this->_get_dropdown ( $data ["category"], $data ["value"], $data ["name"] );
					break;
				case "multiselect" :
					$output = $this->_get_multiselect ( $data ["category"], $data ["value"], $data ["name"] );
					break;
				case "textarea" :
					$output = form_textarea ( $data, $data ["value"] );
					break;
				case "autocomplete" :
					$output = form_input ( $data, $data ["value"], "class='autocomplete'" );
					break;
				default :
					$output = form_input ( $data );
			}
			
			echo $output;
		}

		function update_value ()
		{
			$id = $this->input->post ( "id" );
			$value = $this->input->post ( "value" );
			if (is_array ( $value )) {
				$value = implode ( ",", $value );
			}
			$values = array (
					$this->input->post ( "field" ) => $value 
			);
			$this->variety->update ( $id, $values );
			echo $value;
		}

		function update_new_status ( $year )
		{
			$output = "";
			if ($year) {
				
				$output = $this->variety->update_all ( $year );
			}
			$this->session->set_flashdata ( "notice", sprintf ( "%s varieties were marked as new items for %s", count ( $output ), $year ) );
			redirect ( "index" );
		}

		function add_flag ()
		{
			$id = $this->input->get ( "id" );
			$flags = $this->flag->get_missing ( $id );
			$data ["flags"] = get_keyed_pairs ( $flags, array (
					"key",
					"value" 
			), TRUE );
			$this->load->view ( "flag/edit", $data );
		}

		function insert_flag ()
		{
			$id = $this->flag->insert ();
			$this->get_flags ( $this->input->post ( "variety_id" ) );
		}

		function get_flags ( $id )
		{
			$data ["flags"] = $this->flag->get_for_variety ( $id );
			$this->load->view ( "flag/list", $data );
		}

		function delete_flag ()
		{
			$id = $this->input->post ( "id" );
			$this->flag->delete ( $id );
			$this->get_flags ( $this->input->post ( "variety_id" ) );
		}

		function batch_update_flags ()
		{
			if (IS_ADMIN) {
				if ($this->input->post ( "action" ) == "edit") {
					$this->load->model ( "menu_model", "menu" );
					$flags = $this->menu->get_pairs ( "flag" );
					$data ["target"] = $this->input->post ( "target" );
					$data ["flags"] = get_keyed_pairs ( $flags, array (
							"key",
							"value" 
					) );
					$data ["ids"] = $this->input->post ( "ids" );
					$this->load->view ( "variety/batch_update_flags", $data );
				}
				elseif ($this->input->post ( "action" ) == "update") {
					$target = $this->input->post ( "target" );
					if ($this->input->post ( "flag" ) && $this->input->post ( "ids" )) {
						$flag = urldecode ( $this->input->post ( "flag" ) );
						$ids = explode ( ",", $this->input->post ( "ids" ) );
						$this->flag->batch_update ( $ids, $flag );
						$result = sprintf ( "The following varieties had the flag '%s' added: %s", $flag, $this->input->post ( "ids" ) );
					}
					else {
						$result = "No Batch Updates Made";
					}
					$this->session->set_flashdata ( "notice", $result );
					redirect ( $target );
				}
			}
		}

		function print_result ( $format = FALSE )
		{
			$plants = $this->input->post ( "ids" );
			if (! $format) {
				$format = $this->input->post ( "format" );
			}
			
			$data ["format"] = $format;
			
			if ($format == "select") {
				$data ["ids"] = implode ( ",", $plants );
				$this->load->view ( "variety/print/selector", $data );
			}
			else {
				$this->load->helper ( "export" );
				$plants = explode ( ",", $plants );
				$alerts = array ();
				if ($plants) {
					foreach ( $plants as $plant ) {
						$data ['plants'] [$plant] ['variety'] = $this->variety->get ( $plant );
						$data ['plants'] [$plant] ['order'] = $this->order->get_for_variety ( $plant, get_current_year () );
						$data ['plants'] [$plant] ['flags'] = $this->flag->get_for_variety ( $plant );
						if ($format) {
							$alerts [] = $this->resize_image ( $plant, $format, TRUE );
						}
					}
					
					$data ["classes"] = "";
					$count = count ( $plants );
					$data ["title"] = sprintf ( "%s-Size List-%s Pages", ucfirst ( $format ), $count );
					$data ["target"] = "variety/print/multiple";
					
					$this->load->view ( "variety/print/index", $data );
				}
			}
		}

		function print_options ( $id )
		{
			// $data["id"] = $id;
			// $this->load->view("variety/print/options", $data);
			redirect ( "variety/print/$id" );
		}

		function print_one ( $id, $format )
		{
			$this->load->helper ( "export" );
			$data ["format"] = $format;
			$data ['variety'] = $this->variety->get ( $id );
			$this->resize_image ( $id, $format );
			$data ['order'] = $this->order->get_for_variety ( $id, get_cookie ( "sale_year" ) );
			if ($data ['order']) {
				$data ['flags'] = $this->flag->get_for_variety ( $id );
				// if ($data ['variety']->new_year == get_cookie ( "sale_year" )) {
				// $new = array (
				// "thumbnail" => "new-icon.png"
				// );
				// $data ['flags'] [] = ( object ) $new;
				// }
				$data ['title'] = sprintf ( "%s-size Printout for %s %s", ucfirst ( $format ), $data ['variety']->common_name, $data ['variety']->variety );
				$data ["target"] = "variety/print/$format";
				$data ["classes"] = "";
				
				if (get_value ( $data ["order"], "crop_failure" ) == 1) {
					$data ["classes"] = "crop-failure";
				}
				$this->load->view ( "variety/print/index", $data );
			}
			else {
				show_error ( sprintf ( "%s has no orders in %s", $data ['variety']->variety, get_cookie ( "sale_year" ) ) );
			}
		}

		function update_new_varieties ( $sale_year )
		{
			print_r ( $this->variety->update_all ( $sale_year ) );
		}

		function quark ()
		{
			$plants = $this->session->userdata ( "print_list" );
			foreach ( $plants as $plant ) {
				$data ['plants'] [$plant] ['variety'] = $this->variety->get ( $plant );
				$data ['plants'] [$plant] ['order'] = $this->order->get_for_variety ( $plant, get_current_year () );
				$data ['plants'] [$plant] ['flags'] = $this->flag->get_for_variety ( $plant );
			}
		}

		function show_copy_text ()
		{
			$data ["varieties"] = $this->variety->get_varieties_for_year ( get_current_year (), TRUE );
			$data ["title"] = "Wasting Trees";
			$data ["target"] = "variety/print/paper_waste";
			$data ["format"] = "print";
			$data ["classes"] = "";
			$this->load->view ( "variety/print/index", $data );
		}

		/**
		 * * FILE MANAGEMENT **
		 */
		function new_image ()
		{
			if ($this->input->get ( 'variety_id' )) {
				$data ['variety_id'] = $this->input->get ( 'variety_id' );
				$data ['error'] = '';
				$data ['image'] = null;
				$this->load->view ( 'variety/image', $data );
			}
		}

		function attach_image ()
		{
			$config ['upload_path'] = './files';
			$this->load->helper ( 'directory' );
			$config ['allowed_types'] = 'jpg';
			$config ['max_size'] = '2048';
			$config ['max_width'] = '0';
			$config ['max_height'] = '0';
			$config ['file_name'] = $this->input->post ( "variety_id" ) . ".jpg";
			
			$this->load->library ( 'upload', $config );
			
			if (! $this->upload->do_upload ()) {
				$error = array (
						'error' => $this->upload->display_errors () 
				);
				print_r ( $error );
			}
			else {
				
				$file_data = $this->upload->data ();
				$data ['image_display_name'] = $file_data ['file_name'];
				$data ['image_source'] = $this->input->post ( 'image_source' );
				$this->load->model ( "image_model" );
				$variety_id = $this->input->post ( "variety_id" );
				$id = $this->image_model->insert ( $variety_id, $file_data );
				$this->resize_image ( $variety_id, "statement" );
				redirect ( "variety/view/$variety_id" );
			}
		}

		function delete_image ()
		{
			$id = $this->input->post ( "id" );
			$this->load->model ( "image_model" );
			$variety_id = $this->image_model->get ( $id )->variety_id;
			unlink ( "./files/$variety_id.jpg" );
			$this->image_model->delete ( $id );
			if ($this->input->post ( "ajax" ) == 1) {
				$data ["variety"] = NULL;
				$data ["variety_id"] = $variety_id;
				$this->load->view ( "image/view", $data );
			}
			else {
				redirect ( "variety/view/$variety_id" );
			}
		}

		/**
		 * using the GD2 image manipulation system, this creates any new files if
		 * none exist.
		 * The $force_update option can be used to forceably update all files.
		 *
		 * @param unknown $image_name        	
		 * @param unknown $format        	
		 * @param string $force_update        	
		 */
		function resize_image ( $image_name, $format, $force_update = FALSE )
		{
			if (in_array ( $format, array (
					"statement",
					"tabloid",
					"letter",
					"shovel_foot",
					"thumbnail" 
			) )) {
				
				$this->load->helper ( "file" );
				$source_image = "./files/$image_name.jpg";
				$new_image = "./files/$format/$image_name.jpg";
				if (! get_file_info ( $new_image ) || $force_update) {
					
					$config ['image_library'] = 'gd2';
					$config ['source_image'] = $source_image;
					$config ['new_image'] = $new_image;
					$config ['maintain_ratio'] = TRUE;
					$config ['quality'] = "75";
					switch ($format) {
						case "statement" :
							$config ['width'] = 250;
							$config ['height'] = 250;
							break;
						case "tabloid" :
							$config ['width'] = 792;
							$config ['height'] = 792;
							break;
						case "letter" :
							$config ['width'] = 480;
							$config ['height'] = 480;
							break;
						case "shovel_foot" :
							$config ['width'] = 540;
							$config ['height'] = 540;
							break;
						case "thumbnail" :
							$config ['width'] = 100;
							$config ['height'] = 100;
					}
					
					$this->load->library ( 'image_lib', $config );
					if (! $this->image_lib->resize ()) {
						return $this->image_lib->display_errors () . $source_image;
					}
					
					$this->image_lib->clear ();
				}
			}
		}

		/**
		 * PRIVATE FUNCTIONS
		 */
		function _get_dropdown ( $category, $value, $field )
		{
			$this->load->model ( "menu_model", "menu" );
			$categories = $this->menu->get_pairs ( $category, array (
					"field" => "value",
					"direction" => "ASC" 
			) );
			$pairs = get_keyed_pairs ( $categories, array (
					"key",
					"value" 
			) );
			return form_dropdown ( $field, $pairs, $value, "class='live-field'" );
		}

		function _get_multiselect ( $category, $value, $field )
		{
			$this->load->model ( "menu_model", "menu" );
			$categories = $this->menu->get_pairs ( $category, array (
					"field" => "value",
					"direction" => "ASC" 
			) );
			$pairs = get_keyed_pairs ( $categories, array (
					"key",
					"value" 
			) );
			$output = array ();
			$output [] = form_multiselect ( $field, $pairs, $value, "id='$field'" );
			$buttons = implode ( " ", $output );
			echo $buttons . sprintf ( "<span class='button save-multiselect' target='%s'>Save</span>", $field );
		}
	}