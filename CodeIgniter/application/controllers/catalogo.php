<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogo extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Catalogo_model');
		$this->load->model('Iva_model');
		$this->load->model('Categoria_model');
		$this->load->helper('form');
			$this->load->library('form_validation');
		$this->load->library('session');
	}
	
	public function index(){
		//reseteo de la variable de session de haber hecho un pedido anteriormente.
		$this->session->unset_userdata('pedido');
		
		$this->load->library('pagination');	
		$data['productos'] = $this->Catalogo_model->join_catalogo_iva();
		$data['title'] = 'Catálogo';
		//******//
		$data['menuSideBar'] = $this->Categoria_model->get_categoria();
		//******//
		$num_por_pagina = 10;
		$config['base_url'] = 'http://localhost/codeigniter/index.php/catalogo/index/';
		$config['total_rows'] = $this->Catalogo_model->get_filas_disponibles();
		$config['per_page'] = $num_por_pagina; 
		$config['num_links'] = 10; 
		$config["uri_segment"] = 3;
		$config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
		$config['next_link'] = '&raquo;';//siguiente link
        $config['prev_link'] = '&laquo;';//anterior link
		$config['full_tag_open'] = '<div class="pagination">';//el div que debemos maquetar
        $config['full_tag_close'] = '</div>';//el cierre del div de la paginación
		
		$this->pagination->initialize($config); 
		
		$data["productos"] = $this->Catalogo_model->catalogoPorPagina($config['per_page'],$this->uri->segment(3));         
		
		if($this->session->userdata('usuario')){
			$data['usuario'] = $this->session->userdata('usuario');
		} else if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar', $data);
		$this->load->view('templates/banner', $data);
		$this->load->view('templates/open_container');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('pages/catalogo', $data);
			
			//echo $this->pagination->create_links();
		$this->load->view('templates/close_container');
		$this->load->view('templates/footer');
	}
	
	
	public function detalles($id){
	
		$data['producto'] = $this->Catalogo_model->join_catalogo_iva($id);
		if (empty($data['producto'])){
			show_404();
		}
		if($this->session->userdata('usuario')){
			$data['usuario'] = $this->session->userdata('usuario');
		} else if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
		}
		$data['mensaje'] = substr($data['producto']['descripcion_producto'], 0, 256).'...';
		$data['title'] = $data['producto']['nombre_producto'];
		//******//
		$data['menuSideBar'] = $this->Categoria_model->get_categoria();
		//******//
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar', $data);
		$this->load->view('templates/banner', $data);
		$this->load->view('templates/open_container');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('pages/detalles', $data);
		$this->load->view('templates/close_container');
		$this->load->view('templates/footer');
	}
	
	public function insertar_producto(){
		if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
			$data['iva'] = $this->Iva_model->get_iva();
			$data['categoria'] = $this->Categoria_model->get_categoria();
			//******//
			$data['menuSideBar'] = $this->Categoria_model->get_categoria();
			//******//
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$data['title'] = 'Inserta un nuevo producto';
			$data['mensaje'] = 'Para crear un nuevo producto es necesario rellenar todos los campos';
			
			$this->form_validation->set_rules('nombre', 'Nombre del producto', 'required');
			$this->form_validation->set_rules('descripcion', 'Descripción del producto', 'required');
			$this->form_validation->set_rules('categoria', 'Categoria del producto', 'required');
			$this->form_validation->set_rules('stock', 'Stock del producto', 'required');
			$this->form_validation->set_rules('precio_base', 'Precio base del producto', 'required');
			$this->form_validation->set_rules('iva', 'IVA aplicable del producto', 'required');
			
			if (empty($_FILES['imagen']['name'])){
				$this->form_validation->set_rules('imagen', 'Imagen del producto', 'required');
			}
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view('templates/header', $data);
				$this->load->view('templates/navbar');
				$this->load->view('templates/banner',$data);
				$this->load->view('templates/open_container');
				$this->load->view('templates/sidebar', $data);
				$this->load->view('pages/nuevo_producto', $data);
				$this->load->view('templates/close_container');
				$this->load->view('templates/footer');
			}
			else{
				if($this->Catalogo_model->set_catalogo()){
					$data['mensaje'] = 'Producto subido correctamente';
				}
				
				//$this->load->view('pages/success');
				
				$lastID = $this->Catalogo_model->lastID_catalogo();
				
				$path = './images/'.$lastID.'/';
				mkdir($path,777);
				mkdir($path.'/thumbs/',777);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = '1.jpg';
				//
				$nombre = '1.jpg';
				$this->load->library('upload', $config);
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/navbar');
				$this->load->view('templates/banner',$data);
				$this->load->view('templates/open_container');
				$this->load->view('templates/sidebar', $data);
				
				
				//Si no se sube la imagen
				if ( ! $this->upload->do_upload('imagen')){
					$data['mensaje'] = array('error' => $this->upload->display_errors());
					
					$this->load->view('pages/nuevo_producto', $data);
				}else{
					$this->redimensionar($path, $nombre);
					//$mensaje = array('upload_data' => $this->upload->data());
					$data['mensaje'] = 'Subido correctamente';
					$this->load->view('pages/nuevo_producto', $data);
				}
				
				$this->load->view('templates/close_container');
				$this->load->view('templates/footer');
			}
		}
	}
	
	
	 public function validar_busqueda() {
        $this->form_validation->set_rules('buscar', 'buscador', 'required|min_length[2]|max_length[20]|trim|xss_clean');
        $this->form_validation->set_message('required', 'El campo no puede ir vacío!');
        $this->form_validation->set_message('min_length', 'El  campo debe tener al menos %s carácteres');
        $this->form_validation->set_message('max_length', 'El campo no puede tener más de %s carácteres');
        if ($this->form_validation->run() == TRUE) {
 
            $buscador = $this->input->post('buscar');
           
            //todo correcto y pasamos a la función index
            $this->buscar_producto($buscador);
        } else {
            //mostramos de nuevo el buscador con los errores
            $this->index();
        }
    }
	
	public function buscar_producto($buscador){
		$this->form_validation->set_rules('buscar', 'Búsqueda del producto', 'required|min_length[2]');
		$this->load->library('pagination');	
		$data['title'] = 'Resultado de la búsqueda';
		//******//
		$data['menuSideBar'] = $this->Categoria_model->get_categoria();
		//******//
		
		$num_por_pagina = 10;
		$config['base_url'] = 'http://localhost/codeigniter/index.php/catalogo/buscar_producto/'.$buscador.'/pages/';
		$config['total_rows'] = $this->Catalogo_model->get_filas_disponibles($buscador);
		$config['per_page'] = $num_por_pagina; 
		$config['num_links'] = 10; 
		$config["uri_segment"] = 5;
		$config['first_link'] = 'Primera';//primer link
		$config['last_link'] = 'Última';//último link
		$config['next_link'] = '&raquo;';//siguiente link
		$config['prev_link'] = '&laquo;';//anterior link
		$config['full_tag_open'] = '<div class="pagination">';//el div que debemos maquetar
		$config['full_tag_close'] = '</div>';//el cierre del div de la paginación
		
		$this->pagination->initialize($config); 
		$data['mensaje'] = 'Se han encontrado '.$config['total_rows'].' producto(s) que contiene(n) <b> '.$buscador.'</b> en el nombre o la descripción';
		$data["productos"] = $this->Catalogo_model->catalogoPorPagina($config['per_page'],$this->uri->segment(5), $buscador);         
		if($this->session->userdata('usuario')){
			$data['usuario'] = $this->session->userdata('usuario');
		} else if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar', $data);
		$this->load->view('templates/banner', $data);
		$this->load->view('templates/open_container');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('pages/busqueda', $data);
			
			//echo $this->pagination->create_links();
		$this->load->view('templates/close_container');
		$this->load->view('templates/footer');
	}
	
	public function buscar_categoria($categoria){
		$this->load->library('pagination');	
		//obtenemos la categoria por la que estamos buscando
		$data['categ'] = $this->Categoria_model->get_categoria($categoria);
		//inlcuimos la descripcion de la categoria a la variable title para mostrarla
		$data['title'] = $data['categ']['descripcion'];
		
		$data['mensaje'] = 'Resultado de la búsqueda por categoría';
		$data['prueba'] = $this->Catalogo_model->get_filas_disponibles_categoria($categoria);
		//******//
		//Obtenemos todas las categorias para ponerlas en el sidebar
		$data['menuSideBar'] = $this->Categoria_model->get_categoria();
		//******//
		$num_por_pagina = 10;
		$config['base_url'] = 'http://localhost/codeigniter/index.php/catalogo/buscar_categoria/'.$categoria.'/pages/';
		$config['total_rows'] = $this->Catalogo_model->get_filas_disponibles_categoria($categoria);
		$config['per_page'] = $num_por_pagina; 
		$config['num_links'] = 10; 
		$config["uri_segment"] = 5;
		$config['first_link'] = 'Primera';//primer link
		$config['last_link'] = 'Última';//último link
		$config['next_link'] = '&raquo;';//siguiente link
		$config['prev_link'] = '&laquo;';//anterior link
		$config['full_tag_open'] = '<div class="pagination">';//el div que debemos maquetar
		$config['full_tag_close'] = '</div>';//el cierre del div de la paginación
		
		$this->pagination->initialize($config); 
		
		//obtenemos el array con las filas como resultado de la busqueda por $categoria
		$data["productos"] = $this->Catalogo_model->productosPorCategoria($config['per_page'],$this->uri->segment(5), $categoria);    
		
		if($this->session->userdata('usuario')){
			$data['usuario'] = $this->session->userdata('usuario');
		} else if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
		}
		$i = 1;
		/*foreach ($data["productos"] as $fila):
			echo $i++;
			
		endforeach;
		*/
		
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar', $data);
		$this->load->view('templates/banner', $data);
		$this->load->view('templates/open_container');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('pages/busqueda', $data);
		$this->load->view('templates/close_container');
		$this->load->view('templates/footer');
		
	}
	
	public function modificar($id){
		if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
			$data['iva'] = $this->Iva_model->get_iva();
			$data['categoria'] = $this->Categoria_model->get_categoria();
			$data['producto'] = $this->Catalogo_model->join_catalogo_iva($id);
			$data['title'] = 'Modificar producto';
			$data['mensaje'] = '';
			//******//
			$data['menuSideBar'] = $this->Categoria_model->get_categoria();
			//******//
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nombre', 'Nombre del producto', 'required|min_length[2]');
			$this->form_validation->set_rules('descripcion', 'Descripción del producto', 'required|min_length[4]');
			$this->form_validation->set_rules('categoria', 'Categoria del producto', 'required');
			$this->form_validation->set_rules('stock', 'Stock del producto', 'required|is_natural');
			$this->form_validation->set_rules('precio_base', 'Precio base del producto', 'required|numeric');
			$this->form_validation->set_rules('iva', 'IVA aplicable del producto', 'required');
			
			if ($this->form_validation->run() === FALSE){
				$this->load->view('templates/header', $data);
				$this->load->view('templates/navbar');
				$this->load->view('templates/banner',$data);
				$this->load->view('templates/open_container');
				$this->load->view('templates/sidebar', $data);
				$this->load->view('pages/modificar', $data);
				$this->load->view('templates/close_container');
				$this->load->view('templates/footer');
			}else{
				if($this->Catalogo_model->update_catalogo($id)){
					$data['mensaje'] = 'Datos del producto actualizado correctamente';
				}
				$this->detalles($id);
			}
		}else{
			$this->detalles($id);
		}
	
	}
	
	
	public function cambiar_imagen($id){
		if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			if (empty($_FILES['imagen']['name'])){
				$this->form_validation->set_rules('imagen', 'Imagen del producto', 'required');
			}
			
			$path = './images/'.$id.'/thumbs/';
			$nombre = '1.jpg';
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = '1.jpg';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('imagen')){
				$data['mensaje'] = array('error' => $this->upload->display_errors());
				
				$this->modificar($id);
			}else{
				$this->detalles($id);
				
			}
			$this->redimesionar($path, $nombre);
			$this->load->view('templates/close_container');
			$this->load->view('templates/footer');
		} 
		
	}
	
	
	function redimensionar($path,$nombre){   
		if($this->session->userdata('vendedor')){
			$data['vendedor'] = $this->session->userdata('vendedor');
			 $config['image_library'] = 'GD';
			 $config['source_image'] =  $path.$nombre; 
			 $config['new_image']=$path.'thumbs/'; 
			 $config['create_thumb'] = TRUE;
			 $config['maintain_ratio'] = TRUE;
			 $config['width'] = 150;
			
			$this->load->library('image_lib', $config);
		   
			$this->image_lib->resize();
		
			//$this->load->view('upload_success');
		}	
    }
	
	
	
	
}

?>