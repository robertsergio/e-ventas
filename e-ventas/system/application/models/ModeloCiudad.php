<?php
class ModeloCiudad extends Model{
    function ModeloCiudad(){
        parent::Model();
    }
    function getCiudad($id){
        $data = array();
        $options = array('id' => $id);
        $Q = $this-> db-> getwhere('ciudades',$options,1);
        if ($Q->num_rows() > 0){
            $data = $Q-> row_array();
        }
        $Q-> free_result();
        return $data;
    }
    function getAllCiudades(){
        $data = array();
        $Q = $this-> db-> get('ciudades');
     	if ($Q-> num_rows() > 0){
            foreach ($Q-> result_array() as $row){
                $data[] = array(
                    'id'=>$row['id'],
                    'nombre'=>$row['nombre'],
                );
           }
        }
        $Q-> free_result();
        return $data;
    }
    /**
     * Trae todos los barrios de una ciudad determinada.
     * @param $id id de la ciudad.
     * @return vector con todos los barrio, donde cada componente es una fila de BD.
     */
	function getAllBarrios($id)
	{    
		$data = array();
		$options = array('ciudad_id' => $id);
        $Q = $this-> db-> getwhere('barrios',$options);
     	if ($Q-> num_rows() > 0){
            foreach ($Q-> result_array() as $row){
                $data[] = array(
                    'id'=>$row['id'],
                    'nombre'=>$row['nombre'],
                    'ciudad_id'=>$row['ciudad_id']
                );
           }
        }
        $Q-> free_result();
        return $data;
    }
    
}
?>