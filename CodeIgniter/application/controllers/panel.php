<?php

class Panel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();  
		$this->load->model('panel_model');
	    $this->load->model('usuarios_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');

	}

	public function index()
	{
		if($this->session->userdata('usuario'))
		{

			$usuario = $this->session->userdata('usuario');

			$datos = $this->panel_model->select_usuario('usuario', "$usuario");

			$data = null;

			if($this->session->userdata('usuario'))
			{
				$data = array('usuario' => $this->session->userdata('usuario'));
			}
			
			else if($this->session->userdata('vendedor'))
			{
				$data = array('vendedor' => $this->session->userdata('vendedor'));
			}
		
			$this->load->view('templates/navbar', $datos);

			//$this->load->view('templates/navbar', $data);
			$this->load->view('templates/open_container');
			$this->load->view('pages/datos_view', $datos);
			$this->load->view('templates/close_container');
		}

		else
		{
			$mensaje = array('mensaje' => 'Solo los usuarios registrados pueden consultar sus datos.');
			$this->load->view('pages/mensaje_view', $mensaje);
		}
	}


	function very_sesion()
	{
		if(!$this->session->userdata('usuario'))
		{
			redirect("http://localhost/CodeIgniter/index.php/usuarios");
		}
	}


	public function datos_very()
	{
		if($this->input->post('submit_datos'))
		{

			$usuario = $this->session->userdata('usuario');

			$datos = array(
				'usuario' => $usuario,
				'nombre'=>$this->input->post('nombre', true),
				'apellidos'=>$this->input->post('apellidos', true),
				'dni'=>$this->input->post('dni', true),
				'direccion'=>$this->input->post('direccion', true),
				'fecha_nacimiento'=>$this->input->post('fecha_nacimiento', true),
				'telefono'=>$this->input->post('telefono', true),
				'correo'=>$this->input->post('correo', true),
				'contrasena'=>$this->input->post('contrasena', true)
			);

			$this->form_validation->set_rules('nombre', 'nombre', 'required|min_length[2]|max_length[40]');
			$this->form_validation->set_rules('apellidos', 'apellidos', 'required|min_length[2]|max_length[40]');
			$this->form_validation->set_rules('dni', 'DNI', 'required|trim|min_length[9]|max_length[9]|callback_very_dni');
			$this->form_validation->set_rules('direccion', 'dirección', 'required|min_length[10]|max_length[200]');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required|callback_very_fecha');
			$this->form_validation->set_rules('telefono', 'teléfono', 'required|trim|min_length[9]|max_length[20]');
			$this->form_validation->set_rules('correo', 'correo', 'required|trim|valid_email|max_length[40]|callback_very_correo');
			$this->form_validation->set_rules('contrasena', 'contraseña', 'required|min_length[3]|max_length[20]');


			$this->form_validation->set_message('required', '*El campo %s es obligatorio.');
			$this->form_validation->set_message('min_length', '*El campo %s debe tener como mínimo %s caracteres.');
			$this->form_validation->set_message('max_length', '*El campo %s no debe exceder %s caracteres.');
			$this->form_validation->set_message('valid_email', '*El %s es inválido.');
			$this->form_validation->set_message('very_dni', '*El %s ya existe.');
			$this->form_validation->set_message('very_fecha', '*El formato de la %s es es inválido.');
			$this->form_validation->set_message('very_correo', '*El %s ya existe.');


			$data = null;

			if($this->form_validation->run() != false)
			{
				$this->panel_model->update_usuario($usuario);
				$mensaje = array('mensaje'=> 'Sus datos se actualizaron correctamente');
				$this->load->view('pages/mensaje_view', $mensaje);
			}
			else
			{
				if($this->session->userdata('usuario'))
				{
					$data = array('usuario' => $this->session->userdata('usuario'));
				}
				
				else if($this->session->userdata('vendedor'))
				{
					$data = array('vendedor' => $this->session->userdata('vendedor'));
				}
		
				$this->load->view('templates/navbar', $data);
				$this->load->view('templates/open_container');
				$this->load->view('pages/datos_view', $datos);
				$this->load->view('templates/close_container');
			}

		}

	}


	function very_dni($dni)
	{
		$usuario = $this->session->userdata('usuario');

		$variable = $this->panel_model->very($dni, 'dni', $usuario);
		
		if($variable == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function very_correo($correo)
	{
		$usuario = $this->session->userdata('usuario');

		$variable = $this->panel_model->very($correo, 'correo', $usuario);
		if($variable == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}


	function very_fecha($fecha_nacimiento)
	{
		$patron = "/^(\d){4}\-(\d){2}\-(\d){2}$/i";

		if (preg_match($patron, $fecha_nacimiento))
		{
			return true;
		}
		
		else
		{
			return false;
		}
	}


	public function borrar()
	{

		$usuario = $this->session->userdata('usuario');

		$this->panel_model->delete_usuario($usuario);

		$this->session->sess_destroy();
		
		$mensaje = array('mensaje' => 'Su cuenta ha sido eliminada satisfactoriamente');

		$this->load->view('pages/mensaje_view', $mensaje);
	}




}

?>