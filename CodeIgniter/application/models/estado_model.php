<?php

class Estado_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_estado($id = FALSE){
		if ($id === FALSE){
			$query = $this->db->get('estado');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('estado', array('id' => $id));
		return $query->row_array();
	}
}

?>