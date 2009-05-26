<?php 
class Pedidos extends Controller
{
	var $data;
	function Pedidos() {
		parent::Controller();
	}
	
	function hacerPedido() {
		$this->data['cart']=$this->session->userdata('cart');
		$this->data['precioTotal']=$this->session->userdata('precioTotal');
		$this->data['comisionTotal']=$this->session->userdata('comisionTotal');
		$this->data['user_id']=$this->session->userdata('id');
		 
		
		$this->data['main']='pedidos/pedido_de_compra';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
	public function ajaxFindCliente() {
		$ci_client=$this->input->post('ci');
		$user_id=$this->session->userdata('id');
		
		$cliente=$this->ModeloCliente->buscarClienteDeVendedor($user_id,$ci_client);
		if($cliente!='')
		{
			$salida='<input type="hidden" name="cliente_id" value='.$user_id.'/>'.
			'<b>Nombre:</b>'.$cliente['nombre'].'<br>'.'<b>Apellido:</b>'.$cliente['apellido'].'<br>'
			.'<b>Ruc:</b>'.$cliente['ruc'].'<br>'.'<b>Direccion:</b>'.$cliente['direccion'].'<br>'
			.'<b>Telefono:</b>'.$cliente['telefono'].'<br>';
			echo $salida;	
		}else
			echo "<b>No existe el cliente.</b>";
		
		 
	}
	/**
	 * @todo Falta guardar en la base de datos.
	 * @return unknown_type
	 */
	public function guardarPedido() {
		$datos=$_POST;
		//borro un dato basura que no me sirve.
		unset($datos['guardar']);
		unset($datos['cliente']);
		
		//Guardo los datos del producto en la base de datos.
		$nuevoPedido= new ModeloPedido($datos);
		$nuevoPedido->agregarPedido();
		$this->session->set_flashdata('mensaje',"El pedido fue agregado con exito.");
		redirect('/pedidos/mis_pedidos');
	}
	
	/**
	 * @todo Falta hacer la lista de mis pedidos.
	 * @return unknown_type
	 */
	public function mis_pedidos() {
		
		
		$this->data['main']='pedidos/pedido_de_compra';
		$this->load->vars($this->data);
		$this-> load-> view('template');
	}
	
}




?>