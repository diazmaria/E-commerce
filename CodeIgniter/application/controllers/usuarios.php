<?php

class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->database();  
		$this->load->model('usuarios_model');
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function index()
	{
		$datos = null;

		if($this->session->userdata('usuario'))
		{
			$datos = array('usuario' => $this->session->userdata('usuario'));
			$session_usuario = $this->session->userdata('usuario');
			$mensaje = array('mensaje' => 'Ya ha iniciado sesión con el nombre de usuario: '.$session_usuario);

			$this->load->view('templates/header');
			$this->load->view('templates/navbar', $datos);
			$this->load->view('templates/open_container');
			$this->load->view('pages/ya_registrado_view', $mensaje);
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');
		}
		
		else if($this->session->userdata('vendedor'))
		{
			$datos = array('vendedor' => $this->session->userdata('vendedor'));
			$session_usuario = $this->session->userdata('vendedor');
			$mensaje = array('mensaje' => ' Ya ha iniciado sesión con el nombre de vendedor: '.$session_usuario);

			$this->load->view('templates/header');
			$this->load->view('templates/navbar', $datos);
			$this->load->view('templates/open_container');
			$this->load->view('pages/ya_registrado_view', $mensaje);
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');

		}

		else
		{
			$data['title'] = "Iniciar sesión";
			$this->load->view('templates/header');
			$this->load->view('templates/navbar', $datos);
			$this->load->view('templates/banner', $data);
			$this->load->view('templates/open_container');
			$this->load->view('pages/usuarios_view');
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');
		}
		
	}

	public function registro()
	{
		$datos = null;

		if($this->session->userdata('usuario'))
		{
			$datos = array('usuario' => $this->session->userdata('usuario'));
			$this->load->view('templates/navbar', $datos);
			$this->load->view('templates/open_container');
			$session_usuario = $this->session->userdata('usuario');
			$mensaje = array('mensaje' => 'Ya ha iniciado sesión con el nombre de usuario: '.$session_usuario);
			$this->load->view('pages/ya_registrado_view', $mensaje);
			$this->load->view('templates/close_container');	
		}
		
		else if($this->session->userdata('vendedor'))
		{
			$datos = array('vendedor' => $this->session->userdata('vendedor'));
			$this->load->view('templates/navbar', $datos);
			$this->load->view('templates/open_container');
			$session_usuario = $this->session->userdata('vendedor');
			$mensaje = array('mensaje' => 'Ya ha iniciado sesión con el nombre de vendedor: '.$session_usuario);
			$this->load->view('pages/ya_registrado_view', $mensaje);
			$this->load->view('templates/close_container');		
		}

		else
		{
			$data['title'] = "Registrar usuario";
			$this->load->view('templates/header');
			$this->load->view('templates/navbar', $datos);
			$this->load->view('templates/banner', $data);
			$this->load->view('templates/open_container');
			$this->load->view('pages/registro_view');
			$this->load->view('templates/close_container');	
		}
	}

	public function registro_very()
	{
		if($this->input->post('submit_reg'))
		{
			$this->form_validation->set_rules('nombre', 'nombre', 'required|min_length[2]|max_length[40]');
			$this->form_validation->set_rules('apellidos', 'apellidos', 'required|min_length[2]|max_length[40]');
			$this->form_validation->set_rules('dni', 'DNI', 'required|trim|min_length[9]|max_length[9]|callback_very_dni');
			$this->form_validation->set_rules('direccion', 'dirección', 'required|min_length[10]|max_length[200]');
			$this->form_validation->set_rules('fecha_nacimiento', 'fecha de nacimiento', 'required|callback_very_fecha');
			$this->form_validation->set_rules('telefono', 'teléfono', 'required|trim|min_length[9]|max_length[20]');
			$this->form_validation->set_rules('correo', 'correo', 'required|trim|valid_email|max_length[40]|callback_very_correo');
			$this->form_validation->set_rules('usuario', 'usuario', 'required|trim|min_length[3]|max_length[20]|callback_very_usuario');
			$this->form_validation->set_rules('contrasena', 'contraseña', 'required|min_length[3]|max_length[20]');


			$this->form_validation->set_message('required', '*El campo %s es obligatorio.');
			$this->form_validation->set_message('min_length', '*El campo %s debe tener como mínimo %s caracteres.');
			$this->form_validation->set_message('max_length', '*El campo %s no debe exceder %s caracteres.');
			$this->form_validation->set_message('valid_email', '*El %s es inválido.');
			$this->form_validation->set_message('very_dni', '*El %s ya existe.');
			$this->form_validation->set_message('very_fecha', '*El formato de la %s es es inválido.');
			$this->form_validation->set_message('very_correo', '*El %s ya existe.');
			$this->form_validation->set_message('very_usuario', '*El %s ya existe.');


			if($this->form_validation->run() != false)
			{
				$this->usuarios_model->add_usuario();
				$this->load->view('templates/open_container');
				$mensaje = array('mensaje'=> 'El usuario se registró correctamente');
				$this->load->view('pages/mensaje_view', $mensaje);
				$this->load->view('templates/close_container');
			}
			else
			{
				$datos = null;
				
				$data['title'] = "Registrar usuario";
				$this->load->view('templates/header');
				$this->load->view('templates/navbar', $datos);
				$this->load->view('templates/open_container');
				$this->load->view('templates/banner', $data);
				$this->load->view('pages/registro_view');
				$this->load->view('templates/close_container');
			}
		}

	}



	function very_usuario($usuario)
	{
		$variable = $this->usuarios_model->very($usuario, 'usuario');
		if($variable == true)
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
		$variable = $this->usuarios_model->very($correo, 'correo');
		if($variable == true)
		{
			return false;
		}
		else
		{
			return true;
		}
	}


	function very_dni($dni)
	{
		$variable = $this->usuarios_model->very($dni, 'dni');
		if($variable == true)
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


	public function very_sesion()
	{
		if($this->input->post('submit'))
		{
			$variable = $this->usuarios_model->very_sesion();
			$variable2 = $this->usuarios_model->very_sesion_vendedor();


			if($variable == true)
			{
				$variables = array(
					'usuario' => $this->input->post('usuario')
					);
				$this->session->set_userdata($variables);
				redirect("http://localhost/CodeIgniter/index.php/catalogo");
			}

			else if($variable2 == true )
			{
				$variables = array(
					'vendedor' => $this->input->post('usuario')
					);
				$this->session->set_userdata($variables);
				redirect("http://localhost/CodeIgniter/index.php/catalogo");
			}

		
			else
			{
			    $this->form_validation->set_rules('usuario', 'usuario', 'required');
				$this->form_validation->set_rules('contrasena', 'contraseña', 'required');

				$this->form_validation->set_message('required', '*El campo %s es obligatorio.');

				if($this->form_validation->run() != false)
				{
					$data = array('error' => 'El Usuario/Contraseña son incorrectos');

					$datos = null;

					if($this->session->userdata('usuario'))
					{
						$datos = array('usuario' => $this->session->userdata('usuario'));
					}
					
					else if($this->session->userdata('vendedor'))
					{
						$datos = array('vendedor' => $this->session->userdata('vendedor'));
					}
					
					
					$data['title'] = 'Iniciar sesión';
					
					$this->load->view('templates/navbar', $datos);
					$this->load->view('templates/header');
					$this->load->view('templates/banner', $data);
					$this->load->view('templates/open_container');
					$this->load->view('pages/usuarios_view', $data);
					$this->load->view('templates/close_container');
			    }

			    else 
			    {
			    	$datos = null;
			    	if($this->session->userdata('usuario'))
					{
						$datos = array('usuario' => $this->session->userdata('usuario'));
					}
					
					else if($this->session->userdata('vendedor'))
					{
						$datos = array('vendedor' => $this->session->userdata('vendedor'));
					}
					
					$data['title'] = 'Iniciar sesión';
					
					$this->load->view('templates/navbar', $datos);
					$this->load->view('templates/header');
					$this->load->view('templates/banner', $data);
					$this->load->view('templates/open_container');
					$this->load->view('pages/usuarios_view');
					$this->load->view('templates/close_container');
				}

		    }
		}

		else
		{
			redirect("http://localhost/CodeIgniter/index.php/usuarios");
		}
	}



	public function abandonar_sesion()
	{
		$this->session->sess_destroy();
		$data['title'] = 'Cerrar sesión.';
		$data['mensaje'] = 'Cerrando sesión.... Estás siendo redirigido.';
		$this->load->view('templates/header_cerrar_sesion', $data);
		$this->load->view('templates/navbar', $data);
		$this->load->view('templates/banner_cerrar_sesion', $data);
		$this->load->view('templates/open_container');
		$this->load->view('templates/close_container');
		$this->load->view('templates/footer');
	}

}

?>