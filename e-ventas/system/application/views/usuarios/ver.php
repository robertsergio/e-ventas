<h2>Ver <?= $usuario['rol']?></h2>


<ul>
    <li>Nombre: <?= $usuario['nombre']?></li> <br>
    <li>Username: <?= $usuario['username']?></li><br>
    <li>Direccion: <?= $usuario['direccion']?></li><br>
    <li>Barrio: <?= $usuario['barrio']?></li><br>
    <li>Ciudad: <?= $usuario['ciudad']?></li><br>
    <li>Telefono: <?= $usuario['telefono']?></li><br>
    <li>Celular: <?= $usuario['celular']?></li><br>
    <li>Rol:<?= $usuario['rol']?></li><br>
    <?php if($usuario['supervisor']): ?>
    	<li>Supervisor:<?= $usuario['supervisor']?></li><br>
    <?php endif;?>
</ul>

<?php echo anchor("usuarios/listar",'Volver');?>

