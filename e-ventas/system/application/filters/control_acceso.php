<?php

	
class Control_acceso_filter extends Filter
	{
		function before() 
		{
			$CI =& get_instance();
			        
         	if($CI->session->userdata('nombre')==null)
         	{
         		redirect('inicio/login');	
         	}
			
			
			
		}
		function after() {
			
		}
	}
?>