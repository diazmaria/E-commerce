<?php


class Venta_model extends CI_Model {

	public function __construct() {
		parent::__construct();	
		$this->load->database();
	}

	public function new_venta($user_id) {
		$venta = array(
						'total' => 0,
						'fk_estado' => 1,
						'fk_cliente' => $user_id
						);

		$this->db->insert('venta', $venta);
		return $this->db->insert_id();
	}

	public function new_linea_venta($datos) {
		$linea = array(
						'id_orden' => $datos['orden_id'],
						'cantidad' => $datos['cant_producto'],
						'precio' => $datos['precio_producto'],
						'fk_venta' => $datos['fk_venta'],
						'fk_producto' => $datos['id_producto']
						);

		$this->db->insert('linea_venta', $linea);
		return $this->db->insert_id();
	}

	public function actualizar_venta($id, $datos) {
		$this->db->where('id',$id );
		$this->db->update('venta', $datos);
	}

	public function ultima_id_venta() {
		$this->db->select('MAX(id) as max');
		$this->db->from('venta');
		$query = $this->db->get();
		$row = $query->row_array();
		return $row['max'];
	}

	public function get_ventas($user_id, $venta_id = FALSE) {
		if ($venta_id === FALSE) {
			$consulta = $this->db->get_where('venta', array('fk_cliente' => $user_id));
			return $consulta->result_array();
		} else {
			$consulta = $this->db->get_where('venta', array('id' => $venta_id));
			return $query->row_array();
		}
	}

	public function get_lineas_venta($id_venta) {
		$consulta = $this->db->get_where('linea_venta', array('fk_venta' => $id_venta));
		return $consulta->result_array();
	}
}
?>