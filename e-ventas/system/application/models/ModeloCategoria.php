<?php

class ModeloCategoria extends Model{
    function ModeloCategoria(){
        parent::Model();
    }
    function getCategoria($id){
        $data = array();
        $options = array('id' => $id);
        $Q = $this-> db-> getwhere('categorias',$options,1);
        if ($Q->num_rows() > 0){
            $data = $Q-> row_array();
        }
        $Q-> free_result();
        return $data;
    }
    function getAllCategorias(){
        $data = array();
        $Q = $this-> db-> get('categorias');
     	if ($Q-> num_rows() > 0){
            foreach ($Q-> result_array() as $row){
                $data[] = array(
                    'id'=>$row['id'],
                    'nombre'=>$row['nombre'],
                    'descripcion'=>$row['descripcion'],
                    'categoria_id'=>$row['categoria_id']
                );
           }
        }
        $Q-> free_result();
        return $data;
    }
	function getAllSubCategorias($id)
	{    
		$data = array();
		$options = array('categoria_id' => $id);
        $Q = $this-> db-> getwhere('categorias',$options);
     	if ($Q-> num_rows() > 0){
            foreach ($Q-> result_array() as $row){
                $data[] = array(
                    'id'=>$row['id'],
                    'nombre'=>$row['nombre'],
                    'descripcion'=>$row['descripcion'],
                    'categoria_id'=>$row['categoria_id']
                );
           }
        }
        $Q-> free_result();
        return $data;
    }
}

?>
