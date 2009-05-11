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
    <li>Vendedor:<?= $cliente['vendedor']?></li><br>
    
</ul>

<?php echo anchor("clientes/listar",'Volver');?>

