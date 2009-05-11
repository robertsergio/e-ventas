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
	 * Retorna un vector que luego es utilizada para generar en la vista
	 * la barra de operaciones.
	 * Retorna null, si es que la session no esta creada.
	 * @return Vector de Operaciones
	 */
	function operaciones() {
		$navAdmin=array(
						'Gestionar Usuarios'=>'usuarios/listar',
						'Gestionar Productos'=>'productos/listar',
						'Gestionar Pedidos'=>'#',
						'Consultar Comisiones'=>'#',
						'Gestionar Clientes'=>'clientes/listar',
						'Registrar Pagos'=>'#',
						'Mensajes'=>'#',
						);
		$navVendedor=array(
						'Solicitar pedido'=>'productos/carrito',
						'Consultar pedidos'=>'#',
						'Consultar Comisiones'=>'#',
						'Gestionar Clientes'=>'clientes/mis_clientes',
						'Cambiar Pagina de Inicio'=>'#',
						'Consultar Ventas'=>'#',
						'Ver Mensajes'=>'#',
						);
		$navSupervisor=array(
						'Gestionar Vendedores'=>'usuarios/listarVendedor',
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
	/**
	 * Verifica si un usuario puede realizar una determinada operacion.
	 * Retorna false si no puede realizar una operacion, sino retorna true.
	 * @return boolean
	 */
	function checkPermiso() 
	{
		if($this->_CI->session->userdata('nombre')!=null)
		{
			$permisos=$this->getPermisos();
			$controladorUrl=$this->_CI->uri->segment(1);//Saco el nombre del modulo de la uri.
			$operacionUrl=$this->_CI->uri->segment(2);//Saco el nombre del modulo de la uri.
			if($permisos!=null && $controladorUrl!=false && $operacionUrl!=false)
			{
				if($controladorUrl==null)
						return false;
				else
				{
						$vecOper=$permisos[$controladorUrl];
						if ($vecOper!='')
						{
							foreach ($vecOper as $accion) {
								if($accion==$operacionUrl)
									return true;
							}
					
						}	
						
						
				}
										
			}
		}
		return false;
	}
	/**
	 * Retorna los permisos que tiene un determinado rol.
	 * @return unknown_type
	 */
	function getPermisos() {
		//El vector de permisos tiene como clave el nombre del controlador y valor el nombre de la operacion.
		$Admin=array(
						'usuarios'=>array('listar','ver','borrar','editar','agregar','crear','actualizar'),
						'productos'=>array('listar','ver','borrar','editar','agregar','crear','actualizar'),
						'clientes'=>array('listar','ver','borrar','editar','agregar','crear','actualizar'),
					);
		$Vendedor=array(
						'productos'=>array('carrito','agregarCarrito','verCarrito')
						
						);
		$Supervisor=array(
						'usuarios'=>array('listarVendedor','verVendedor','borrarVendedor','editarVendedor','agregarVendedor','crearVendedor','actualizarVendedor')
						);
		
		$rol_id= $this->_CI->session->userdata('rol_id');
		
		if($rol_id!=null)
		{
			if($rol_id==1)
				return $Admin;
			elseif($rol_id==2)
				return $Supervisor;
			else
				return $Vendedor;	
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