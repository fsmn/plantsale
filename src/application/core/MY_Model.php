<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class MY_Model extends CI_Model
	{

		function __construct ()
		{
			parent::__construct ();
		}

		function _get_value ( $db, $id, $field )
		{
			$this->db->where ( "id", $id );
			$this->db->select ( $field );
			$this->db->from ( $db );
			$output = $this->db->get ()->row ();
			if ($output) {
				return $output->$field;
			}
			else {
				return FALSE;
			}
		}

		function _get ( $db, $id )
		{
			$this->db->from ( $db );
			$this->db->where ( "id", $id );
			$result = $this->db->get ()->row ();
			return $result;
		}

		function _insert ( $db )
		{
			if (IS_EDITOR) {
				$this->db->insert ( $db, $this );
				$id = $this->db->insert_id ();
				$this->_log();
				return $id;
			}
			else {
				return FALSE;
			}
		}

	/**
	 *
	 * @param string $db
	 * @param integer $id
	 * @param array $values
	 * @param string $override
	 * @return bool
	 */
		function _update ( $db, $id, $values, $override = FALSE )
		{
			$original_values = $values;
			if (IS_EDITOR || $override) {
				$this->db->where ( "id", $id );
				if (empty ( $values )) {
					$this->prepare_variables ();
					$this->db->update ( $db, $this );
				}
				else {
					$values ['rec_modifier'] = mysql_timestamp ();
					$values ['rec_modifier'] = $this->session->userdata ( 'user_id' );
					$this->db->update ( $db, $values );
					$this->_log();
					if (count ( $original_values ) == 1) {
						$keys = array_keys ( $original_values );
						return $this->get_value ( $id, $keys [0] );
					}
				}
			}
			else {
				return FALSE;
			}
		}

		function _delete ( $db, $id )
		{
			if (IS_EDITOR) {
				$this->db->delete ( $db, array (
						'id' => $id
				) );
			}
			else {
				return FALSE;
			}
		}

		function _log ( $element = 'alert' )
		{
			$last_query = $this->db->last_query ();
			$this->load->model ( 'user_preferences_model', 'user_prefs' );
			
			if ($this->user_prefs->get ( $this->ion_auth->user ()->row ()->id, 'dev' ) == 1) {
				$this->session->set_flashdata ( $element, $last_query );
			}
		}

		function _list_fields(string $table, array $ignore_fields = []): array {
			$base_ignore_fields =  ['rec_created','rec_creator','rec_modifier','rec_modified'];
			$ignore_fields = array_merge($ignore_fields, $base_ignore_fields);
			$fields = $this->db->list_fields($table);
			$output = [];
			foreach($fields as $field){
				if(!in_array($field, $ignore_fields)){
					$output[] = $field;
				}
			}
			return $output;
		}

	/**
	 * Group results by a given field.
	 * @param $results
	 * @param $field
	 *
	 * @return array
	 */
		function group_by($results, $field): array {
			$output = [];
			foreach($results as $item){
				$output[$item->{$field}] = $item;
			}
			return $output;
		}
	}
