<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class MY_Controller extends CI_Controller
	{

		function __construct ()
		{
			parent::__construct ();
			if (! $this->ion_auth->logged_in ()) {
				define ( "IS_EDITOR", 0 );
				define ( "IS_ADMIN", 0 );
				define ( "IS_INVENTORY", 0 );
				$uri = $_SERVER ["REQUEST_URI"];
				if ($uri != "/auth" && ! strstr ( $uri, "ajax" )) {
					bake_cookie ( "uri", $uri );
				}
				redirect ( "auth/login" );
			}
			else {
				$this->load->model ( "ion_auth_model" );
				define ( "IS_EDITOR", $this->ion_auth->in_group ( array (
						1,
						2 
				) ) );
				define ( "IS_ADMIN", $this->ion_auth->in_group ( array (
						1 
				) ) );
				define ( "IS_INVENTORY", $this->ion_auth->in_group ( array (
						4 
				) ) );
				bake_cookie("sale_year", $this->get_sale_year());
				$this->session->set_userdata('sale_year', $this->get_sale_year());
			}
		}

		function set_option ( &$options, $key )
		{
			if ($value = urldecode ( $this->input->get ( $key ) )) {
				bake_cookie ( $key, $value );
				$options [$key] = $value;
			}
			else {
				burn_cookie ( $key );
			}
		}

		function set_options ( &$options, $keys = array() )
		{
			foreach ( $keys as $key ) {
				$this->set_option ( $options, $key );
			}
		}

		function _log ( $string, $target = "notice" )
		{
			$this->session->set_flashdata ( $target, $string );
		}

		function get_sale_year(){
			$this->load->model('Settings_model','settings');
			$sale_year = $this->settings->get('sale_year');
			if(!$sale_year){
				$sale_year = $this->settings->set(['name'=>'sale_year','label'=>'Sale Year','value'=>get_current_year()]);
			}
			return $sale_year->value;
		}

		function set_sale_year($year){
			$this->load->model('Settings_model','settings');
			$this->settings->set('sale_year', $year);
		}
	}
