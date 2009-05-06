
<h2>Agregar Vendedor</h2>

<ul>
	<?php echo validation_errors(); ?>
	
</ul>
<?php echo form_open_multipart('usuarios/crearVendedor')?>
	<?php echo form_hidden('rol_id','3');//Envio el rol_id del vendedor.?>
	<?php echo form_hidden('supervisor_id',$creador_id);//Envio el rol_id del vendedor.?>
	<table>
		<tbody>
			<tr>
				<td><b>Nombres:</b></td>
				<td><?php echo form_input('nombre',set_value('nombre'));?></td>
			</tr>
			<tr>
			  	<td><b>Apellidos:</b></td>
				<td><?php echo form_input('apellido',set_value('apellido'));?></td>
			</tr>
			<tr>
				<td><b>Username:</b></td>
				<td><?php echo form_input('username',set_value('username'));?></td>
			</tr>
			<tr>
				<td><b>Contraseña:</b></td>
				<td><?php echo form_password('password',set_value('password'));?></td>
			</tr>
			<tr>
				<td><b>Confirmar Contraseña:</b></td>
				<td><?php echo form_password('co_password',set_value('co_password'));?></td>
			</tr>
			<tr>
				<td><b>Direccion:</b></td>
				<td><?php echo form_input('direccion',set_value('direccion'));?></td>
			</tr>
			<tr>
				<td><b>Ciudad:</b></td>
				<td>
					<select name="ciudad" id="ciudad" onchange="cargarBarrios()">
						<option value="ape">[Seleccione una Ciudad]</option>
        				<?php foreach($ciudades as $key => $value):?> 
        					<option value="<?=$key ?>"><?=$value ?></option>
        				<?php endforeach;?> 
        			</select>
				</td>
			</tr>
			<tr>
				<td><b>Barrio:</b></td>
				<td>
					<select name="barrio_id" id="barrio_id">
						<option value="ape">[Seleccione un Barrio]</option> 	 
        			</select>		
				</td>
			</tr>
			<tr>
				<td><b>Telefono:</b></td>
				<td><?php echo form_input('telefono',set_value('telefono'));?></td>
			</tr>
			<tr>
				<td><b>Celular:</b></td>
				<td><?php echo form_input('celular',set_value('celular'));?></td>
			</tr>
			<tr>
				<td><b>E_mail:</b></td>
				<td><?php echo form_input('email',set_value('email'));?></td>
			</tr>
			
        			
			
		</tbody>
	</table>
	<br>
	<br>
	<?php echo form_submit('agregar', 'Agregar'); ?>

<?php echo form_close()?>

<?php echo anchor("usuarios/listarVendedor",'Volver');?><br>