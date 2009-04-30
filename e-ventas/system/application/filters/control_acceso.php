<?php

	
class Control_acceso_filter extends Filter
	{
		function before() 
		{
			$control=new Centinela(); 
         	if(!$control->conectado())
         		redirect('inicio/login');	
			elseif(!$control->checkPermiso())
         		show_error('Ups... Usted no tiene permiso para hacer eso...');
         	
		}
		function after() {
			
		}
	}
?>