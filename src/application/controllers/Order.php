<?php
defined('BASEPATH') or exit('No direct script access allowed');

// order.php Chris Dart Feb 28, 2013 9:38:32 PM chrisdart@cerebratorium.com
class Order extends MY_Controller {

  function __construct() {
    parent::__construct();
    if (IS_INVENTORY) {
      redirect('inventory');
    }
    $this->load->model('order_model', 'order');
    $this->load->model('category_model', 'category');
  }

  function index() {
    redirect('order/search');
  }

  function view() {
    $id             = $this->uri->segment(3);
    $order          = $this->order->get($id);
    $data['order']  = $order;
    $data['target'] = 'order/view';
    $data['title']  = 'Viewing Order Details';
    $this->load->view('page/index', $data);
  }

  function search() {
    if ($this->input->get('find')) {
      bake_cookie('order_search', $_SERVER['QUERY_STRING']);
      $options = [];

      if (!$sale_year = $this->input->get('year')) {
        $sale_year = $this->session->userdata('sale_year');
      } else {
        $options['year'] = $sale_year;
        // $this->session->set_userdata('sale_year', $sale_year);
      }
      $data['year'] = $sale_year;

      if ($new_year = $this->input->get('new_year')) {
        $options['new_year'] = $new_year;
        bake_cookie('new_year', $new_year);
      } else {
        burn_cookie('new_year');
      }
      $keys = [
        'category_id',
        'subcategory_id',
        'name',
        'genus',
        'variety',
        'species',
        'grower_id',
        'pot_size',
        'flat_size',
        'show-non-reorders',
        'grower_code',
        'received_presale',
        'flat_cost',
        'plant_cost',
        'flat_area',
        'price',
        'tiers',
        'flag',
        'needs_bag',
        'flat_exclude',
      ];

      $this->set_options($options, $keys);
      $data['year'] = $this->input->get('year');
      bake_cookie('sale_year', $data['year']);
      if ($output_format = $this->input->get('output_format')) {
        bake_cookie('output_format', $output_format);
        $data['output_format'] = $output_format;
      } else {
        $data['output_format'] = 'standard';
      }

      if ($is_inventory = $this->input->get('is_inventory')) {
        bake_cookie('is_inventory', $is_inventory);
        $data['is_inventory']            = TRUE;
        $special_options['is_inventory'] = $is_inventory;
      } else {
        $data['is_inventory'] = FALSE;
        burn_cookie('is_inventory');
      }

      if ($is_sellouts = $this->input->get('is_sellouts')) {
        bake_cookie('is_sellouts', $is_sellouts);
        $data['is_sellouts'] = TRUE;

        $special_options['is_sellouts'] = $is_sellouts;
      } else {
        burn_cookie('is_sellouts');
        $data['is_sellouts'] = FALSE;
      }

      if ($is_tracking = $this->input->get('is_tracking')) {
        bake_cookie('is_tracking', $is_tracking);
        $data['is_tracking']            = $is_tracking;
        $special_options['is_tracking'] = $is_tracking;
      } else {
        burn_cookie('is_tracking');
        $data['is_tracking'] = FALSE;
      }

      $sorting['fields'] = [
        'catalog_number',
      ];
      $sorting['direction'] = [
        'ASC',
      ];

      if ($this->input->get('sorting')) {
        $sorting['fields']    = $this->input->get('sorting');
        $sorting['direction'] = $this->input->get('direction');
        bake_cookie('sorting_fields', serialize($sorting['fields']));
        bake_cookie('sorting_direction', serialize($sorting['direction']));
      }

      if ($this->input->get('show_names') == 1) {
        $data['show_names'] = TRUE;
      }

      $data['is_inventory'] = FALSE;
      if ($this->input->get('is_inventory') == 1) {
        $data['is_inventory'] = TRUE;
      }

      $data['is_sellouts'] = FALSE;
      if ($this->input->get('is_sellouts') == 1) {
        $data['is_sellouts'] = TRUE;
      }

      bake_cookie('sorting', implode(',', $sorting['fields']));
      bake_cookie('direction', implode(',', $sorting['direction']));
      if ($output_format == 'crop-failure') {
        $orders = $this->order->get_crop_failures($options, $sorting);
      } else {
        $orders = $this->order->get_totals($sale_year, $options, $sorting);
      }

      foreach ($orders as $order) {
        $order->latest_order = $this->order->is_latest($order->variety_id, $order->year);
        if ($output_format != 'crop-failure') {
          if ($this->session->userdata('user_id') == 1) {
            $order->flat_exclude_button = $this->toggle_button($order->id, 'flat_exclude', $order->flat_exclude);
          } else {
            $label = '';
            extract(get_toggle_text('flat_exclude', $order->flat_exclude));
            $order->flat_exclude_button = $label;
          }
        }
      }
      if ($show_last_only = $this->input->get('show_last_only')) {
        bake_cookie('show_last_only', $show_last_only);
        $options['Hiding Plants with Reorders Next Sale'] = 'Yes';
      }
      if ($this->input->get('show-non-reorders')) {
        foreach ($orders as $order) {
          $order->has_reorder = $this->order->get_for_variety($order->variety_id, $sale_year + 1);
        }
      }
      $title_category = [];
      if (array_key_exists('category_id', $options)) {
        $this->load->model('category_model', 'category');
        $category            = $this->category->get($options['category_id'])->category;
        $options['category'] = $category;
        $title_category[]    = $category;
        unset($options['category_id']);
      }
      if (array_key_exists('subcategory_id', $options)) {
        $this->load->model('subcategory_model', 'subcategory');
        $subcategory            = $this->subcategory->get($options['subcategory_id'])->subcategory;
        $options['subcategory'] = $subcategory;
        $title_category[]       = $subcategory;
        unset($options['subcategory_id']);
      }
      foreach ($options as $key => $value) {
        $where[] = sprintf('`%s` = "%s"', $key, $value);
      }

      $data['options'] = $options;
      $data['orders']  = $orders;

      if (!empty($title_category)) {
        $category = implode(' ', $title_category);
      } else {
        $category = 'All';
      }
      if ($output_format == 'crop-failure') {
        $data['title'] = 'Crop Failure Listing';
      } else {
        $data['title'] = sprintf('List of %s orders for %s', $category, $sale_year);
      }
      if ($this->input->get('export')) {
        $data['export_type'] = 'standard';
        $data['filename']    = str_replace(' ', '_', strtolower($category)) . '_order_export_' . date('Y-m-d-H-i-s') . '.csv';

        if ($export_type = $this->input->get('export_type')) {
          if ($this->input->get('grower_id')) {
            $data['filename'] = $this->input->get('grower_id') . '-export.csv';
          }
          $data['export_type'] = $export_type;
        }
        $this->load->helper('download');
        $this->load->view('order/export', $data);
      } else {
        $data['target']     = 'order/full_list';
        $data['show_names'] = TRUE;
        $this->load->view('page/index', $data);
      }
    } else {
      $this->do_search();
    }
  }
/**
 * //@TODO switch search() with do_search()?
 */
  private function do_search() {
    $this->load->model('menu_model', 'menu');
    $this->load->model('category_model', 'category');
    $this->load->model('subcategory_model', 'subcategory');
    $categories = $this->category->get_pairs();
    $flags      = $this->menu->get_pairs('flag', [
      'field' => 'value',
    ]);
    // Create an array of flags for use in the search view
    $data['flags'] = get_keyed_pairs($flags, [
      'key',
      'value',
    ], TRUE);
    $pot_sizes         = $this->order->get_pot_sizes();
    $data['pot_sizes'] = get_keyed_pairs($pot_sizes, [
      'pot_size',
      'pot_size',
    ], NULL, TRUE);
    $data['categories'] = get_keyed_pairs($categories, [
      'key',
      'value',
    ], TRUE);
    $subcategories         = $this->subcategory->get_pairs();
    $data['subcategories'] = get_keyed_pairs($subcategories, [
      'key',
      'value',
    ], TRUE);
    $output_formats         = $this->menu->get_pairs('orders_format');
    $data['output_formats'] = get_keyed_pairs($output_formats, [
      'key',
      'value',
    ]);
    $data['target'] = 'order/search';
    $data['title']  = 'Searching Orders';
    if ($this->input->get('ajax')) {
      $this->load->view('order/search', $data);
    } else {
      $this->load->view('page/index', $data);
    }
  }

