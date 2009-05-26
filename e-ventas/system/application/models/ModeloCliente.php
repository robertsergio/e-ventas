<?php
class ModeloCliente extends Model {
	var $datos= null;
	/**
	 * Es el constructor de la clase. No se por que el parametro se debe igualar a null.
	 * @param $dat Datos que identifica a un cliente.
	 * @return unknown_type
	 */
	public function __construct($dat=null)
	{
		parent::Model();
		$this->datos=$dat;
	}
	public function agregarCliente()
	{
		if($this->datos!=null)
		{
			$this->db->trans_start();
			$this->db->insert('clientes',$this->datos);
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar insertar un cliente en la base de datos.');
			}
		}
		 
	}

	public function actualizarCliente()
	{
		if($this->datos!=null && $this->datos['id']!=null)
		{
			$this->db->trans_start();
			$this->db->update('clientes',$this->datos,array('id'=>$this->datos['id']));
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar actualizar un cliente en la base de datos.');
			}
		}
	}
	public function borrarCliente($id)
	{
		$this->datos['borrado']=TRUE;
		$this->datos['id']=$id;
		if($this->datos!=null && $this->datos['id']!=null)
		{
			$this->db->trans_start();
			$this->db->update('clientes',$this->datos,array('id'=>$this->datos['id']));
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar borrar un cliente en la base de datos.');
			}
		}
	}
	
	/**
	 * Traigo los datos necesarios de un cliente en particular.
	 * @param $id
	 * @return unknown_type
	 */
	public function getCliente($id)
	{
		$consulta="select clientes.*, b.*, usuarios.username as vendedor
 					from clientes
 						inner join usuarios on (clientes.vendedor_id=usuarios.id)
 						inner join (select barrios.id as barrio_id, 
                    					   barrios.nombre as barrio, 
                    					   ciudades.nombre as ciudad,
                    					   ciudades.id as ciudad_id 
             						from barrios 
                  						inner join ciudades on (barrios.`ciudad_id`=ciudades.id)
            						) as b
 						on (clientes.`barrio_id`=b.barrio_id)
 					where
     					clientes.id=$id";
		
		$query =$this->db->query($consulta);
		
		if ($query->num_rows() > 0)
		{
   		   $row = $query->row_array();
		   $query-> free_result();
		    return $row;
		} 
			
		return null;
	}
	
	
	/**
	 * Trae todos los clientes que le pertenecen al vendedor con id dado,
	 * trayendo la cantidad de registros especificado, a partir de un registro 
	 * dado. Si no se especifica el id se traen todos los clientes, lo mismo sucede
	 * cuando no se especifica la cantidad.
	 * @param $id_vendedor Es el id del vendedor.
	 * @param $cantidad Numero de registros que se quiere recuperar.
	 * @param $offset Desde que registro se quiere traer.
	 */
	public function getAllClientes($cantidad=0, $offset=0,$id_vendedor=0)
	{
		$data = array();
		$this-> db-> select('id,nombre,ruc,telefono');
		$this-> db-> where('borrado','false');
		
		if($id_vendedor!=0)
			$this-> db-> where('vendedor_id',$id_vendedor);
		
		if($cantidad==0)
			$Q = $this-> db-> get('clientes');
		else
			$Q = $this-> db-> get('clientes',$cantidad,$offset);

		if ($Q-> num_rows() > 0){
			foreach ($Q-> result_array() as $row){
				$data[] = array(
                    'id'=>$row['id'],
                    'nombre'=>$row['nombre'],
                    'ruc'=>$row['ruc'],
                    'telefono'=>$row['telefono'],
				);
			}
		}
		$Q-> free_result();
		return $data;
	}
	
	/**
	 * Trae la cantidad de clientes que tiene un vendedor especificado. 
	 * Si no se especifica el vendedor, se trae la cantidad total de clientes
	 * que tiene el sistema.
	 * @param $id_vendedor Es el id del vendedor.
	 */
	public function cantidad_filas($id_vendedor=0)
	{
		if($id_vendedor!=0)
			$query =$this->db->getwhere('clientes',array('borrado'=>'false','vendedor_id'=>$id_vendedor));
		else
			$query =$this->db->getwhere('clientes',array('borrado'=>'false'));
		return $query->num_rows();
	}
	public function buscarClienteDeVendedor($id_vendedor,$ci_cliente) {
		$consulta="select * from clientes where ci=$ci_cliente and vendedor_id=$id_vendedor";
		
		$query =$this->db->query($consulta);
		
		if ($query->num_rows() > 0)
		{
   		   $row = $query->row_array();
		   $query-> free_result();
		    return $row;
		} 
			
		return null;
	}
}
?>