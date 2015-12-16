<?php

class Categoria_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_categoria($id = FALSE){
		if ($id === FALSE){
			$query = $this->db->get('categoria');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('categoria', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_filas_disponibles($id = FALSE){
		if ($id === FALSE){
			$this->db->select('*');
			$this->db->from('categoria');
			return $this->db->count_all_results();
		} else {
			$this->db->select('*');
			$this->db->from('categoria');
			$this->db->where('id', $id);
			return $this->db->count_all_results();
		}
		
	}
	
}

?>