  function show_sort() {
    if ($ajax = $this->input->get('basic_sort')) {
      $data['basic_sort'] = TRUE;
      $this->load->view('order/sort', $data);
    } else {
      /**
       * @todo undefined variable $data needs fix
       */
      $this->load->view('page/index', $data);
    }
  }

  function update_value() {
    $id    = $this->input->post('id');
    $value = urldecode($this->input->post('value'));
    $field = $this->input->post('field');
    if ($field == 'received_presale' && $value == 'f') {
      $value = 0;
    }
    if ($value === 'x') {
      $output = $this->order->clear($id, $field);
    } else {
      $values = [
        $field => $value,
      ];

      $output = $this->order->update($id, $values);

      if ($this->input->post('format') == 'currency') {
        $output = get_as_price($output);
      }
    }
    echo $output;
  }

  /**
   * move the order to a new variety *
   *
   * @param null $id
   */
  function move($id = NULL) {
    if ($this->input->get('start')) {
      $data['order']  = $this->order->get($id);
      $data['target'] = 'order/move';
      $data['title']  = 'Move an order to a new variety';
      if ($this->input->get('ajax')) {
        $this->load->view($data['target'], $data);
      } else {
        $this->load->view('page/index', $data);
      }
    } else {
      $variety_id = $this->input->post('variety_id');
      // @TODO need a way to verify that this is a valid ID first?
      $this->order->update($id, [
        'variety_id' =>
        $variety_id,
      ]);
      redirect('variety/view/$variety_id');
    }
  }

