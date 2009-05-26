<?php

/**
 * Short description of class ModeloProductos
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 */
class ModeloProducto  extends Model
{
	 
	var $datos= null;
	/**
	 * Es el constructor de la clase. No se por que el parametro se debe igualar a null.
	 * @param $dat Datos que identifica a un producto.
	 * @return unknown_type
	 */
	public function __construct($dat=null)
	{
		parent::Model();
		$this->datos=$dat;
		
	}

	public function agregarProducto()
	{
		
		
		if($this->datos!=null)
		{
			$this->db->trans_start();
			$this->db->insert('productos',$this->datos);
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar insertar un producto en la base de datos.');
			}
		}
		 
	}

	/**
	 * Se utiliza para instanciar
	 *
	 * @access public
	 * @author firstname and lastname of author, <author@example.org>
	 * @return mixed
	 */
	public function actualizarProducto()
	{
		if($this->datos!=null && $this->datos['id']!=null)
		{
			$this->db->trans_start();
			$this->db->update('productos',$this->datos,array('id'=>$this->datos['id']));
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar actualizar un producto en la base de datos.');
			}
		}
	}

	/**
	 * Se borra un elemento.
	 *
	 * @access public
	 * @author firstname and lastname of author, <author@example.org>
	 * @return Boolean
	 */
	public function borrarProducto($id)
	{
		$this->datos['borrado']=TRUE;
		$this->datos['id']=$id;
		if($this->datos!=null && $this->datos['id']!=null)
		{
			$this->db->trans_start();
			$this->db->update('productos',$this->datos,array('id'=>$this->datos['id']));
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar borrar un producto en la base de datos.');
			}
		}
	}
	public function getProducto($id)
	{
		$data = array();
		$options = array('id' => $id);
		$Q = $this-> db-> getwhere('productos',$options,1);
		if ($Q->num_rows() > 0){
			$data = $Q-> row_array();
		}
		$Q-> free_result();
		//Traigo el nombre de la categoria.
		$manejarCategoria=new ModeloCategoria();
		$categoria=$manejarCategoria->getCategoria($data['categoria_id']);
		$data['categoria']=$categoria['nombre'];

		return $data;
	}
	
	/**
	 * Trae la cantidad de productos definido por $cantidad,
	 * desde la fila definida por $offset.
	 * @return Array con todas las filas.
	 */
	public function getAllProductos($cantidad=0, $offset=0)
	{
		$data = array();
		$this-> db-> select('id,nombre,descripcion,precio,imagen');
		$this-> db-> where('borrado','false');
		
		if($cantidad==0)
			$Q = $this-> db-> get('productos');
		else
			$Q = $this-> db-> get('productos',$cantidad,$offset);

		if ($Q-> num_rows() > 0){
			foreach ($Q-> result_array() as $row){


				$data[] = array(
                    'id'=>$row['id'],
                    'nombre'=>$row['nombre'],
                    'precio'=>$row['precio'],
					'imagen'=>$row['imagen'],
					'descripcion'=>$row['descripcion'],
				);
			}
		}
		$Q-> free_result();
		return $data;
	}
	public function cantidad_filas()
	{
		$query =$this->db->getwhere('productos',array('borrado'=>'false'));
		return $query->num_rows();
	}

} /* end of class ModeloProductos */

?>