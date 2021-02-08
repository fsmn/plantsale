<?php defined('BASEPATH') OR exit('No direct script access allowed');

// preference.php Chris Dart Dec 10, 2014 4:33:31 PM chrisdart@cerebratorium.com

class Preference extends MY_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Preferences_model','preferences');
		$this->load->model('User_preferences_model','user_preferences');
	}
	function index(){
		redirect('preference/edit/' . $this->ion_auth->get_user_id());
	}

	function edit($user_id){
		if($this->ion_auth->is_admin() || $user_id == $this->ion_auth->get_user_id()) {
			$data = [
				'user_id' => $user_id,
				'action' => 'update',
				'preferences' => $this->user_preferences->get_all($user_id),
				'title' => 'Edit Preferences',
				'target' => 'preference/edit',
			];
			$this->load->view('page/index', $data);
		}
		else {
			$this->session->set_flashdata('alert','You can only edit your own user preferences');
			redirect('/');
		}
	}

	function update(){

		$user_id = $this->input->post('user_id');
		if($this->ion_auth->is_admin() || $user_id == $this->ion_auth->get_user_id()) {
			$preference_list = $this->user_preferences->get_all($user_id);
			foreach ($preference_list as $preference) {
				$this->user_preferences->update($user_id, $preference->id, $this->input->post($preference->id));
			}
			redirect('preference/edit/' . $user_id);
		}
		else {
			$this->session->set_flashdata('alert','You can only edit your own user preferences');
			redirect('/');
		}
	}
}
