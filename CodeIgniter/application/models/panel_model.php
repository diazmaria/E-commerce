<?php

class Panel_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();	
		$this->load->database();
	}


	public function select_usuario($campo, $usuario)
	{
		$consulta = $this->db->get_where('cliente', array($campo=>$usuario, 'borrado'=> false));

   		$row = $consulta->row_array();

   		return $row;
	}


	public function delete_usuario($usuario)
	{
		$this->db->where('usuario', $usuario);

		$this->db->update('cliente', array(
			'borrado'=> 1,
			'fecha_baja' => date("Y-m-d H:i:s")));
	}


	public function update_usuario($usuario)
	{
		$this->db->where(array('usuario'=>$usuario, 'borrado'=> false));

		$this->db->update('cliente', array(
			'nombre'=>$this->input->post('nombre', true),
			'apellidos'=>$this->input->post('apellidos', true),
			'dni'=>$this->input->post('dni', true),
			'direccion'=>$this->input->post('direccion', true),
			'fecha_nacimiento'=>$this->input->post('fecha_nacimiento', true),
			'telefono'=>$this->input->post('telefono', true),
			'correo'=>$this->input->post('correo', true),
			'contrasena'=> md5($this->input->post('contrasena', true))
			));
	}



	public function very($valor, $campo, $usuario)
	{

		$consulta = $this->db->get_where('cliente', array($campo=>$valor, 'borrado'=> false));

   		$row = $consulta->row_array();

		if($consulta->num_rows()==1)
		{
			if ($row['usuario'] == $usuario)
			{
				return true;
			}

			else 
			{
				return false;
			}
		}

		else
		{
			return true;
		}
	}

}
?>