  function catalog_update_selector() {
    $data['categories'] = $this->category->get_all();
    $this->load->view('order/catalog_categories', $data);
  }

  function set_catalog_numbers($year = NULL) {
    if (!$year) {
      $year = $this->session->userdata('sale_year');
    }
    $target_category = '';
    if ($category_id = $this->input->get('category_id')) {
      $categories = (object) [
        'category' => (object) [
          'id' => $category_id,
        ],
      ];
      $target_category = $categories->category->category;
    } else {
      $categories = $this->category->get_all();
    }
    $count = 0;
    foreach ($categories as $category) {
      $orders = $this->order->get_for_catalog($year, $category->id);
      $t      = 1;
      foreach ($orders as $order) {
        $count++;

        $letter = ucfirst(substr($order->category, 0, 1));
        switch ($t) {
        case $t < 10:
          $cat = $letter . '00' . $t;
          break;
        case $t < 100:
          $cat = $letter . '0' . $t;
          break;
        default:
          $cat = $letter . $t;
        }
        $this->order->update($order->id, [
          'catalog_number' => $cat,
        ]);
        $t++;
      }
    }

    $this->session->set_flashdata('notice', sprintf('%s %s orders have had their catalog number updated', $count, $target_category));
    redirect('index');
  }

  function edit_cost() {
    $id            = $this->input->post('id');
    $data['order'] = $this->order->get($id);
    $this->load->view('order/edit_cost', $data);
  }

  function create() {
    $data['variety_id'] = $this->input->get('variety_id');
    $data['order']      = $this->order->get_previous_year($data['variety_id'], get_current_year());
    if (empty($data['order'])) {
      $this->load->model('variety_model', 'variety');
      $order          = new stdClass();
      $order->variety = $this->variety->get($data['variety_id'])->variety;
      $data['order']  = $order;
    }
    if ($this->input->get('reorder')) {
      $data['order']->year = get_current_year();
    }
    $pot_sizes         = $this->order->get_pot_sizes();
    $data['pot_sizes'] = get_keyed_pairs($pot_sizes, [
      'pot_size',
      'pot_size',
    ]);
    $data['action'] = 'insert';
    $data['target'] = 'order/edit';
    $data['title']  = 'Insert New Order';
    if ($this->input->get('ajax') == 1) {
      $this->load->view($data['target'], $data);
    } else {
      $this->load->view('page/index', $data);
    }
  }

  function edit($id) {
    $data['order']      = $this->order->get($id);
    $data['variety_id'] = $data['order']->variety_id;
    $pot_sizes          = $this->order->get_pot_sizes();
    $data['pot_sizes']  = get_keyed_pairs($pot_sizes, [
      'pot_size',
      'pot_size',
    ], NULL, TRUE);
    $data['action'] = 'update';
    $data['target'] = 'order/edit';
    $data['title']  = 'Update Order';
    if ($this->input->get('ajax')) {
      $this->load->view($data['target'], $data);
    } else {
      $this->load->view('page/index', $data);
    }
  }

