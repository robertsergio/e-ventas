<?php
 
class Clientes extends Controller{
	
	public function  __construct(){
		parent::Controller();
		;
	}
	
	public function listar(){
				
		//Traigo la libreria para la paginacion.
		$this->load->library('pagination');
		//Otras configuraciones para la paginacion estan en  config/pagination.php
		$config['base_url'] = base_url()."/clientes/listar/";
		$config['total_rows']= $this->ModeloCliente->cantidad_filas();
		$config['per_page'] = '4'; //Cantidad por pagina.
		$this->pagination->initialize($config);
		
		$offset=$this->uri->segment($this->uri->total_segments()); //Traigo el ultimo segmento.
		
		$this->data['items']= $this->ModeloCliente->getAllClientes($config['per_page'],$offset);
		
		$this->data['main']='clientes/listar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
	public function ver($id) {
		$this->data['cliente']=$this->ModeloCliente->getCliente($id);
		$this->data['main']='clientes/ver';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
	
	/*
	 * Con esta funcion redireccionamos al formulario para agregar un usuario.
	 */
	public function agregar() {

		//Traigo las ciudades y los roles.
		$this->data['ciudades'] =$this->traerCiudades();
		$this->data['vendedores'] =$this->traerVendedores();
				
		$this->data['main']='clientes/agregar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
		 
	}
	
	/**
	 * Realiza un borrado logico del cliente.
	 * @param $id cliente al que se le desea borrar.
	 * @return unknown_type
	 */
	public function borrar($id) {
		$this->ModeloCliente->borrarCliente($id);
		$this->session->set_flashdata('mensaje',"El usuario fue borrado con exito.");
		redirect('/clientes/listar');
	}
	
	//Redirecciona al formulario que sera editado.
	public function editar($id) {
		$this->data['cliente']=$this->ModeloCliente->getCliente($id);
		$this->data['id']=$id;
		//Traigo las ciudades y los roles para el select.
		$this->data['ciudades'] =$this->traerCiudades();
		$this->data['vendedores']=$this->traerVendedores();
		//Traigo los barrios para el select.
		$this->data['barrios']=$this->traerBarrios($this->data['cliente']['ciudad_id']);
		
		$this->data['main']='clientes/editar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
	/*
	 * Recibe los datos del formulario y guarda en la base de datos.
	 */
	public function crear() {
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->validar_formulario_cliente();
		$this->load->library('form_validation');
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->data['ciudades'] =$this->traerCiudades();
			$this->data['vendedores'] =$this->traerVendedores();
			$this->data['main']='clientes/agregar';
			$this->load->vars($this->data);
			$this->load-> view('template');
		}
		else
		{
				$datos=$_POST;
				
				//borro los datos basura que no me sirven.
				unset($datos['agregar']);
				unset($datos['ciudad']);
				//Guardo los datos del cliente en la base de datos.
				$nuevoVendedor= new ModeloCliente($datos);
				$nuevoVendedor->agregarCliente();
				$this->session->set_flashdata('mensaje',"El cliente fue agregado con exito.");
				
				redirect('/clientes/listar');

		}
	}
	
/*
	 * Recibe los datos del formulario y guarda en la base de datos.
	 */
	public function actualizar() {
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->validar_formulario_cliente();
		$this->load->library('form_validation');
				
		if ($this->form_validation->run() == FALSE)
		{
			//Traigo los datos para el formulario.
			$this->data['id']=$_POST['id'];
			$this->data['cliente']=$this->ModeloCliente->getCliente($_POST['id']);
			$this->data['ciudades'] =$this->traerCiudades();
			$this->data['vendedores'] =$this->traerVendedores();
			$this->data['main']='clientes/editar';
			$this->load->vars($this->data);
			$this->load-> view('template');
		}
		else
		{
				$datos=$_POST;
				
				//borro los datos basura que no me sirven.
				unset($datos['guardar']);
				unset($datos['ciudad']);
				//Guardo los datos del cliente en la base de datos.
				$nuevoVendedor= new ModeloCliente($datos);
				$nuevoVendedor->actualizarCliente();
				$this->session->set_flashdata('mensaje',"El cliente fue editado con exito.");
				
				redirect('/clientes/listar');

		}
	}
	
	
	/////*****FUNCIONES COMPLEMENTARIAS *********//////
	/**
	 * 
	 * @param $isEditar Indica si el formulario es un editar, o es un crear.
	 * @return unknown_type
	 */
	function validar_formulario_cliente() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellido', 'Apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('telefono', 'Telefono', 'numeric');
		$this->form_validation->set_rules('ci', 'Ced. de Identidad', 'required|numeric');
		$this->form_validation->set_rules('celular', 'Celular', 'numeric');
		$this->form_validation->set_rules('barrio_id', 'Barrio', 'callback_barrio_check');
		$this->form_validation->set_message('barrio_check', "Debe seleccionar algun barrio.");
		$this->form_validation->set_rules('vendedor_id', 'Vendedor', 'callback_vendedor_check');
		$this->form_validation->set_message('vendedor_check', "Debe seleccionar algun vendedor para el cliente.");	
	}
	
	////Funciones para validacion del formulario.
	public function barrio_check($str)
	{
		//Si no es un numero es el valor "ape". O sea no eligio nada.
		return is_numeric($str);
	}
	public function vendedor_check($str) {
		//Si no es un numero es el valor "ape". O sea no eligio nada.
		return is_numeric($str);
	}
	
	////******Funciones Complementarias para obtener datos para los formularios.********///////
	/**
	 * Retorna un vector con las ciudades de forma a que
	 * pueda ser utilizado en los formularios a agregar y editar.
	 * @return Vector con ciudades 'ciudad_id'=>'nombre_ciudad'
	 */
	function traerCiudades() {
		//Preparo el vector Ciudades para pasarle a la vista.
		$city= $this->ModeloCiudad->getAllCiudades();
		foreach ($city as $ciudad){
			$opciones[$ciudad['id']]= $ciudad['nombre'];
		}
		return $opciones;
	}
	/**
	 * Trae todos los barrios de una ciudad, y lo formatea para la vista.
	 * Este vector se utiliza en el select de la vista.
	 * @param $id_ciudad
	 * @return vector formateado con el id del barrio y su nombre.
	 */
 	 function traerBarrios($id_ciudad) {
		//Preparo el vector Barrios para pasarle a la vista.
		$barrios= $this->ModeloCiudad->getAllBarrios($id_ciudad);
		foreach ($barrios as $barrio){
			$opciones[$barrio['id']]= $barrio['nombre'];
		}
		return $opciones;
		
	}
	/**
	 * Retorna un vector con los supervisores, de forma a que
	 * pueda ser utilizado en select de los formularios .
	 * @return Vector preparado para el select.
	 */
	function traerVendedores() {
		$s= $this->ModeloUsuario->getAllVendedores();
		//Preparo el vector de Vendedores para pasarle a la vista.
		foreach ($s as $s1){
			$op[$s1['id']]= $s1['username'];
		}
		return $op;
	}
}
?>