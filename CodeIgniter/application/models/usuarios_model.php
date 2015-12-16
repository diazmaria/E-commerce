<?php

class Usuarios_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();	
		$this->load->database();
	}

	public function very($valor, $campo)
	{
		$condicion = false;

		$consulta = $this->db->get_where('cliente', array($campo=>$valor, 'borrado'=>false));

		if($campo == 'usuario')
		{
			$consulta2 = $this->db->get_where('vendedor', array($campo=>$valor));

			if($consulta2->num_rows()==1)
			{
				$condicion = true;
			}
		}

		if ($consulta->num_rows()==1 || $condicion)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function add_usuario()
	{
		$this->db->insert('cliente', array(
			'nombre'=>$this->input->post('nombre', true),
			'apellidos'=>$this->input->post('apellidos', true),
			'dni'=>$this->input->post('dni', true),
			'direccion'=>$this->input->post('direccion', true),
			'fecha_nacimiento'=>$this->input->post('fecha_nacimiento', true),
			'telefono'=>$this->input->post('telefono', true),
			'correo'=>$this->input->post('correo', true),
			'usuario'=>$this->input->post('usuario', true),
			'contrasena'=>md5($this->input->post('contrasena', true))
		));
	}

	public function very_sesion()
	{
		$consulta = $this->db->get_where('cliente', array(
			'usuario'=> $this->input->post('usuario', true),
			'contrasena'=> md5($this->input->post('contrasena', true)),
			'borrado' => false
		));
		
		if($consulta->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function very_sesion_vendedor()
	{
		$consulta = $this->db->get_where('vendedor', array(
			'usuario'=> $this->input->post('usuario', true),
			'contrasena'=> md5($this->input->post('contrasena', true))
		));

		if($consulta->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_usuario_id($user) {
		$this->db->select('cliente.id');
		$this->db->from('cliente');
		$this->db->where('cliente.usuario =', $user);
		$result = $this->db->get();
		$row = $result->row_array();
		return $row['id'];
	}
}
?>