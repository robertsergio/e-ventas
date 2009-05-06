<?php
class Inicio extends Controller {
	var $_guardia=null;// El guardia maneja todo lo referente a la session del usuario.
	
	function Inicio() {
		parent::Controller();
		$this->_guardia=new Centinela();
	}
	
	/**
	 * Aca se debe manejar para crear las paginas de los vendedores.
	 * @return 
	 */
	function index($vendedor='') {
		if(!$vendedor)
			redirect('inicio/welcome');
		else
			show_error('Por ahora no hay nada.');
	}
	function welcome() {
		
		if($this->session->userdata('auth')=='true')
		{
			$this->data['main']='welcome';
			$this->load->vars($this->data);
			$this-> load-> view('template');	
		}else
			redirect('inicio/login');
		
	}
	
	/**
	 * Se utiliza para logear a un usuario.
	 * 
	 */
	function login() {
		$this->load->helper(array('form', 'url'));
		//Validacion de formulario.
		$this->load->library('form_validation');
		 
		$this->form_validation->set_error_delimiters('<div id="mensaje">', '</div>');
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this-> load-> view('usuarios/login');	
		}else
		{
			if($this->_guardia->login($_POST['username'],$_POST['password']))
			{
				$this->session->set_flashdata('mensaje','Bienvenido '.$this->session->userdata('nombre'));
				//Debemos rediregir a la pagina inicio del usuario.
				
				redirect('inicio/welcome');	
			}else{
				$this->session->set_flashdata('mensaje','Ups.. Autenticación Fallida.');
				redirect('inicio/login');
			}
		}
		
	}
	/**
	 * Cierra la sesion de un usuario.
	 * 
	 */
	function logout() {
		$this->_guardia->logout();
		redirect('inicio/login');
	}
	
	
}
?>