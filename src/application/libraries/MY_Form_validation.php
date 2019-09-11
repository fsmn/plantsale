<?php

class MY_Form_validation extends CI_Form_validation{
	
	function __construct(){
		parent::__construct();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is Unique Email
	 *
	 * Check if the input field doesn't already exist
	 * in the specified database field with a record other than the current record ID submitted in the table
	 *
	 * @param	string	$str
	 * @param	string	$field
	 * @return	bool
	 */
	public function is_unique_to_row($str, $field)
	{
	
		sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
		$output = isset($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($table, array($field => $str,"id !="=>$id))->num_rows() === 0)
			: FALSE;
		
		return $output;
		
	}
}