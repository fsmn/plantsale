<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Help extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('help_model');
	}

	/**
	 * shows help dialog in tandem with jQuery and css code
	 */
	function get()
	{
		$topic = $this->input->get('topic');
		$subtopic = $this->input->get('subtopic');
		print $this->help_model->get($topic, $subtopic);
	}
}
