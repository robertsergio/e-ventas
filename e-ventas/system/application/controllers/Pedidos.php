<?php 
class Pedidos extends Controller
{
	function Pedidos() {
		parent::Controller();
	}
	
	function hacerPedido() {
		$productos=$this->session->userdata('cart');
		
	}
}




?>