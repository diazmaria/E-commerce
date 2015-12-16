<?php

class Catalogo_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->library('session');
	}
	
	public function get_catalogo($id = FALSE){
		if ($id === FALSE){
			$query = $this->db->get('producto');
			return $query->result_array();
		} else {
			$this->db->select('*');
			$this->db->from('producto');
			$this->db->where('producto.id', $id);
			$query = $this->db->get();
			//$query = $this->db->get_where('producto', array('id' => $id));
			return $query->row_array();			
			
		}

	}
	
	public function join_catalogo_iva($id = FALSE){
		if ($id === FALSE){ //Devuelve todos los productos si no envia ID
			$this->db->select('producto.id AS id_producto, producto.nombre AS nombre_producto, producto.descripcion AS descripcion_producto, producto.precio_base AS precio_producto, producto.fk_categoria AS fk_categoria_producto, producto.stock AS stock_producto, producto.fk_iva AS fk_iva_producto, producto.fk_vendedor AS fk_vendedor_producto, iva.id AS id_iva, iva.descripcion AS descripcion_iva, iva.valor AS valor_iva ');
			$this->db->from('producto', 'iva');
			$this->db->where('producto.stock >', 0);
			$this->db->join('iva', 'iva.id = producto.fk_iva');
			$this->db->order_by("producto.nombre"," asc"); 
			//$this->db->order_by("producto.stock desc, producto.nombre asc"); 
			$query = $this->db->get();
			return $query->result_array();
		}
		
		$this->db->select('producto.id AS id_producto, producto.nombre AS nombre_producto, producto.descripcion AS descripcion_producto, producto.precio_base AS precio_producto, producto.fk_categoria AS fk_categoria_producto, producto.stock AS stock_producto, producto.fk_iva AS fk_iva_producto, producto.fk_vendedor AS fk_vendedor_producto, iva.id AS id_iva, iva.descripcion AS descripcion_iva, iva.valor AS valor_iva ');
		$this->db->from('producto', 'iva');
		$this->db->where('producto.id', $id);
		$this->db->join('iva', 'iva.id = producto.fk_iva');
		
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function set_catalogo(){
		$this->load->helper('url');
		$this->load->library('image_lib');
		
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'descripcion' => $this->input->post('descripcion'),
			'fk_categoria' => $this->input->post('categoria'),
			'stock' => $this->input->post('stock'),
			'precio_base' => $this->input->post('precio_base'),
			'fk_iva' => $this->input->post('iva'),
			'fk_vendedor' => 1
		);
		return $this->db->insert('producto', $data);
	}
	
	public function update_catalogo($id){
		$this->load->helper('url');
		$this->load->library('image_lib');
		
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'descripcion' => $this->input->post('descripcion'),
			'fk_categoria' => $this->input->post('categoria'),
			'stock' => $this->input->post('stock'),
			'precio_base' => $this->input->post('precio_base'),
			'fk_iva' => $this->input->post('iva')
		);
		$this->db->where('id',$id );
		$this->db->update('producto', $data); 
	}
	
	
	public function lastID_catalogo(){
		return $this->db->insert_id();
	}
	
	public function get_filas(){
		return $this->db->count_all('producto');
	}
	
	public function get_filas_disponibles($busqueda = FALSE){
		
		if($busqueda === FALSE){
			$this->db->select('*');
			$this->db->from('producto');
			$this->db->where('producto.stock >', 0);
			return $this->db->count_all_results();
		} else {
			$this->db->select('*');
			$this->db->from('producto');
			$this->db->like('producto.nombre', $busqueda,'both');
			
			$this->db->or_like('producto.descripcion', $busqueda,'both');
			
			return $this->db->count_all_results();
		}
	}
	public function get_filas_disponibles_categoria($busqueda = FALSE){
		
		if($busqueda === FALSE){
			$this->db->select('*');
			$this->db->from('producto');
			$this->db->where('producto.stock >', 0);
			return $this->db->count_all_results();
		} else {
			$this->db->select('*');
			$this->db->from('producto');
			$this->db->where('producto.fk_categoria', $busqueda);
			$this->db->where('producto.stock >', 0);
			
			return $this->db->count_all_results();
		}
	}
	
	
	public function productosPorCategoria($numPorPagina, $segmento, $categoria = FALSE){
		if($categoria === FALSE){
			$this->db->select('producto.id AS id_producto, producto.nombre AS nombre_producto, producto.descripcion AS descripcion_producto, producto.precio_base AS precio_producto, producto.fk_categoria AS fk_categoria_producto, producto.stock AS stock_producto, producto.fk_iva AS fk_iva_producto, producto.fk_vendedor AS fk_vendedor_producto, iva.id AS id_iva, iva.descripcion AS descripcion_iva, iva.valor AS valor_iva ');
			$this->db->from('producto', 'iva');
			$this->db->where('producto.stock >', 0);
			$this->db->limit($numPorPagina, $segmento);
			$this->db->order_by("producto.nombre"," asc");
			$this->db->join('iva', 'iva.id = producto.fk_iva');
			
			$this->db->limit($numPorPagina, $segmento);
			$query = $this->db->get();
			return $query->result_array();
		} else {
			$this->db->select('producto.id AS id_producto, producto.nombre AS nombre_producto, producto.descripcion AS descripcion_producto, producto.precio_base AS precio_producto, producto.fk_categoria AS fk_categoria_producto, producto.stock AS stock_producto, producto.fk_iva AS fk_iva_producto, producto.fk_vendedor AS fk_vendedor_producto, iva.id AS id_iva, iva.descripcion AS descripcion_iva, iva.valor AS valor_iva ');
			$this->db->from('producto', 'iva');
			$this->db->where('producto.fk_categoria =', $categoria);
			
			$this->db->where('producto.stock >', 0);
			$this->db->order_by("producto.nombre"," asc");
			$this->db->join('iva', 'iva.id = producto.fk_iva');
			
			$this->db->limit($numPorPagina, $segmento);
			
			//*****//
			//echo $this->db->last_query();
			$query = $this->db->get();
			return $query->result_array();
			//echo $this->db->count_all_results();
		}
		
	}
	
	public function catalogoPorPagina($numPorPagina, $segmento, $busqueda = FALSE){
		if($busqueda === FALSE){
			$this->db->select('producto.id AS id_producto, producto.nombre AS nombre_producto, producto.descripcion AS descripcion_producto, producto.precio_base AS precio_producto, producto.fk_categoria AS fk_categoria_producto, producto.stock AS stock_producto, producto.fk_iva AS fk_iva_producto, producto.fk_vendedor AS fk_vendedor_producto, iva.id AS id_iva, iva.descripcion AS descripcion_iva, iva.valor AS valor_iva ');
			$this->db->from('producto', 'iva');
			$this->db->where('producto.stock >', 0);
			$this->db->limit($numPorPagina, $segmento);
			$this->db->order_by("producto.nombre"," asc");
			$this->db->join('iva', 'iva.id = producto.fk_iva');
			
			$query = $this->db->get();
			return $query->result_array();
		} else {
			$this->db->select('producto.id AS id_producto, producto.nombre AS nombre_producto, producto.descripcion AS descripcion_producto, producto.precio_base AS precio_producto, producto.fk_categoria AS fk_categoria_producto, producto.stock AS stock_producto, producto.fk_iva AS fk_iva_producto, producto.fk_vendedor AS fk_vendedor_producto, iva.id AS id_iva, iva.descripcion AS descripcion_iva, iva.valor AS valor_iva ');
			$this->db->from('producto', 'iva');
			$this->db->like('producto.nombre', $busqueda,'both');
			$this->db->or_like('producto.descripcion', $busqueda,'both');
			$this->db->join('iva', 'iva.id = producto.fk_iva');
			$this->db->order_by("producto.nombre"," asc");
			$this->db->limit($numPorPagina, $segmento);
			
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function suficiente_stock($id, $cantidad = FALSE) {
		$this->db->select('producto.stock');
		$this->db->from('producto');
		$this->db->where('producto.id =', $id);
		$result = $this->db->get();
		$row = $result->row_array();
		//conocer el stock de un producto
		if ($cantidad === FALSE) {
			return $row['stock'];
		//conocer si hay suficiente stock de un artículo dado (recibe $cantidad)
		} else {
			return $row['stock'] >= $cantidad;
		}
	}

	public function decrementar_stock($id, $cant) {
		//llamando a esta función obtengo el stock actual
		$stock = $this->suficiente_stock($id) - $cant;
		//ahora $stock contiene la nueva cantidad para actualizar
		$linea = array('stock' => $stock);
		$this->db->where('id',$id );
		$this->db->update('producto', $linea);
	}

}

?>