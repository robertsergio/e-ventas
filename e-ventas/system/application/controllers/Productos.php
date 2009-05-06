<?php

class Productos extends Controller{

	var $data=null;
	
	public function Productos() {
		parent::Controller();
		$this->data['upload_data']= null;
		
	}

	public function listar(){
				
		//Traigo la libreria para la paginacion.
		$this->load->library('pagination');
		//Otras configuraciones para la paginacion estan en  config/pagination.php
		$config['base_url'] = base_url()."/productos/listar/";
		$config['total_rows']= $this->ModeloProducto->cantidad_filas();
		$config['per_page'] = '4'; //Cantidad por pagina.
		$this->pagination->initialize($config);
		
		$offset=$this->uri->segment($this->uri->total_segments()); //Traigo el ultimo segmento.
		
		$this->data['items']= $this->ModeloProducto->getAllProductos($config['per_page'],$offset);
		
		$this->data['main']='productos/listar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	public function ver($id) {
		$this->data['producto']=$this->ModeloProducto->getProducto($id);
		//borro elementos que no voy a necesitar.
		unset($this->data['producto']['id']);
		unset($this->data['producto']['borrado']);
		unset($this->data['producto']['categoria_id']);
		//formateo la comision.
		$this->data['producto']['comision']=$this->data['producto']['comision']*$this->data['producto']['precio'];
		
		//le mando los datos a la vista.
		$this->data['main']='productos/ver';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	//Redirecciona al formulario que sera editado.
	public function editar($id) {
		$this->data['producto']=$this->ModeloProducto->getProducto($id);
		$this->data['id']=$id;
		//Traigo las categorias.
		$cats= $this->ModeloCategoria->getAllCategorias();
		//Preparo el vector para pasarle a la vista.
		foreach ($cats as $categoria){
			$opciones[$categoria['id']]= $categoria['nombre'];
		}

		$this->data['categorias'] =$opciones;

		$this->data['main']='productos/editar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	public function borrar($id) {
		$this->ModeloProducto->borrarProducto($id);
		$this->session->set_flashdata('mensaje',"El producto fue borrado con exito.");
		redirect('/productos/listar');
	}
	/*
	 * Con esta funcion redireccionamos al formulario para agregar un producto.
	 */
	public function agregar() {

		$cats= $this->ModeloCategoria->getAllCategorias();
		//Preparo el vector para pasarle a la vista.
		foreach ($cats as $categoria){
			$opciones[$categoria['id']]= $categoria['nombre'];
		}

		$this->data['categorias'] =$opciones;
		$this->data['main']='productos/agregar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
		 
	}

	/*
	 * Recibe los datos del formulario y guarda en la base de datos.
	 */
	public function crear() {
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->load->library('form_validation');
		 
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
		$this->form_validation->set_rules('categoria_id', 'Categoria', 'callback_categoria_check');
		$this->form_validation->set_message('categoria_check', "Debe seleccionar alguna categoria.");

		if ($this->form_validation->run() == FALSE)
		{
				
			$cats= $this->ModeloCategoria->getAllCategorias();
			//Preparo el vector para pasarle a la vista.
			foreach ($cats as $categoria){
				$opciones[$categoria['id']]= $categoria['nombre'];
			}
			 
			$this->data['categorias'] =$opciones;
			$this->data['main']='productos/agregar';
			$this->load->vars($this->data);
			$this-> load-> view('template');
		}
		else
		{
				
			if($_FILES['imagen']['name']!='' && !$this->subir_imagen('imagen'))
			{
				$this->session->set_flashdata('mensaje',"Lo siento, NO se pudo guardar la imagen...");
				redirect('/productos/agregar');
			}else{
					
				$datos=$_POST;
				//borro un dato basura que no me sirve.
				unset($datos['agregar']);
				
				if($this->data['upload_data']!=null)
					$datos['imagen']='imagenes/'.$this->data['upload_data']['file_name'];//guardo la direccion de la imagen.
				else
					$datos['imagen']='imagenes/Sin_foto.png';
				//Guardo los datos del producto en la base de datos.
				$nuevoProducto= new ModeloProducto($datos);
				$nuevoProducto->agregarProducto();
				$this->session->set_flashdata('mensaje',"El producto fue agregado con exito.");
				redirect('/productos/listar');
			}
				

		}
		 
		 
	}

	/*
	 * Recibe los datos editados del formulario y guarda en la base de datos.
	 */
	public function actualizar() {
		
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->load->library('form_validation');
		 
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
		$this->form_validation->set_rules('categoria', 'Categoria', 'callback_categoria_check');
		$this->form_validation->set_message('categoria_check', "Debe seleccionar alguna categoria.");

		if ($this->form_validation->run() == FALSE)
		{
				
			$cats= $this->ModeloCategoria->getAllCategorias();
			//Preparo el vector para pasarle a la vista.
			foreach ($cats as $categoria){
				$opciones[$categoria['id']]= $categoria['nombre'];
			}
			 
			$this->data['categorias'] =$opciones;
			$this->data['main']='productos/agregar';
			$this->load->vars($this->data);
			$this-> load-> view('template');
		}
		else
		{
			if($_FILES['imagen']['name']!='' && !$this->subir_imagen('imagen'))
			{
				$this->session->set_flashdata('mensaje',"Lo siento, NO se pudo guardar la imagen...");
				redirect('/productos/agregar');
			}else{
				$datos['nombre']=$_POST['nombre'];
				$datos['categoria_id']=$_POST['categoria'];
				$datos['comision']=$_POST['comision'];
				$datos['descripcion']=$_POST['descripcion'];
				$datos['precio']=$_POST['precio'];
				$datos['id']=$_POST['id']; // Si no tiene el id, no se actualiza.
				
				if($this->data['upload_data']!=null)//guardo la direccion de la imagen si es que hay algo.
					$datos['imagen']='imagenes/'.$this->data['upload_data']['file_name'];
				
				
				$nuevoProducto= new ModeloProducto($datos);
				$nuevoProducto->actualizarProducto();
				redirect('/productos/listar');
			}
		}
		
	}
	/**
	 * Busca las subcategorias para llenar el select.
	 * @return unknown_type
	 */
	public function ajaxFindSubcategoria() {
		$idcategoria=$this->input->post('categoria');
		$subcat=$this->ModeloCategoria->getAllSubCategorias($idcategoria);
		 
		foreach ($subcat as $valor){
			$salida.="<option  value=".$valor['id'].">".$valor['nombre']."</option> ";
		}
		echo $salida;
		 
	}
	/**
	 * Funcion que valida el valor del campo categoria.
	 * @return boolean
	 */
	public function categoria_check($str)
	{
		if(!is_numeric($str))
		return FALSE;
		else
		return TRUE;
	}
	public function subir_imagen($nombre_campo)
	{
		// Traigo la imagen del cliente.
		$config['upload_path'] = './imagenes/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
			
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($nombre_campo))
		{
			return FALSE;

		}
		else
		{
			$this->data['upload_data']= $this->upload->data();
			return TRUE;
		}
	}
	/**
	 * Lista los productos con el link de agregar al carrito.
	 * @return unknown_type
	 */
	public function carrito() {
		//Traigo datos del carrito.
		$this->data['cart']=$this->session->userdata('cart');
		
		//Traigo la libreria para la paginacion.
		$this->load->library('pagination');
		//Otras configuraciones para la paginacion estan en  config/pagination.php
		$config['base_url'] = base_url()."/productos/carrito/";
		$config['total_rows']= $this->ModeloProducto->cantidad_filas();
		$config['per_page'] = '4'; //Cantidad por pagina.
		$this->pagination->initialize($config);
		
		$offset=$this->uri->segment($this->uri->total_segments()); //Traigo el ultimo segmento.
		
		$this->data['items']= $this->ModeloProducto->getAllProductos($config['per_page'],$offset);
		
		$this->data['main']='productos/listarShop';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
	/**
	 * Agrega un producto al carrito.
	 * @param $idProducto Id del producto que se quiere agregar
	 * @return unknown_type
	 */
	public function agregarCarrito($idProducto) {
		$producto=$this->ModeloProducto->getProducto($idProducto);
		$cart=$this->session->userdata('cart');
		$totalprecio=0;
		if(count($producto))
		{
			if(isset($cart[$idProducto]))
			{
				$prevNombre=$cart[$idProducto]['nombre'];
				$prevPrecio=$cart[$idProducto]['precio'];
				$prevCant=$cart[$idProducto]['cantidad'];
				
				$cart[$idProducto]=array(
						'nombre'=>$prevNombre,
						'precio'=>$prevPrecio,
						'cantidad'=>$prevCant+1
				);
			}else{
				$cart[$idProducto]=array(
						'nombre'=>$producto['nombre'],
						'precio'=>$producto['precio'],
						'cantidad'=>1
				);
			}
			foreach ($cart as $id => $product) {
				$totalprecio += $product['precio']*$product['cantidad'];
			}
			
			$this->session->set_userdata('precioTotal',$totalprecio);
			$this->session->set_userdata('cart',$cart);
			$this->session->set_flashdata('mensaje','El producto "'.$producto['nombre'].'" fue agregado al carrito.');
			redirect('/productos/carrito');
		}else
		{
			//redirecciono si el id no es valido.
			redirect('/productos/carrito');
		}
	}
	public function verCarrito() {
		$this->data['precioTotal']=$this->session->userdata('precioTotal');
		$this->data['cart']=$this->session->userdata('cart');
		if($this->data['cart']==null)
		{
			$this->session->set_flashdata('mensaje','El carrito está vacío.');
			redirect('/productos/carrito');
		}else{
			$this->data['main']='productos/verCarrito';
			$this->load->vars($this->data);
			$this-> load-> view('template');	
		}
		
	}
}
?>
