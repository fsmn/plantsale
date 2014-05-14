<?php

class File_model extends CI_Model
{
	var $kAsset = '';
	var $fileName = '';
	var $fileDescription = '';

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{
		if($this->input->post('kAsset')){
			$this->kAsset = $this->input->post('kAsset');
		}
			
		if($this->input->post('fileName')){
			$this->fileName = $this->input->post('fileName');
		}

		if($this->input->post('fileDescription')){
			$this->fileDescription = $this->input->post('fileDescription');
		}
	}

	function insert_file($kAsset, $data)
	{
		$this->fileName = $data['fileName'];
		$this->fileDescription = $data['fileDescription'];
		$this->kAsset = $kAsset;
		$this->db->insert('file', $this);
		return $this->db->insert_id();
	}

	function fetch_file($kFile)
	{
		$this->db->where('kFile', $kFile);
		$this->db->from('file');
		$query = $this->db->get();
		$output = $query->result();
		return $output[0];
	}
	
	
   function fetch_files($kAsset)
    {
        $this->db->where('kAsset', $kAsset);
        $this->db->from('file');
        $this->db->order_by('fileName');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    
    function delete_file($kFile)
    {
    	$file = $this->fetch_file($kFile);
    	$file_path = dirname($_SERVER['SCRIPT_FILENAME']) . "/uploads/" . $file->fileName;
    	//fopen($file_path, 'a');
    	unlink($file_path);
    	$id_array = array('kFile' => $kFile);
    	$this->db->delete('file', $id_array);
    }
    

	function fetch_file_values($fields, $fileFields = null){
		$this->db->from('file');
		$this->db->distinct();

		if(is_array($fields)){
			foreach($fields as $field){
				$this->db->select($field);
			}
		}else{
			$this->db->select($fields);
		}

		if($fileFields){
			if(is_array($fileFields)){
				foreach($fileFields as $file){
					$this->db->order_by($file);
				}
			}else{
				$this->db->order_by($fileFields);
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}