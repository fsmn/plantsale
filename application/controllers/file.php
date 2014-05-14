<?php

class File extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('file_model');
		$this->load->helper('general_helper');
		$this->load->helper('file');
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function view_file()
	{
		//if($this->input->post('kFile')){
		$kFile = $this->input->post('kFile');
		$data['file'] = $this->file_model->fetch_file($kFile);
		$this->load->view('file/view', $data);
		//}
	}

	function new_file()
	{
		if( $this->input->post('kAsset') ){
			$data['kAsset'] = $this->input->post('kAsset');
			$data['error'] = '';
			$data['file'] = null;
			$this->load->view('upload_form', $data);
		}

	}

	function edit_file()
	{
		if ($this->input->post('kFile')){
			$kFile = $this->input->post('kFile');
			$data['kFile'] = $kFile;
			$file = $this->file_model->fetch_file($kFile);
			$data['file'] = $file;
			$data['error'] = '';
			$data['kAsset'] = $file->kAsset;
			$this->load->view('file/edit', $data);
		}
	}

	function delete_file()
	{
		if ($this->input->post('kFile')){
			$kFile = $this->input->post('kFile');
			$this->file_model->delete_file($kFile);
		}
	}


	function attach_file()
	{
		$config['upload_path'] = site_url("uploads");
		$config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xlsx|xls|rtf';
		$config['max_size'] = '1024';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);
		print $this->upload->do_upload();
		if ( ! $this->upload->do_upload()){
			$error = array('error' => $this->upload->display_errors());

			return $error;
		} else {
			$fileData = $this->upload->data();
			print_r($fileData);
			$data['fileName'] = $fileData['file_name'];
			$data['fileDescription'] = $this->input->post('fileDescription');
			$kAsset = $this->input->post('kAsset');
			$kFile = $this->file_model->insert_file($kAsset, $data);

		}
		$this->load->view("file/success");
	}

}
?>