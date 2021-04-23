<?php

defined('BASEPATH') or exit ('No direct script access allowed');

class Variety extends MY_Controller
{

	public $s3_vars;


	function __construct()
	{
		parent::__construct();
		if (IS_INVENTORY) {
			redirect('inventory');
		}
		$this->load->model("variety_model", "variety");
		$this->load->model("common_model", "common");
		$this->load->model("order_model", "order");
		$this->load->model("flag_model", "flag");
		// $this->load->library ( "field" );
	}

	function index()
	{
		// $this->variety->update_needs_bag ();
	}

	function create()
	{
		$this->load->model('menu_model', 'menu');
		$data['target'] = 'variety/edit';
		$data['variety'] = '';
		$data['common_id'] = $this->input->get('common_id');
		$measure_units = $this->menu->get_pairs('measure_unit');
		$data['measure_units'] = get_keyed_pairs($measure_units, [
			'key',
			'value',
		], TRUE);
		$plant_colors = $this->menu->get_pairs('plant_color', [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$data['plant_colors'] = get_keyed_pairs($plant_colors, [
			'key',
			'value',
		]);
		$data['action'] = 'insert';
		$data['title'] = 'Add a new variety';
		$this->load->view($data['target'], $data);
	}

	function insert()
	{
		$id = $this->variety->insert();
		if ($this->input->post('add_order')) {
			//@TODO fix this. It doesn't re-populate the form.

			$data['variety_id'] = $id;
			$data['order'] = $this->order->get_previous_year($data['variety_id'], get_current_year());
			$pot_sizes = $this->order->get_pot_sizes();
			$data['pot_sizes'] = get_keyed_pairs($pot_sizes, [
				'pot_size',
				'pot_size',
			]);
			$data['action'] = 'insert';
			print $this->load->view('order/edit', $data, TRUE);
			return TRUE;
		}

		redirect('variety/view/' . $id);
	}

	function view($id) {
		$variety = $this->variety->get($id);
		$current_order = $this->order->get_for_variety($id, get_current_year());
		$data ['current_order'] = $current_order;
		$data ['file_path'] = '/files';
		$orders = $this->order->get_for_variety($id);
		foreach ($orders as $order) {
			if ($order->year == get_current_year()) {
				$label = '';
				extract(get_toggle_text('flat_exclude', $order->flat_exclude));
				$order->flat_exclude_button = $label;
			}
		}
		$data['orders'] = $orders;
		$data['flags'] = $this->flag->get_for_variety($id);
		$data['is_new'] = $variety->new_year == get_current_year();
		$data['variety'] = $variety;
		$data['target'] = 'variety/view';
		$data['title'] = sprintf('Viewing Info for %s (variety)', $variety->variety);
		$data['variety_id'] = $id;
		if ($data['mini_view'] = $this->input->get('ajax') == 1) {
			$this->load->view('variety/mini_view', $data);
		} else {
			$data['mini_view'] = FALSE;
			$this->load->view('page/index', $data);
		}
	}

	function search()
	{
		$action = $this->input->get('action');
		if ($action == 'reorders') {
			redirect('variety/show_reorders/' . $this->input->get('year'));
		}
		if ($this->input->get('find')) {

			$variables = [
				'name',
				'variety',
				'genus',
				'species',
				'category_id',
				'subcategory_id',
				'flag',
				'plant_color',
				'sunlight',
				'description',
				'year',
				'flat_size',
				'grower_id',
				'new_year',
				'omit',
				'web_description',
				'print_description',
				'needs_bag',
				'crop_failure',
				'catalog_number',
				'descriptions',
				'editor',
				'copywriter',
				'edit_notes',
				'needs_copy_review',
				'churn_value',
				'pot_size',
			];
			$options = [];
			$options['action'] = $action;
			bake_cookie('action', $this->input->get('action'));
			for ($i = 0; $i < count($variables); $i++) {
				$my_variable = $variables[$i];
				if ($my_value = $this->input->get($my_variable)) {
					switch ($my_variable) {
						case 'category_id':
							$this->load->model('category_model', 'category');
							$options['category'] = $this->category->get($my_value)->category;
							break;
						case 'subcategory_id':
							$this->load->model('subcategory_model', 'subcategory');
							$options['subcategory'] = $this->subcategory->get($my_value)->subcategory;
							break;
						case 'sunlight':
							bake_cookie($my_variable, implode(',', $my_value));
							$options[$my_variable] = implode(',', $my_value);
							break;
						case 'pot_size':
							bake_cookie($my_variable, $my_value);
							$options[$my_variable] = urldecode($my_value);
							break;
						default:
							$options[$my_variable] = $my_value;
					}
					bake_cookie($my_variable, $my_value);
				} else {
					burn_cookie($my_variable);
				}
			}

			if ($not_flag = $this->input->get('not_flag')) {
				bake_cookie('not_flag', $not_flag);
			} else {
				burn_cookie('not_flag');
			}

			if ($sunlight_boolean = $this->input->get('sunlight-boolean')) {
				if (array_key_exists('sunlight', $options)) {
					$options['sunlight_boolean'] = $sunlight_boolean;
				}
				bake_cookie('sunlight-boolean', $sunlight_boolean);
			} else {
				burn_cookie('sunlight-boolean');
			}
			$sorting['fields'] = [
				'catalog_number',
			];
			$sorting['direction'] = [
				'ASC',
			];

			if ($this->input->get('sorting')) {
				$sorting['fields'] = $this->input->get('sorting');
				$sorting['direction'] = $this->input->get('direction');
			}
			$data['options'] = $options;
			bake_cookie('sorting', implode(',', $sorting['fields']));
			bake_cookie('direction', implode(',', $sorting['direction']));
			$data['plants'] = $this->variety->find($variables, $sorting);
			if ($no_image = $this->input->get('no_image')) {
				bake_cookie('no_image', $no_image);
			} else {
				burn_cookie('no_image');
			}
			$data['options']['no_image'] = $no_image;
			$print_list = [];
			foreach ($data['plants'] as $plant) {
				$print_list[] = $plant->id;
				if ($action == 'history') {
					$plant->orders = $this->order->get_for_variety($plant->id);
				} elseif ($action == 'flags') {
					$plant->flags = $this->flag->get_for_variety($plant->id);
				} elseif ($action == 'edits') {
					$this->load->model('user_model', 'user');
					$users = $this->user->get_user_pairs();
					$data['users'] = get_keyed_pairs($users, [
						'id',
						'name',
					], TRUE);
				}
			}
			$this->session->set_userdata('print_list', $print_list);
			if ($this->input->get('export')) {
				$data['export_type'] = 'standard';
				$date_string = date('Y-m-d-h-j');
				$data['filename'] = sprintf('variety-export_%s.csv', $date_string);

				if ($export_type = $this->input->get('export_type')) {
					$data['export_type'] = $export_type;
					$data['filename'] = sprintf('%s_%s.csv', $export_type, $date_string);
				}
				$this->load->helper("download");
				$this->load->view("variety/list/export", $data);
			}
			elseif ($action == "printable-copy") {
				$data["year"] = $this->input->get("year");
				$data ["title"] = "Printable List";
				$data ["target"] = "variety/print/copy_edits";
				$data ["format"] = "print";
				$data ["classes"] = "";
				$this->load->view("variety/print/index", $data);
			}
			else {
				$data ["title"] = "List of Varieties";

				$data['target'] = 'variety/list/' . $action;
				$data['full_list'] = TRUE;

				$this->load->view('page/index', $data);
			}
		} else {
			$this->_search($action);
		}
	}

	function _search($action)
	{
		$this->load->model('menu_model', 'menu');
		$this->load->model('category_model', 'category');
		$this->load->model('subcategory_model', 'subcategory');
		$this->load->model('order_model', 'order');

		$pot_sizes = $this->order->get_pot_sizes();
		$data['pot_sizes'] = get_keyed_pairs($pot_sizes, [
			'pot_size',
			'pot_size',
		], NULL, TRUE);
		// if ($action == "edits") {
		$this->load->model('user_model', 'user');
		$users = $this->user->get_user_pairs();
		$data['users'] = get_keyed_pairs($users, [
			'id',
			'name',
		], TRUE);
		// }
		$categories = $this->category->get_pairs();
		$data['categories'] = get_keyed_pairs($categories, [
			'key',
			'value',
		], TRUE);
		$subcategories = $this->subcategory->get_pairs();
		$data['subcategories'] = get_keyed_pairs($subcategories, [
			'key',
			'value',
		], TRUE);
		$sunlight = $this->menu->get_pairs('sunlight', [
			'field' => 'value',
		]);
		$data['sunlight'] = $sunlight;
		$plant_colors = $this->menu->get_pairs('plant_color', [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$data['plant_colors'] = get_keyed_pairs($plant_colors, [
			'key',
			'value',
		], TRUE, FALSE, [
			'name' => 'NULL',
			'value' => 'NULL--No Color Selected',
		]); // include option to search for an empty color
		$flags = $this->menu->get_pairs('flag', [
			'field' => 'value',
		]);
		$data['flags'] = get_keyed_pairs($flags, [
			'key',
			'value',
		], TRUE);
		$data['variety'] = NULL;
		$data['title'] = 'Variety Search';
		$data['target'] = 'variety/search';
		if ($action == 'edits') {
			$data['target'] = 'variety/edits_search';
		}

		if ($this->input->get('ajax')) {
			$this->load->view($data['target'], $data);
		} else {

			$this->load->view('page/index', $data);
		}
	}

	function search_by_name()
	{
		$name = $this->input->get('name');
		$data['names'] = $this->variety->get_by_name($name);
		$data['full_list'] = FALSE;
		if ($this->input->get('type') == 'inline') {
			$target = 'variety/list/inline';
		} else {
			$target = 'variety/list/list';
		}
		$this->load->view($target, $data);
	}

	function get_crop_failures()
	{
		$failures = $this->variety->get_crop_failures();
	}

	function edit()
	{
	}

	function get($id)
	{
		$variety = json_encode($this->variety->get($id));
		print $variety;
	}

	function update()
	{
		$id = $this->input->post('id');
		$this->variety->update('id');
		redirect('variety/view/' . $id);
	}

	function delete()
	{
		$id = $this->input->post('id');
		$common_id = $this->variety->get_value($id, 'common_id');
		$this->variety->delete($id);
		if ($this->input->post('ajax')) {
			print $common_id;
		} else {
			redirect('common/view/' . $common_id);
		}
	}

	/**
	 * show all the plants that have been reordered from previous years.
	 *
	 * @param int(4) $year
	 */
	function show_reorders($year)
	{
		$data['plants'] = $this->variety->get_reorders($year);
		foreach ($data['plants'] as $plant) {
			$plant->omit = 0;
		}
		$data['options'] = [
			'action' => 'Reorders',
		];
		$data['target'] = 'variety/list/full';
		$data['title'] = 'List of reordered plants for ' . $year;
		$this->load->view('page/index', $data);
	}

	function edit_common_id()
	{
		if ($this->ion_auth->in_group(1)) {
			if ($this->input->get('edit')) {
				$id = $this->input->get('id');
				$data['variety'] = $this->variety->get($id);
				$this->load->view('variety/edit_common', $data);
			} else {
				$id = $this->input->post('id');
				$common_id = $this->input->post('common_id');
				$this->variety->update($id, [
					'common_id' => $common_id,
				]);
				redirect('variety/view/' . $id);
			}
		} else {
			print 'You do not have permission to edit this!';
		}
	}

	function edit_value()
	{
		$data['name'] = $this->input->get('field');

		$value = $this->input->get('value');
		$data['value'] = $value;
		if (is_array($value)) {
			$data['value'] = implode(',', $value);
		}
		$data['id'] = $this->input->get('id');
		$data['size'] = strlen($data['value']) + 5;
		$data['type'] = $this->input->get('type');
		$data['category'] = $this->input->get('category');

		switch ($data['type']) {
			case "dropdown":
				$output = $this->_get_dropdown($data['category'], $data['value'], $data['name']);
				break;
			case 'multiselect':
				$output = $this->_get_multiselect($data['category'], $data['value'], $data['name']);
				break;
			case 'textarea':
				$output = form_textarea($data, $data['value']);
				break;
			case 'autocomplete':
				$output = form_input($data, $data['value'], 'class="autocomplete"');
				break;
			default:
				$output = form_input($data);
		}

		print $output;
	}

	function update_value()
	{
		$id = $this->input->post('id');
		$value = $this->input->post('value');
		$field = $this->input->post('field');
		if (strpos($field, 'height') || strpos($field, 'width')) {
			$value = preg_replace('/[^0-9.]/', '', $value);
		}
		if (is_array($value)) {
			$value = implode(',', $value);
		}
		$values = [
			$field => $value,
		];
		$override = FALSE;
		if ($field == 'copywriter') {
			$override = TRUE;
		}
		/**
		 * @todo What is $override for?
		 */
		$this->variety->update($id, $values, $override);
		// print $override;
		if ($field == 'editor') {
			if ($value) {
				$this->load->model('user_model', 'user');
				$user = $this->user->get_user($value);
				$value = sprintf('%s %s', $user->first_name, $user->last_name);
			} else {
				$value = '&nbsp;';
			}
		}
		print $value;
	}

	function update_new_status($year)
	{
		$output = '';
		if ($year) {

			$output = $this->variety->update_all($year);
		}
		$this->session->set_flashdata('notice', sprintf('%s varieties were marked as new items for %s', count($output), $year));
		redirect('index');
	}

	function add_flag()
	{
		$id = $this->input->get('id');
		$flags = $this->flag->get_missing($id);
		$data['flags'] = get_keyed_pairs($flags, [
			'key',
			'value',
		], TRUE);
		$this->load->view('flag/edit', $data);
	}

	function insert_flag()
	{
		$id = $this->flag->insert();
		$this->get_flags($this->input->post('variety_id'));
	}

	function get_flags($id)
	{
		$data['flags'] = $this->flag->get_for_variety($id);
		$this->load->view('flag/list', $data);
	}

	function delete_flag()
	{
		$id = $this->input->post('id');
		$this->flag->delete($id);
		$this->get_flags($this->input->post('variety_id'));
	}

	function batch_update()
	{
		if (IS_ADMIN) {
			if ($this->input->post('action') == 'edit') {
				if ($this->input->post('field') == 'online_only') {
					$data['ids'] = $this->input->post('ids');
					$this->load->view('variety/batch_update_online_only', $data);
				} else {
					$this->load->model('menu_model', 'menu');
					$flags = $this->menu->get_pairs('flag');
					$data['flags'] = get_keyed_pairs($flags, [
						'key',
						'value',
					]);
					$data['ids'] = $this->input->post('ids');
					$this->load->view('variety/batch_update_flags', $data);
				}
			} elseif ($this->input->post('action') == 'update') {
				if (!empty($this->input->post('ids'))) {
					$ids = explode(',', $this->input->post('ids'));
					$id_list = implode(', ', $ids);
					if ($this->input->post('flag')) {
						$flag = urldecode($this->input->post('flag'));
						$this->flag->batch_update($ids, $flag);
						$result = sprintf('The following varieties had the flag "%s" added: %s', $flag,  $id_list);
					} else {
						$result = 'No Batch Updates Made';
					}
				}
				$this->session->set_flashdata('notice', $result);
				redirect();
			}
		}
	}

	function print_result($format = FALSE)
	{
		$plants = $this->input->post('ids');
		if (!$format) {
			$format = $this->input->post('format');
		}

		$data['format'] = $format;

		if ($format == 'select') {
			$data['ids'] = implode(',', $plants);
			$this->load->view('variety/print/selector', $data);
		} else {
			$this->load->helper('export');
			$plants = explode(',', $plants);
			$alerts = [];
			if ($plants) {
				foreach ($plants as $plant) {
					$data['plants'][$plant]['variety'] = $this->variety->get($plant);
					$data['plants'][$plant]['order'] = $this->order->get_for_variety($plant, get_current_year());
					$data['plants'][$plant]['flags'] = $this->flag->get_for_variety($plant);
					if ($format) {
						// $alerts [] = $this->resize_image ( $plant, $format, TRUE );
					}
				}

				$data['classes'] = 'multiple';
				$count = count($plants);
				$data['title'] = sprintf('%s-Size List-%s Pages', ucfirst($format), $count);
				$data['target'] = 'variety/print/multiple';

				$this->load->view('variety/print/index', $data);
			}
		}
	}

	function print_options($id)
	{
		// $data['id'] = $id;
		// $this->load->view("variety/print/options", $data);
		redirect('variety/print/' . $id);
	}

	function print_one($id, $format)
	{
		$this->load->helper('export');
		$data['format'] = $format;
		$data['variety'] = $this->variety->get($id);
		//$this->resize_image ( $id, $format );
		$data['order'] = $this->order->get_for_variety($id, $this->session->userdata('sale_year'));
		if ($data['order']) {
			$data['flags'] = $this->flag->get_for_variety($id);
			$data['title'] = sprintf('%s-size Printout for %s %s', ucfirst($format), $data['variety']->common_name, $data['variety']->variety);
			$data['target'] = 'variety/print/' . $format;
			$data['classes'] = 'single';
			if (get_value($data['order'], 'crop_failure') == 1) {
				$data['classes'] = 'crop-failure';
			}
			$this->load->view('variety/print/index', $data);
		} else {
			show_error(sprintf('%s has no orders in %s', $data['variety']->variety, cookie('sale_year')));
		}
	}

	function update_new_varieties($sale_year)
	{
		print_r($this->variety->update_all($sale_year));
	}

	function quark()
	{
		$plants = $this->session->userdata('print_list');
		foreach ($plants as $plant) {
			$data['plants'][$plant]['variety'] = $this->variety->get($plant);
			$data['plants'][$plant]['order'] = $this->order->get_for_variety($plant, get_current_year());
			$data['plants'][$plant]['flags'] = $this->flag->get_for_variety($plant);
		}
	}

	function show_copy_text()
	{
		// @TODO merge this function with the search function.
		$data ["plants"] = $this->variety->get_varieties_for_year(get_current_year(), TRUE);
		$data ["year"] = get_current_year();
		$data ["title"] = "Printable List";
		$data ["target"] = "variety/print/copy_edits";
		$data ["format"] = "print";
		$data ["classes"] = "";
		$this->load->view("variety/print/index", $data);
	}


	/**
	 * * FILE MANAGEMENT **
	 */
	function new_image($variety_id)
	{
		$variety = $this->variety->get($variety_id);
		$data = [
			'variety_id' => $variety_id,
			'error' => NULL,
			'image' => NULL,
			'target' => 'variety/image',
			'title' => 'Add Image to ' . $variety->variety,
		];
		if ($this->input->get('ajax')) {
			$this->load->view('page/modal', $data);
		} else {
			$this->load->view('page/index', $data);
		}
	}

	function attach_image()
	{
		$variety_id = $this->input->post('variety_id');
		$config['upload_path'] = '/tmp';
		$this->load->helper('directory');
		$config['allowed_types'] = 'jpg|jpeg';
		$config['max_size'] = '2048';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['file_name'] = $variety_id . '.jpg';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			$error = [
				'error' => $this->upload->display_errors(),
			];
			print_r($error);
		} else {

			$file_data = $this->upload->data();
			$data['image_display_name'] = $file_data['file_name'];
			$data['image_source'] = $this->input->post('image_source');
			$this->load->model('image_model');
			$this->image_model->insert($variety_id, $file_data);
			$this->load->library('S3_client', $this->s3_vars);
			try {
				$this->s3_client->putFile($variety_id . '.jpg', $file_data);
			} catch (Exception $e) {
				$this->session->set_flashdata('alert', 'The file was not uploaded correctly. Please email the file and the url of this page to the site developer.');
			}
			redirect('variety/view/' . $variety_id);
		}
	}

	function delete_image()
	{
		$id = $this->input->post('id');
		$this->load->library('s3_client', $this->s3_vars);
		$this->load->model('image_model');
		$variety_id = $this->image_model->get($id)->variety_id;
		$this->image_model->delete($id);
		try {
			$this->s3_client->deleteFile($variety_id . '.jpg');
		} catch (Exception $e) {
			$this->session->set_flashdata('warning', 'The file could not be deleted.');
			$data['message'] = 'The file was not successfully deleted from the S3 container, but the file record was deleted from the database. Please see the site developer for help with this.';
		}
		$variety = $this->variety->get($variety_id);
		if ($this->input->post('ajax') == 1) {
			$data['variety'] = $variety;
			$data['variety_id'] = $variety_id;
			$data['file_path'] = $this->s3_client->getPath();
			$this->load->view('image/view', $data);
		} else {
			redirect('variety/view/' . $variety_id);
		}
	}

	/**
	 * using the GD2 image manipulation system, this creates any new files if
	 * none exist.
	 * The $force_update option can be used to forcibly update all files.
	 *
	 * @param string $image_name
	 * @param string $format
	 * @param bool $force_update
	 *
	 * @return string
	 */
	function resize_image(string $image_name, string $format, $force_update = FALSE)
	{
		if (in_array($format, [
			'statement',
			'tabloid',
			'letter',
			'shovel_foot',
			'thumbnail',
		])) {
			$config = [];
			$this->load->helper('file');
			$source_image = './files/' . $image_name . '.jpg';
			$new_image = './files/' . $format . '/' . $image_name . '.jpg';
			if (!get_file_info($new_image) || $force_update) {

				$config['image_library'] = 'gd2';
				$config['source_image'] = $source_image;
				$config['new_image'] = $new_image;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = '75';
				switch ($format) {
					case 'statement':
						$config['width'] = 250;
						$config['height'] = 250;
						break;
					case 'tabloid':
						$config['width'] = 792;
						$config['height'] = 792;
						break;
					case 'letter':
						$config['width'] = 480;
						$config['height'] = 480;
						break;
					case 'shovel_foot':
						$config['width'] = 540;
						$config['height'] = 540;
						break;
					case 'thumbnail':
						$config['width'] = 100;
						$config['height'] = 100;
				}

				$this->load->library('image_lib', $config);
				if (!$this->image_lib->resize()) {
					return $this->image_lib->display_errors() . $source_image;
				}

				$this->image_lib->clear();
			}
		}
	}

	/**
	 * PRIVATE FUNCTIONS
	 */
	function _get_dropdown($category, $value, $field)
	{
		$this->load->model('menu_model', 'menu');
		$categories = $this->menu->get_pairs($category, [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$pairs = get_keyed_pairs($categories, [
			'key',
			'value',
		]);
		return form_dropdown($field, $pairs, $value, 'class="live-field"');
	}

	function _get_multiselect($category, $value, $field)
	{
		$this->load->model('menu_model', 'menu');
		$categories = $this->menu->get_pairs($category, [
			'field' => 'value',
			'direction' => 'ASC',
		]);
		$pairs = get_keyed_pairs($categories, [
			'key',
			'value',
		]);
		$output = [];
		$output[] = form_multiselect($field, $pairs, $value, "id='$field'");
		$buttons = implode(' ', $output);
		print $buttons . sprintf($field);
	}

	function toggle()
	{
		$value = 	$value = $this->input->post('value') === 'no' ? 'yes' : 'no';
		print toggle($this, $this->variety, $value);
	}
}
