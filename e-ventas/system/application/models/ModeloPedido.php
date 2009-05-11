<?php
class ModeloPedido extends Model {
	var $datos= null;
	/**
	 * Es el constructor de la clase. No se por que el parametro se debe igualar a null.
	 * @param $dat Datos que identifica a un pedido.
	 * @return unknown_type
	 */
	public function __construct($dat=null)
	{
		parent::Model();
		$this->datos=$dat;
	}
}
?>