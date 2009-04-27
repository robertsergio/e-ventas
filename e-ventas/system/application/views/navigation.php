<div class="titulonav">
		Operaciones
</div>
<div class="cuerporec">
	<?php
		$guardia=new Centinela();
	    $navlist=$guardia->operaciones();
	    if(count($navlist))
	    {
	        echo "<ul>";
	        foreach ($navlist as $nombre => $url) 
	        {
	            echo "<li>";
	            echo anchor($url,$nombre);
	            echo "</li>";
	              
	        }
	        echo "</ul>";
	        
	    }
	?>
</div>
