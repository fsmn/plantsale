<?php


class Update_model extends MY_Model {


	function update_exists($id){
		$this->db->from('update_tracker');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	function update($id, $query){
		$this->install_tracker();
		if(!$this->update_exists($id)) {
			$this->db->query($query);
			$this->db->insert('update_tracker', ['id' => $id]);
			return sprintf('Database update # ' . $id . ' completed successfully');
		}
		return FALSE;
	}

	private function install_tracker() {
		if(!$this->db->table_exists('update_tracker')) {
			$this->db->query('CREATE TABLE IF NOT EXISTS `update_tracker` (
  `id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;');
		}
	}

}
