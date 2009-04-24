<?php
class Inicio extends Controller {
	function Inicio() {
		parent::Controller();
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
			$user=$this->ModeloUsuario->autenticar(strtolower($_POST['username']),md5($_POST['password']));
			if($user!=null)
			{
				$this->session->set_userdata($user);//El vector user ya tiene solo los datos necesarios.
				
				$navAdmin=array(
						'Gestionar Usuarios'=>'usuarios/',
						'Gestionar Productos'=>'productos/',
						'Gestionar Pedidos'=>'#',
						'Gestionar Clientes'=>'#',
						);
				$navVendedor=array(
						'Solicitar pedido'=>'#',
						'Consultar Comisiones'=>'#',
						'Gestionar Clientes'=>'#',
						'Gestionar Productos'=>'#',
						'Consultar Ventas'=>'#',
						'Ver Mensajes'=>'#',
						);
				$navSupervisor=array(
						'Gestionar Vendedores'=>'usuarios/',
						'Gestionar Pedidos'=>'#',
						'Gestionar Clientes'=>'#',
						'Consultar Pagos'=>'#',
						'Consultar Ventas'=>'#',
						'Ver Mensajes'=>'#',
						);
				
							
				$this->session->set_flashdata('mensaje','Bienvenido '.$user['nombre']);
				//Debemos rediregir a la pagina inicio del usuario.
				
				redirect('productos/');	
			}else{
				$this->session->set_flashdata('mensaje','Contraseña invalida.');
				redirect('inicio/login');
			}
		}
		
	}
	/**
	 * Cierra la sesion de un usuario.
	 * 
	 */
	function logout() {
		$this->session->sess_destroy();
		redirect('inicio/login');
	}
	
	
}
?>