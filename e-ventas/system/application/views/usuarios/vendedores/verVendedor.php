<h2>Lista de Vendedor</h2>


<ul>
    <li>Nombre: <?= $usuario['nombre']?></li> <br>
    <li>Apellido: <?= $usuario['apellido']?></li> <br>
    <li>Cédula de Identidad: <?= $usuario['ci']?$usuario['ci']:'No tiene.';?></li><br>
    <li>Fecha de Nacimiento: <?= $usuario['fecha_nac']?$usuario['fecha_nac']:'No tiene.';?></li><br>
     <li>Direccion: <?= $usuario['direccion']?></li><br>
    <li>Barrio: <?= $usuario['barrio']?></li><br>
    <li>Ciudad: <?= $usuario['ciudad']?></li><br>
    <li>Telefono: <?= $usuario['telefono']?></li><br>
    <li>Celular: <?= $usuario['celular']?></li><br>
    <li>Username: <?= $usuario['username']?></li><br>
    <li>Supervisor: <?= $usuario['supervisor']?></li><br>
   
    
	
    
</ul>

<?php echo anchor("usuarios/listarVendedor",'Volver');?>

