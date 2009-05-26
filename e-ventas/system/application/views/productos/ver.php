<h2>Lista de Productos</h2>

<img width="300" height="300" src="<?=base_url().$producto['imagen']?>"/>

<ul>
    <?php foreach ($producto as $key => $valor) {
    	if($key!='imagen')
    	{
    		if($key=='precio'|| $key=='comision')
    			echo '<li>'.ucfirst($key).': '.$valor.' Gs.</li>';
    		else
    			echo '<li>'.ucfirst($key).':</li>'.$valor;
    	}	
    		
    } ?>
    
    
     
</ul>

<?php echo anchor("productos/listar",'Volver');?>