  function insert() {
    $order_id = $this->order->insert();
    // $variety_id = $this->input->post ( 'variety_id' );
    redirect($this->input->post('redirect_url'));
  }

  function update() {
    $id = $this->input->post('id');
    $this->order->update($id);
    redirect($this->input->post('redirect_url'));
  }

  /**
   * this is one ugly function.
   * It should be more elegant if I were to use the update function, but it
   * isn't working correctly.
   */
  function update_cost() {
    $id         = $this->input->post('id');
    $plant_cost = $this->input->post('plant_cost');
    $flat_cost  = $this->input->post('flat_cost');
    $flat_size  = $this->input->post('flat_size');
    $this->order->update($id, [
      'flat_size'  => $flat_size,
      'flat_cost'  => $flat_cost,
      'plant_cost' => $plant_cost,
    ]);
    redirect($this->input->post('redirect_url'));
  }

  function delete() {
    if ($id = $this->input->post('id')) {
      print $this->order->delete($id);
    }
  }

  function get_pot_sizes() {
    $pot_sizes = $this->order->get_pot_sizes();
    foreach ($pot_sizes as $pot_size) {
      $output[] = $pot_size->pot_size;
    }
    print json_encode($output);
  }

  function batch_update() {
    if (IS_ADMIN) {
      if ($this->input->post('action') == 'edit') {
        $data['ids']       = $this->input->post('ids');
        $pot_sizes         = $this->order->get_pot_sizes();
        $data['pot_sizes'] = get_keyed_pairs($pot_sizes, [
          'pot_size',
          'pot_size',
        ]);
        $this->load->view('order/batch_update', $data);
      } elseif ($this->input->post('action') == 'update') {
        $target = $this->input->post('target');
        $ids    = $this->input->post('ids');
        $fields = [
          'year',
          'crop_failure',
          'flat_size',
          'flat_cost',
          'plant_cost',
          'count_presale',
          'count_friday',
          'count_saturday',
          'count_midsale',
          'pot_size',
          'price',
          'flat_area',
          'tiers',
          'grower_code',
          'flat_exclude',
        ];
        $values = [];
        foreach ($fields as $field) {
          if ($this->input->post($field)) {
            $my_value = urldecode($this->input->post($field));
            switch ($field) {
            case 'flat_cost':
            case 'plant_cost':
            case 'price':
            case 'flat_area':
            case 'tiers':
              $values[$field] = preg_replace('/[^0-9,.]/', '', $my_value);
              break;
            case 'flat_exclude':
              $values[$field] = $my_value == 'yes' ? 1 : '0';
              break;
            default:
              $values[$field] = $my_value;
            }
          }
        }
        if ($values) {
          $result = $this->order->batch_update($ids, $values);
        } else {
          $result = FALSE;
        }
        if ($result) {
          $ids = str_replace(',', ', ', $ids);
          $this->session->set_flashdata('notice', 'The following orders have been updated:' . $ids);
        } else {
          $this->session->set_flashdata('notice', 'No changes were made');
        }
        $order_search = cookie('order_search');
        redirect('order/search?' . $order_search);
      }
    }
  }

  function flat_total_exclusions() {
    return $this->order->get_flat_total_exclusions();
  }

  private function toggle_button($id, string $field, $value) {
    return toggle_button('order', $id, $field, $value);
  }

  function toggle() {
    $value = $this->input->post('value') === 1 ? 0 : 1;
    return toggle($this, $this->order, $value);
  }

  function flat_total_exclude(): bool {
    $pot_size         = $this->input->get('pot_size');
    $online_pot_sizes = [
      'bareroot',
      'bulb',
      'tuber',
      'seed',
    ];
    $ajax = $this->input->get('ajax');
    foreach ($online_pot_sizes as $size) {
      if (stristr($pot_size, $size)) {
        if ($ajax) {
          print TRUE;
        }

        return TRUE;
      }
    }
    if ($ajax) {
      print FALSE;
    }
    return FALSE;

  }

}
