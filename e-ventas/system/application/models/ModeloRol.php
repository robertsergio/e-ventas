<?php
class ModeloRol extends Model{
    function ModeloRol(){
        parent::Model();
    }
    function getRol($id){
        $data = array();
        $options = array('id' => $id);
        $Q = $this-> db-> getwhere('roles',$options,1);
        if ($Q->num_rows() > 0){
            $data = $Q-> row_array();
        }
        $Q-> free_result();
        return $data;
    }
    function getAllRoles(){
        $data = array();
        $Q = $this-> db-> get('roles');
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
	
    
}
?>