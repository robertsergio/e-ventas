<h2>Ver Cliente</h2>


<ul>
    <li>Nombre: <?= $cliente['nombre']?></li> <br>
    <li>Apellido: <?= $cliente['apellido']?></li><br>
    <li>Ced. de Identidad: <?= $cliente['ci']?></li><br>
    <li>RUC: <?= $cliente['ruc']?></li><br>
    <li>Direccion: <?= $cliente['direccion']?></li><br>
    <li>Barrio: <?= $cliente['barrio']?></li><br>
    <li>Ciudad: <?= $cliente['ciudad']?></li><br>
    <li>Telefono: <?= $cliente['telefono']?></li><br>
    <li>Celular: <?= $cliente['celular']?></li><br>
    <?php if($rol_id!=3)://Si no es vendedor.?>
    	<li>Vendedor: <?= $cliente['vendedor']?></li><br>
    <?php endif;?>
    
</ul>

    <?php if($rol_id==3)://El link de volver, depende del rol.?>
		<?php echo anchor("clientes/mis_clientes",'Volver');?><br>		
	<?php else:?>
		<?php echo anchor("clientes/listar",'Volver');?><br>		
	<?php endif;?>

