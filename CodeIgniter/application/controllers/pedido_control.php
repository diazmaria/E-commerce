<?php

class Pedido_control extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->library('table');

		$this->load->helper('url');

		$this->load->model('catalogo_model');
		$this->load->model('venta_model');
		$this->load->model('usuarios_model');
		$this->load->model('iva_model');
		$this->load->model('estado_model');

		
	}

	public function index() {
		$this->you_shall_not_pass();
		if (!$this->session->userdata('nop')) {
			$data['title'] = 'Mis pedidos.';
			$data['mensaje'] = 'Aquí se mostrarán los pedidos del cliente y su estado.';

			//Se obtiene el nombre del usuario.
			$user = $this->session->userdata('usuario');
			//Se almacena en data el usuario para mostrar la navbar correspondiente a usuario registrado
			$data['usuario'] = $user;
			//obtener el id del usuario que tiene la sesión iniciada
			$user_id = $this->usuarios_model->get_usuario_id($user);
			//Habrá que consultar los pedidos de este usuario
			$data['ventas'] = $this->venta_model->get_ventas($user_id);

			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/banner', $data);
			$this->load->view('templates/open_container');
			$this->load->view('templates/pedido_vista', $data);
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');
		}
		$this->session->unset_userdata('nop');
	}

	public function enviar_pedido() {
		$this->you_shall_not_pass();
		if (!$this->session->userdata('nop')) {
		$data['usuario'] = $this->session->userdata('usuario');
		//Solo se hace algo si el carrito contiene artículos.
			if ($this->cart->contents()) {

				$user = $this->session->userdata('usuario');
				//obtener el id del usuario que tiene la sesión iniciada
				$user_id = $this->usuarios_model->get_usuario_id($user);
				//crear una nueva venta pasándole la id del usuario y quedarnos con el $id_venta
				$id_venta = $this->venta_model->new_venta($user_id);
				//Se obtiene el carrito de la compra
				$carrito = $this->cart->contents();
				//Se recorre el carrito
				$i = 1;
				$total_venta = 0;
				foreach ($carrito as $item) {
					//primero tomamos el IVA del producto mirando las opciones del item del carrito
					$opciones = $this->cart->product_options($item['rowid']);
					$iva = $this->iva_model->get_iva($opciones['IVA']);

					$linea['id_producto'] = $item['id'];
					$linea['cant_producto'] = $item['qty'];
					$linea['precio_producto'] = $item['price']*(1+($iva['valor']/100));
					$linea['orden_id'] = $i;
					$linea['fk_venta'] = $id_venta;

					//decrementar el stock del producto
					$this->catalogo_model->decrementar_stock($item['id'], $item['qty']);
					//crear linea de venta
					$this->venta_model->new_linea_venta($linea);
					//ahora el cálculo para ir acumulando en el total
					$total_venta+= $item['price']*(1+($iva['valor']/100));

					++$i;
			}
				//Vaciar el carrito!!
				$this->cart->destroy();
				//Al terminar el carrito se actualiza el total de la venta.
				$datos = array( 'total' => $total_venta);
				$this->venta_model->actualizar_venta($id_venta, $datos);
				//controlar en session que se ha enviado un pedido.
				$this->session->set_userdata('pedido',$id_venta);

				}

				$data['title'] = 'Pedido enviado.';
				$data['mensaje'] = 'Tu pedido ha sido enviado satisfactoriamente.'.
				'<br> Visita la sección <a href="http://localhost/CodeIgniter/index.php/pedido_control">pedidos</a> para gestionar tus pedidos.'.
				' O visita <a href="http://localhost/CodeIgniter/index.php/catalogo">el catálogo</a> para realizar un nuevo pedido';
				//'<br>'. $this->session->userdata('pedido') . '<br>' . $this->venta_model->ultima_id_venta();


				$this->load->view('templates/header', $data);
				$this->load->view('templates/navbar', $data);
				$this->load->view('templates/banner', $data);
				$this->load->view('templates/open_container');
				$this->load->view('templates/close_container');
				$this->load->view('templates/footer');
		}
	}

	private function you_shall_not_pass() {
		$data = null;
		$data['title'] = 'Envío de pedido.';
		
		if ($this->session->userdata('vendedor')) {
			$data['vendedor'] = $this->session->userdata('vendedor');
			$data['mensaje'] = 'La broma ha llegado demasiado lejos. Eres un vendedor.';
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/banner_carrito_vista', $data);
			$this->load->view('templates/footer');

			$this->session->set_userdata('nop','nop');

		} else if ($this->session->userdata('usuario')) {
			//Prosigan...
			
		} else {
			$data['mensaje'] = 'Necesitas ser usuario registrado para poder gestionar un pedido.';
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar', $data);
			$this->load->view('templates/banner_carrito_vista', $data);
			$this->load->view('templates/footer');

			$this->session->set_userdata('nop','nop');
		}
	}

	public function detalles($id_venta) {
		if($this->session->userdata('usuario')){
			$data['usuario'] = $this->session->userdata('usuario');
		} else if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
		}
		$data['title'] = 'Detalles del pedido.';
		$data['mensaje'] = 'He aquí los artículos del pedido Num. '.$id_venta;
		
		$data['lineas'] = $this->venta_model->get_lineas_venta($id_venta);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar', $data);
		$this->load->view('templates/banner', $data);
		$this->load->view('templates/open_container');
		$this->load->view('templates/pedido_detalles_vista', $data);
		$this->load->view('templates/close_container');
		$this->load->view('templates/footer');
	}
}

?>