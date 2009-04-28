<?php
	 $guardia=new Centinela();
	 $navlist=$guardia->operaciones();
	 if(count($navlist)):
	 	?>
	
	<div class="titulonav">
		<?php
			echo 'Operaciones';?>
	</div>
	<div class="cuerporec">
	    <?php 
	        echo "<ul>";
	        foreach ($navlist as $nombre => $url) 
	        {
	            echo "<li>";
	            echo anchor($url,$nombre);
	            echo "</li>";
	              
	        }
	        echo "</ul>";
	    ?>
    </div>       
	 <?php
	   endif;?>
	
