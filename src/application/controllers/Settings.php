<?php


class Settings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Settings_model','settings');

	}

	function update($key){
		$values = $this->input->post($key);
		$this->settings->update($key, $values);
		redirect();
	}


}
