<?php

class Carrito_control extends CI_Controller {


public function __construct() {

		parent::__construct();
		$this->load->database();
		
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->library('table');

		$this->load->model('catalogo_model');
		$this->load->model('iva_model');
		$this->load->model('categoria_model');

		$this->load->helper('url');
	}

	public function index() {
		$data = array();
		$data['title'] = 'Carrito de la compra.';
		//******//
		//$data['menuSideBar'] = $this->categoria_model->get_categoria();
		//******//
		if(!$this->session->userdata('usuario') && !$this->session->userdata('vendedor')) {
			$data['mensaje'] = 'Necesitas ser usuario registrado para poder gestionar el carrito.';
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/banner_carrito_vista', $data);
			$this->load->view('templates/footer');
		
		//En este ELSE se muestra la tabla del carrito
		} else {
			if($this->session->userdata('usuario')){
				$data['usuario'] = $this->session->userdata('usuario');
				$data['mensaje'] = 'Gestiona tu carrito. Envía tu pedido cuando esté todo listo.';
			} else if($this->session->userdata('vendedor')){
				$data['vendedor'] = $this->session->userdata('vendedor');
				$data['mensaje'] = 'Recuerda que has iniciado sesión como vendedor. No como cliente.';
			}
			//Puede que el carrito esté vacío. Se controla en la VISTA.
			$data['productos'] = $this->cart->contents();

			//var_dump ($this->cart->contents());
			//Producto añadido
			
			$ok = $this->session->userdata('ok');
			$this->session->unset_userdata('ok');

			if ($ok) {
				$data['agregado'] = $ok;
			}

			//Producto eliminado
			$off = $this->session->userdata('off');
			$this->session->unset_userdata('off');

			if ($off) {
				$data['eliminado'] = $off;
			}

			//Carrito comprobado
			$todo_ok = $this->session->userdata('todo_ok');
			$this->session->unset_userdata('todo_ok');

			if ($todo_ok) {
				$data['todo_ok'] = $todo_ok;
			}

			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/banner_carrito_vista', $data);
			$this->load->view('templates/open_container');
			$this->load->view('templates/carrito_vista', $data);
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');
			
		}
	}

	public function anhadir($id_producto) {
		$data = null;
		$cantidad = null;
		
		$producto = $this->catalogo_model->get_catalogo($id_producto);
		$cantidad = 1;

		$carrito_actual = $this->cart->contents();
		foreach ($carrito_actual as $articulo) {
			if ($articulo['id'] == $producto['id']) {
				$cantidad+= $articulo['qty'];
			}			
		}
		$data = array(
					   'id'      => $producto['id'],
                       'qty'     => $cantidad,
                       'price'   => $producto['precio_base'],
                       'name'    => $producto['nombre'],
                       'options' => array(
                       						'Cat.' => $producto['fk_categoria'],
                       						'IVA' => $producto['fk_iva'],
                       						'Vend.' => $producto['fk_vendedor']
                       						)
					);
		$this->cart->insert($data);
		//var_dump($this->cart->contents());
		//$this->session->set_userdata('ok', 'El producto ha sido agregado correctamente.');
		$this->index();
	}

	public function vaciar() {
		$this->cart->destroy();
		$this->index();
	}

	public function eliminar($row_id) {
		$data = array(
						'rowid' => $row_id,
						'qty' => 0
						);
		$this->cart->update($data);
		$this->session->set_userdata('off', 'El producto ha sido eliminado correctamente.');
		$this->index();
	}

	public function mas1($row_id, $cant) {
		$data = array(
						'rowid' => $row_id,
						'qty' => $cant+1
						);
		$this->cart->update($data);
		$this->session->set_userdata('ok', 'El producto ha sido agregado correctamente.');
		$this->index();
	}

	public function menos1($row_id, $cant) {
		$data = array(
						'rowid' => $row_id,
						'qty' => $cant-1
						);
		$this->cart->update($data);
		$this->session->set_userdata('off', 'El producto ha sido eliminado correctamente.');
		$this->index();
	}

	public function comprobar() {
		$carrito = $this->cart->contents();
		$todo_ok = TRUE;
		$errores = array();

		foreach ($carrito as $item) {
			if (!$this->catalogo_model->suficiente_stock($item['id'],$item['qty'])) {
				$todo_ok = FALSE;
				$errores[] = array ("tit" => $item['name'], "sto" => $this->catalogo_model->suficiente_stock($item['id']));
			}
		} 
		if ($todo_ok) {
			$this->session->set_userdata('todo_ok', '<h4>Pedido comprobado :)</h4><br>Nos complace decirte que tenemos todo lo que necesitas. Envía el pedido cuando lo desees.');
			$this->index();
		} else {
			$data = array();
			$data['title'] = "Carrito de la compra.";

			//Esta parte es solo por seguridad (por si las moscas)
			if($this->session->userdata('usuario')){
				$data['usuario'] = $this->session->userdata('usuario');
				$data['mensaje'] = 'Gestiona tu carrito. Envía tu pedido cuando esté todo listo.';
			} else if($this->session->userdata('vendedor')){
				$data['vendedor'] = $this->session->userdata('vendedor');
				$data['mensaje'] = 'Recuerda que has iniciado sesión como vendedor. No como cliente.';
			}
			//Puede que el carrito esté vacío. Se controla en la VISTA.
			$data['productos'] = $this->cart->contents();
			$data['problema'] = '<h4>Problemas de stock :(</h4><br>Puede que se te haya ido un poco la olla pidiendo cosas pero no te preocupes. Todo tiene solución.<br>';
			$data['stocks'] = $errores;
	
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/banner_carrito_vista', $data);
			$this->load->view('templates/open_container');
			$this->load->view('templates/carrito_vista', $data);
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');
		}
		
	}

	public function arreglar() {
		$carrito = $this->cart->contents();
		$todo_ok = TRUE;
		$errores = array();

		foreach ($carrito as $item) {
			if (!$this->catalogo_model->suficiente_stock($item['id'],$item['qty'])) {
				$todo_ok = FALSE;
				$errores[] = array ("rowid" => $item['rowid'], "sto" => $this->catalogo_model->suficiente_stock($item['id']));
			}
		} 
		if ($todo_ok) {
			$this->session->set_userdata('todo_ok', '<h4>Pedido comprobado :)</h4><br>Nos complace decirte que tenemos todo lo que necesitas. Envía el pedido cuando lo desees.');
			$this->index();
		} else {
			foreach ($errores as $error) {
				$data = array(
						'rowid' => $error['rowid'],
						'qty' => $error['sto']
						);
				$this->cart->update($data);
			}
			$this->comprobar();
		}
	}

}

?>