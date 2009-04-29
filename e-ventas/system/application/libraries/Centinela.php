<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Centinela 
{
	var $_CI=null;
	function Centinela() 
	{
		 $this->_CI=& get_instance();
	}
	/**
	 * Verifica el login de un usuario.
	 * @return Retorna false si el usuario o contrasenha no corresponden.
	 */
	function login($nombre=null, $pwd=null) 
	{
		
		if($nombre==null || $pwd==null)
			return false;
		else
		{
			$user=$this->_CI->ModeloUsuario->autenticar(strtolower($nombre),md5($pwd));
			if($user!=null)
			{
				$this->_CI->session->set_userdata($user);
				return true;
			}
			return false;	
		}
		
	}
	/**
	 * Define un vector con las operaciones que puede realizar un rol determinado.
	 * Retorna null, si es que la session no esta creada.
	 * @return 
	 */
	function operaciones() {
		$navAdmin=array(
						'Gestionar Usuarios'=>'usuarios/',
						'Gestionar Productos'=>'productos/',
						'Gestionar Pedidos'=>'#',
						'Gestionar Clientes'=>'#',
						'Ver Mensajes'=>'#',
						);
		$navVendedor=array(
						'Solicitar pedido'=>'productos/carrito',
						'Consultar pedidos'=>'#',
						'Consultar Comisiones'=>'#',
						'Gestionar Clientes'=>'#',
						'Cambiar Pagina de Inicio'=>'#',
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
		$rol_id= $this->_CI->session->userdata('rol_id');
		
		if($rol_id!=null)
		{
			if($rol_id==1)
				return $navAdmin;
			elseif($rol_id==2)
				return $navSupervisor;
			else
				return $navVendedor;	
		}else
			return null;
		
	}
	function logout() 
	{
		$this->_CI->session->sess_destroy();
		
	}
	/**
	 * Verifica si existe alguien logeado.
	 * @return booleano
	 */
	function conectado() {
		if($this->_CI->session->userdata('nombre'))
			return true;
		else
			return false;
	}
	
}
?>