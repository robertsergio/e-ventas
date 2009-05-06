<?php
 class Usuarios extends Controller {
 	var $data=null;
 	
 	function Usuarios() {
 		parent::Controller();
		
		$this->data['upload_data']= null;
	}
 	public function listar()
 	{
		//Traigo la libreria para la paginacion.
		$this->load->library('pagination');
				
		//Otras configuraciones para la paginacion estan en  config/pagination.php
		$config['base_url']= base_url()."/usuarios/listar/";
		$config['total_rows']= $this->ModeloUsuario->cantidad_filas();
		$config['per_page'] = '4'; //Cantidad por pagina.
		$this->pagination->initialize($config);
		
		$offset=$this->uri->segment($this->uri->total_segments()); //Traigo el ultimo segmento.
		$this->data['items']= $this->ModeloUsuario->getAllUsuarios($config['per_page'],$offset);
		$this->data['main']='usuarios/listar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
	/**
	 * Lista todos los vendedores que tiene el sistema.
	 * Para listar todos los 
	 */
 	public function listarVendedor()
 	{
		$user_id =$this->session->userdata('id');//El id del supervisor.
 		//Traigo la libreria para la paginacion.
		$this->load->library('pagination');
				
		//Otras configuraciones para la paginacion estan en  config/pagination.php
		$config['base_url']= base_url()."/usuarios/listarVendedor/";
		$config['total_rows']= $this->ModeloUsuario->cantidad_vendedores($user_id);
		$config['per_page'] = '4'; //Cantidad por pagina.
		$this->pagination->initialize($config);
		
		$offset=$this->uri->segment($this->uri->total_segments()); //Traigo el ultimo segmento.
		$this->data['items']= $this->ModeloUsuario->getAllVendedores($user_id,$config['per_page'],$offset);
		
		$this->data['main']='usuarios/vendedores/listarVendedor';
		
		$this->load->vars($this->data);
		$this-> load-> view('template');
		
	}
	
	
 	public function ver($id) {
		$this->data['usuario']=$this->ModeloUsuario->getUsuario($id);
		$this->data['main']='usuarios/ver';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
 	public function borrar($id) {
		$this->ModeloUsuario->borrarUsuario($id);
		$this->session->set_flashdata('mensaje',"El usuario fue borrado con exito.");
		redirect('/usuarios/listar');
	}
 	//Redirecciona al formulario que sera editado.
	public function editar($id) {
		$this->data['usuario']=$this->ModeloUsuario->getUsuario($id);
		$this->data['id']=$id;
		//Traigo las ciudades y los roles para el select.
		$this->data['ciudades'] =$this->traerCiudades();
		$this->data['roles'] =$this->traerRoles();
		
		//Traigo los barrios para el select.
		$this->data['barrios']=$this->traerBarrios($this->data['usuario']['ciudad_id']);
		
		$this->data['main']='usuarios/editar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
 	//Redirecciona al formulario que sera editado.
	public function editarVendedor($id) {
		$this->data['usuario']=$this->ModeloUsuario->getUsuario($id);
		
		if($this->data['usuario']['rol_id']!=3){
			$this->session->set_flashdata('mensaje',"Epa!..El usuario que intenta editar NO es un vendedor.");
			$this->data['main']='usuarios/vendedores/listarVendedor';
		}
		else{
			$this->data['id']=$id;
			//Traigo los datos para los select.
			$this->data['ciudades'] =$this->traerCiudades();
			$this->data['roles'] =$this->traerRoles();
			$this->data['supervisor'] =$this->traerSupervisores();
			$this->data['barrios']=$this->traerBarrios($this->data['usuario']['ciudad_id']);
			
			$this->data['main']='usuarios/vendedores/editarVendedor';	
		}
		
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
 	/*
	 * Con esta funcion redireccionamos al formulario para agregar un vendedor.
	 */
	public function agregarVendedor() {

		//Traigo las ciudades
		$this->data['creador_id'] =$this->session->userdata('id');//El id del creador es el supervisor.
		$this->data['ciudades'] =$this->traerCiudades();
		$this->data['supervisor'] =$this->traerSupervisores();
		$this->data['main']='usuarios/vendedores/agregarVendedor';
		$this->load->vars($this->data);
		$this-> load-> view('template');
		 
	}
  /*
	 * Recibe los datos del formulario y guarda en la base de datos.
	 */
	public function crearVendedor() {
			
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->load->library('form_validation');
		 
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellido', 'Apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required|matches[co_password]');
		$this->form_validation->set_rules('co_password', 'Confirmar Contraseña', 'required');
		$this->form_validation->set_rules('telefono', 'Telefono', 'numeric');
		$this->form_validation->set_rules('celular', 'Celular', 'numeric');
		$this->form_validation->set_rules('barrio_id', 'Barrio', 'callback_barrio_check');
		$this->form_validation->set_message('barrio_check', "Debe seleccionar algun barrio.");
		$this->form_validation->set_rules('rol_id', 'Rol', 'callback_rol_check');
		$this->form_validation->set_message('rol_check', "Debe seleccionar algun rol.");

		if ($this->form_validation->run() == FALSE)
		{
			$this->data['creador_id']=$this->session->userdata('id');//El id del creador es el supervisor.
			//Traigo los datos para los select del formulario.
			$this->data['roles']=$this->traerRoles();	
			$this->data['ciudades']=$this->traerCiudades();
			$this->data['supervisores']=$this->traerSupervisores();
			
			$this->data['main']='usuarios/vendedores/agregarVendedor';
			$this->load->vars($this->data);
			$this-> load-> view('template');
		}
		else
		{
				$datos=$_POST;
				
				$datos['username']=strtolower($_POST['username']);//Username se guarda en minusculas.
				$datos['password']=md5($_POST['password']);//El password se guarda en md5.
				//borro los datos basura que no me sirven.
				unset($datos['agregar']);
				unset($datos['co_password']);
				unset($datos['ciudad']);
				//Guardo los datos del producto en la base de datos.
				$nuevoVendedor= new ModeloUsuario($datos);
				$nuevoVendedor->agregarUsuario();
				$this->session->set_flashdata('mensaje',"El vendedor fue agregado con exito.");
				
				redirect('/usuarios/listarVendedor');

		}
		 
		 
	}
	
	/**
	 * Solo se pueden ver vendedores.
	 */
	public function verVendedor($id) {
		$data=$this->ModeloUsuario->getUsuario($id);
		
		
		if($data['rol_id']!=3)
		{
			$this->session->set_flashdata('mensaje',"Epa!..El usuario que intenta ver NO es un vendedor.");
			$this->data['main']='usuarios/vendedores/listarVendedor';
		}else{
			//Borro datos que no quiero que se vean.
			unset($data['ciudad_id']);
			unset($data['rol']);
			unset($data['password']);
			unset($data['rol_id']);
			unset($data['barrio_id']);
			
			$this->data['usuario']=$data;
			$this->data['main']='usuarios/vendedores/verVendedor';
		}
			

		$this->load->vars($this->data);
		$this-> load-> view('template');	
		
	}
	
	
 	public function actualizarVendedor() 
 	{
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->load->library('form_validation');
		 
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellido', 'Apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('telefono', 'Telefono', 'numeric');
		$this->form_validation->set_rules('celular', 'Celular', 'numeric');
		$this->form_validation->set_rules('barrio_id', 'Barrio', 'callback_barrio_check');
		$this->form_validation->set_message('barrio_check', "Debe seleccionar algun barrio.");
		$this->form_validation->set_rules('rol_id', 'Rol', 'callback_rol_check');
		$this->form_validation->set_message('rol_check', "Debe seleccionar algun rol.");

		if ($this->form_validation->run() == FALSE)
		{
			//Hago lo mismo que en la funcion agregar.
			$this->data['roles'] =$this->traerRoles();	
			$this->data['ciudades'] =$this->traerCiudades();
			$this->data['supervisores']=$this->traerSupervisores();
			
			$this->data['main']='usuarios/vendedores/editarVendedor';
			$this->load->vars($this->data);
			$this-> load-> view('template');
		}
		else
		{
				$datos=$_POST;
				
				$datos['username']=strtolower($_POST['username']);//Username se guarda en minusculas.
				if($_POST['password']!="")
					$datos['password']=md5($_POST['password']);//El password se guarda en md5.
				//borro los datos basura que no me sirven.
				unset($datos['guardar']);
				unset($datos['co_password']);
				unset($datos['ciudad']);	
				
				//Guardo los datos del producto en la base de datos.
				$nuevoProducto= new ModeloUsuario($datos);
				$nuevoProducto->actualizarUsuario();
				$this->session->set_flashdata('mensaje',"El vendedor fue editado con exito.");
				redirect('/usuarios/listarVendedor');

		}
	}
	
	/*
	 * Con esta funcion redireccionamos al formulario para agregar un usuario.
	 */
	public function agregar() {

		//Traigo las ciudades y los roles.
		$dat['ciudades']=$this->traerCiudades();
		$dat['roles']=$this->traerRoles();
		$this->data['ciudades'] =$dat['ciudades'];
		$this->data['roles'] =$dat['roles'];
		
		
		$this->data['main']='usuarios/agregar';
		$this->load->vars($this->data);
		$this-> load-> view('template');
		 
	}
 	
 	/**
	 * Busca las subcategorias para llenar el select.
	 * @return unknown_type
	 */
	public function ajaxFindBarrio() {
		$idciudad=$this->input->post('ciudad');
		$barrios=$this->ModeloCiudad->getAllBarrios($idciudad);
		$salida="<option  value=ape>[Seleccione un Barrio]</option> ";
		foreach ($barrios as $valor){
			$salida.="<option  value=".$valor['id'].">".$valor['nombre']."</option> ";
		}
		echo $salida;
		 
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
		$this->form_validation->set_rules('apellido', 'Apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required|matches[co_password]');
		$this->form_validation->set_rules('co_password', 'Confirmar Contraseña', 'required');
		$this->form_validation->set_rules('telefono', 'Telefono', 'numeric');
		$this->form_validation->set_rules('celular', 'Celular', 'numeric');
		$this->form_validation->set_rules('barrio_id', 'Barrio', 'callback_barrio_check');
		$this->form_validation->set_message('barrio_check', "Debe seleccionar algun barrio.");
		$this->form_validation->set_rules('rol_id', 'Rol', 'callback_rol_check');
		$this->form_validation->set_message('rol_check', "Debe seleccionar algun rol.");

		if ($this->form_validation->run() == FALSE)
		{
			//Hago lo mismo que en la funcion agregar.
			
			$roles= $this->ModeloRol->getAllRoles();
			//Preparo el vector Roles para pasarle a la vista.
			foreach ($roles as $rol){
				$op[$rol['id']]= $rol['nombre'];
			}
			$this->data['roles'] =$op;	
			$city= $this->ModeloCiudad->getAllCiudades();
			//Preparo el vector Ciudades para pasarle a la vista.
			foreach ($city as $ciudad){
				$opciones[$ciudad['id']]= $ciudad['nombre'];
			}
	
			$this->data['ciudades'] =$opciones;
			$this->data['main']='usuarios/agregar';
			$this->load->vars($this->data);
			$this-> load-> view('template');
		}
		else
		{
				/*@todo Cambiar el formulario para pasarle al modelo el vector post.*/
				$datos['nombre']=$_POST['nombre'];
				$datos['apellido']=$_POST['apellido'];
				$datos['username']=strtolower($_POST['username']);//Username se guarda en minusculas.
				$datos['password']=md5($_POST['password']);//El password se guarda en md5.
				$datos['apellido']=$_POST['apellido'];
				$datos['direccion']=$_POST['direccion'];
				$datos['barrio_id']=$_POST['barrio_id'];
				$datos['email']=$_POST['email'];
				$datos['telefono']=$_POST['telefono'];
				$datos['celular']=$_POST['celular'];
				$datos['rol_id']=$_POST['rol_id'];
				
				//Guardo los datos del producto en la base de datos.
				$nuevoProducto= new ModeloUsuario($datos);
				$nuevoProducto->agregarUsuario();
				$this->session->set_flashdata('mensaje',"El usuario fue agregado con exito.");
				
				redirect('/usuarios/listar');

		}
		 
		 
	}
	public function actualizar() {
	$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->load->library('form_validation');
		 
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellido', 'Apellidos', 'required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('telefono', 'Telefono', 'numeric');
		$this->form_validation->set_rules('celular', 'Celular', 'numeric');
		$this->form_validation->set_rules('barrio_id', 'Barrio', 'callback_barrio_check');
		$this->form_validation->set_message('barrio_check', "Debe seleccionar algun barrio.");
		$this->form_validation->set_rules('rol_id', 'Rol', 'callback_rol_check');
		$this->form_validation->set_message('rol_check', "Debe seleccionar algun rol.");

		if ($this->form_validation->run() == FALSE)
		{
			//Hago lo mismo que en la funcion agregar.
			
			$roles= $this->ModeloRol->getAllRoles();
			//Preparo el vector Roles para pasarle a la vista.
			foreach ($roles as $rol){
				$op[$rol['id']]= $rol['nombre'];
			}
	
			$this->data['roles'] =$op;	
				
			
			
			$city= $this->ModeloCiudad->getAllCiudades();
			//Preparo el vector Ciudades para pasarle a la vista.
			foreach ($city as $ciudad){
				$opciones[$ciudad['id']]= $ciudad['nombre'];
			}
	
			$this->data['ciudades'] =$opciones;
			$this->data['main']='usuarios/editar';
			$this->load->vars($this->data);
			$this-> load-> view('template');
		}
		else
		{
				$datos['id']=$_POST['id'];
				$datos['nombre']=$_POST['nombre'];
				$datos['apellido']=$_POST['apellido'];
				$datos['username']=strtolower($_POST['username']);//Username se guarda en minusculas.
				
				if($_POST['password']!="")
					$datos['password']=md5($_POST['password']);//El password se guarda en md5.
				
				$datos['apellido']=$_POST['apellido'];
				$datos['direccion']=$_POST['direccion'];
				$datos['barrio_id']=$_POST['barrio_id'];
				$datos['email']=$_POST['email'];
				$datos['telefono']=$_POST['telefono'];
				$datos['celular']=$_POST['celular'];
				$datos['rol_id']=$_POST['rol_id'];
				
				//Guardo los datos del producto en la base de datos.
				$nuevoProducto= new ModeloUsuario($datos);
				$nuevoProducto->actualizarUsuario();
				$this->session->set_flashdata('mensaje',"El usuario fue editado con exito.");
				redirect('/usuarios/listar');

		}
	}
	
	
	
	////////FUNCIONES COMPLEMENTARIAS////////
 	public function barrio_check($str)
	{
		//Si no es un numero es el valor "ape". O sea no eligio nada.
		return is_numeric($str);
		
	}
	public function rol_check($str) {
		//Si no es un numero es el valor "ape". O sea no eligio nada.
		return is_numeric($str);
	}
	
	/**
	 * Retorna un vector con los roles, de forma a que
	 * pueda ser utilizado en select de los formularios .
	 * @return unknown_type
	 */
	function traerRoles() {
		$roles= $this->ModeloRol->getAllRoles();
		//Preparo el vector Roles para pasarle a la vista.
		foreach ($roles as $rol){
			$op[$rol['id']]= $rol['nombre'];
		}
		return $op;
	}
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
	function traerSupervisores() {
		$s= $this->ModeloUsuario->getAllSupervisores();
		//Preparo el vector Roles para pasarle a la vista.
		foreach ($s as $s1){
			$op[$s1['id']]= $s1['username'];
		}
		return $op;
	}
	
 }
?>