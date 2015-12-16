<?php

class Iva_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_iva($id = FALSE){
		if ($id === FALSE){
			$query = $this->db->get('iva');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('iva', array('id' => $id));
		return $query->row_array();
	}
}

?>