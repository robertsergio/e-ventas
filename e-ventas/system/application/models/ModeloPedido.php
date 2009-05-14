<?php
class ModeloPedido extends Model {
	var $datos= null;//Debe tener los datos necesarios para insertar en la tabla pedidos.
	var $productos= null;//Debe tener los datos necesarios para insertar en la tabla pedido_tiene_producto
	/**
	 * Es el constructor de la clase. No se por que el parametro se debe igualar a null.
	 * @param $dat Datos que identifica a un pedido.
	 * @return unknown_type
	 */
	public function __construct($dat=null,$productos=null)
	{
		parent::Model();
		$this->datos=$dat;
		$this->productos=$productos;
	}
	
	function agregarPedido() {
		$this->db->trans_start();
		$this->db->insert('pedidos',$this->datos);
		$this->db->trans_complete();
		if($this->db->trans_status()== FALSE)
			show_error('Ha ocurrido un error al intentar asignar un producto a un pedido.');
		
	}
	/**
	 * Agrega productos a un pedido en especifico.
	 * @param $productos Es un vector que contiene los productos a ser insertados.
	 * @return unknown_type
	 */
	function agregarProductoAPedido() {
		if($this->datos==null || $this->productos==null)
			show_error("ERROR al agregar productos a un pedido, Constructor mal usado.");
		else
		{
			foreach ($this->productos as $key => $valor) {
				$data = array(
                    'pedido_id'=>$this->datos['id'],
					'producto_id'=>$key,
                    'precio_unitario'=>$valor['precio'],
					'cantidad'=>$valor['cantidad'],
					'comision_actual'=>$valor['comision'],
				);
				$this->db->trans_start();
				$this->db->insert('pedido_tiene_producto',$data);
				$this->db->trans_complete();
				if($this->db->trans_status()== FALSE)
				{
					show_error('Ha ocurrido un error al intentar asignar un producto a un pedido.');
				}
			}
		}
	}
}
?>