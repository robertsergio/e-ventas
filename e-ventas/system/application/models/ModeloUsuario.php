<?php
/**
 * Clase Modelo de la tabla Usuarios.
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 */
class ModeloUsuario extends Model
{
	public $datos= null;



	
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
   
	public function agregarUsuario()
	{
		
		
		if($this->datos!=null)
		{
			$this->db->trans_start();
			$this->db->insert('usuarios',$this->datos);
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar insertar un producto en la base de datos.');
			}
		}
		 
	}

    
    public function actualizarUsuario()
    {
    	if($this->datos!=null && $this->datos['id']!=null)
		{
			$this->db->trans_start();
			$this->db->update('usuarios',$this->datos,array('id'=>$this->datos['id']));
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar actualizar un producto en la base de datos.');
			}
		}
    }

    public function borrarUsuario($id)
    {
    	$this->datos['borrado']=TRUE;
		$this->datos['id']=$id;
		if($this->datos!=null && $this->datos['id']!=null)
		{
			$this->db->trans_start();
			$this->db->update('usuarios',$this->datos,array('id'=>$this->datos['id']));
			$this->db->trans_complete();
			if($this->db->trans_status()== FALSE)
			{
				show_error('Ha ocurrido un error al intentar borrar un usuario en la base de datos.');
			}
		}
    }
    
	public function getUsuario($id)
	{
		$data = array();
		$consulta="SELECT
						  b.barrio_nombre as barrio,
						  b.ciudad_nombre as ciudad,
						  b.ciudad_id as ciudad_id,
					      roles.nombre as rol,
						  usuarios.nombre,
						  usuarios.email,
						  usuarios.username,
						  usuarios.password,
						  usuarios.fecha_nac,
						  usuarios.telefono,
						  usuarios.celular,
						  usuarios.ci,
						  usuarios.direccion,
						  usuarios.apellido,
						  usuarios.rol_id,
						  usuarios.barrio_id,
						  usuarios.supervisor_id,
						  supervisor.nombre as supervisor
					FROM
					      usuarios
					      LEFT  JOIN usuarios as supervisor ON (supervisor.id=usuarios.supervisor_id)
						  INNER JOIN (select barrios.id as barrio_id, ciudades.id as ciudad_id,ciudades.nombre as ciudad_nombre, barrios.nombre as barrio_nombre 
					                   from barrios, ciudades 
					                   where barrios.ciudad_id=ciudades.id)as b 
					          ON (usuarios.barrio_id=b.barrio_id)
						  INNER JOIN roles ON (usuarios.rol_id=roles.id)
						  WHERE
						      usuarios.id=$id;
					";
					
		
		
		$query =$this->db->query($consulta);
		
		if ($query->num_rows() > 0)
		{
   		   $row = $query->row_array();
		   
		} 
			
		$query-> free_result();
		return $row;
	}
	/**
	 * Trae la cantidad de usuarios definido por $cantidad,
	 * desde la fila definida por $offset.
	 * Si $cantidad es igual a cero, se trae todos los usuarios.
	 * @return Array con todas las filas.
	 */
	public function getAllUsuarios($cantidad=0, $offset=0)
	{
		$data = array();
		$this-> db-> select('usuarios.id,usuarios.nombre, usuarios.apellido,usuarios.username,roles.nombre as rol_nombre');
		$this-> db-> where('borrado','false');
		$this->db->join('roles','usuarios.rol_id=roles.id');
		if($cantidad==0)
			$Q = $this-> db-> get('usuarios');
		else
			$Q = $this-> db-> get('usuarios',$cantidad,$offset);

		if ($Q-> num_rows() > 0){
			foreach ($Q-> result_array() as $row){
				foreach($row as $_ind => $_val): 
					$vec[$_ind] = $_val;  
				endforeach;
				$data[] = $vec;
				
				
				
			}
		}
		$Q-> free_result();
		
		
		return $data;
	}
	
	/**
	 * Trae la cantidad de vendedores definido por $cantidad,
	 * desde la fila definida por $offset y que son del supervisor con $id.
	 * Si $cantidad es igual a cero, se trae todos los vendedores.
	 * Si $id es igual a cero, se trae todos los vendedores.
	 * Los usuarios con rol_id igual a 3 son considerados vendedores.
	 * @return Array con todas las filas.
	 */
	public function getAllVendedores($id=0, $cantidad=0, $offset=0)
	{
		$data = array();
		$this-> db-> select('usuarios.id,usuarios.nombre, usuarios.apellido,usuarios.username,roles.nombre as rol_nombre');
		if($id==0)
			$this-> db-> where(array('borrado'=>'false','rol_id'=>'3'));
		else
			$this-> db-> where(array('borrado'=>'false','rol_id'=>'3','supervisor_id'=>$id));
			
		$this->db->join('roles','usuarios.rol_id=roles.id');
		if($cantidad==0)
			$Q = $this-> db-> get('usuarios');
		else
			$Q = $this-> db-> get('usuarios',$cantidad,$offset);

		if ($Q-> num_rows() > 0){
			foreach ($Q-> result_array() as $row){
				foreach($row as $_ind => $_val): 
					$vec[$_ind] = $_val;  
				endforeach;
				$data[] = $vec;
				
				
				
			}
		}
		$Q-> free_result();
		
		
		return $data;
	}
	/**
	 * Trae la cantidad de supervisores definido por $cantidad,
	 * desde la fila definida por $offset.
	 * Si $cantidad es igual a cero, se trae todos los vendedores.
	 * Los usuarios con rol_id igual a 3 son considerados vendedores.
	 * @return Array con todas las filas.
	 */
	public function getAllSupervisores($cantidad=0, $offset=0)
	{
		$data = array();
		$this-> db-> select('usuarios.id,usuarios.nombre, usuarios.apellido,usuarios.username,roles.nombre as rol_nombre');
		$this-> db-> where(array('borrado'=>'false','rol_id'=>'2'));
		$this->db->join('roles','usuarios.rol_id=roles.id');
		if($cantidad==0)
			$Q = $this-> db-> get('usuarios');
		else
			$Q = $this-> db-> get('usuarios',$cantidad,$offset);

		if ($Q-> num_rows() > 0){
			foreach ($Q-> result_array() as $row){
				foreach($row as $_ind => $_val): 
					$vec[$_ind] = $_val;  
				endforeach;
				$data[] = $vec;
		
			}
		}
		$Q-> free_result();
		
		
		return $data;
	}
	
	/**
	 * Calcula la cantidad de usuarios que tiene el sistema.
	 * @return La cantidad de usuarios.
	 */
	public function cantidad_filas()
	{
		$query =$this->db->getwhere('usuarios',array('borrado'=>'false'));
		return $query->num_rows();
	}
	
	/**
	 * Calcula la cantidad de vendedores que tiene asignado un supervisor. Si no se
	 * envia el id, se trae la cantidad de vendedores que tiene el sistema. El rol con id igual a 3
	 * es el considerado como vendedor.
	 * @param $id El id del supervisor.
	 * @return unknown_type
	 */
	public function cantidad_vendedores($id=0)
	{
		if($id==0)
			$query =$this->db->getwhere('usuarios',array('borrado'=>'false','rol_id'=>'3'));
		else
			$query =$this->db->getwhere('usuarios',array('borrado'=>'false','rol_id'=>'3','supervisor_id'=>$id));	
		return $query->num_rows();
	}
	
	/**
	 * Autentica a un usuario y retorna un vector con los valores utiles para guardar en la session.
	 * @param $usuario Username del usuario en minusculas.
	 * @param $pwd es el password convertido a md5.
	 * @return Un vector con los datos del usuario.
	 */
	public function autenticar($usuario,$pwd) {
		$data = array();
		$consulta='select * from usuarios where username="'.$usuario.'" and password="'.$pwd.'"'.'and borrado=false';
		$query =$this->db->query($consulta);
		if ($query->num_rows() > 0)
		{
   		   $row = $query->row_array();
   		   //Saco solo los datos utiles.
   		   $data=array(
   		   		'id'=>$row['id'],
   		   		'nombre'=>$row['nombre'],
   		   		'rol_id'=>$row['rol_id'],
   		   		'auth'=>'true',
   		   );
		   $query-> free_result();
		   return $data; 
		} 
		$query-> free_result();
		return null;
	}
       

} /* end of class ModeloUsuarios */

?>