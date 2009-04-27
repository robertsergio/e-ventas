
<h2>Editar Usuario</h2>

<ul>
	<?php echo validation_errors(); ?>
	
</ul>
<?php echo form_open_multipart('usuarios/actualizar')?>
	<?php echo form_hidden('id',$id);?>
	<table>
		<tbody>
			<tr>
				<td><b>Nombres:</b></td>
				<td><?php echo form_input('nombre',$usuario['nombre']);?></td>
			</tr>
			<tr>
			  	<td><b>Apellidos:</b></td>
				<td><?php echo form_input('apellido',$usuario['apellido']);?></td>
			</tr>
			<tr>
				<td><b>Username:</b></td>
				<td><?php echo form_input('username',$usuario['username']);?></td>
			</tr>
			<tr>
				<td><b>Contraseña:</b></td>
				<td><?php echo form_input('password');?></td>
			</tr>
			<tr>
				<td><b>Direccion:</b></td>
				<td><?php echo form_input('direccion',$usuario['direccion']);?></td>
			</tr>
			<tr>
				<td><b>Ciudad:</b></td>
				<td>
					<select name="ciudad" id="ciudad" onchange="cargarBarrios()">
						<option value="ape">[Seleccione una Ciudad]</option>
        				<?php foreach($ciudades as $key => $value)
        					{
			        			if($key==$usuario['ciudad_id'])
			        			{
			        				echo '<option value="'.$key.'" selected="selected" >'.$value.'</option>';
			        			}else
			        			{
			        				echo '<option value="'.$key.'">'.$value.'</option>';
			        			}			
        					}			
        				?> 
        					
        					
        				 
        			</select>
				</td>
			</tr>
			<tr>
				<td><b>Barrio:</b></td>
				<td>
					<select name="barrio_id" id="barrio_id">
						<option value="ape">[Seleccione un Barrio]</option> 
						<?php foreach($barrios as $key => $value)
        					{
			        			if($key==$usuario['barrio_id'])
			        			{
			        				echo '<option value="'.$key.'" selected="selected" >'.$value.'</option>';
			        			}else
			        			{
			        				echo '<option value="'.$key.'">'.$value.'</option>';
			        			}			
        					}			
        				?>	 
        			</select>		
				</td>
			</tr>
			<tr>
				<td><b>Telefono:</b></td>
				<td><?php echo form_input('telefono',$usuario['telefono']);?></td>
			</tr>
			<tr>
				<td><b>Celular:</b></td>
				<td><?php echo form_input('celular',$usuario['celular']);?></td>
			</tr>
			<tr>
				<td><b>E_mail:</b></td>
				<td><?php echo form_input('email',$usuario['email']);?></td>
			</tr>
			<tr>
				<td><b>Rol:</b></td>
				<td>
					<select name="rol_id" id="rol_id" >
						<option value="ape">[Seleccione un Rol]</option>
        				<?php foreach($roles as $key => $value)
        					{
			        			if($key==$usuario['rol_id'])
			        			{
			        				echo '<option value="'.$key.'" selected="selected" >'.$value.'</option>';
			        			}else
			        			{
			        				echo '<option value="'.$key.'">'.$value.'</option>';
			        			}			
        					}			
        				?>	  
        			</select>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<br>
	<?php echo form_submit('guardar', 'Guardar'); ?>

<?php echo form_close()?>

<?php echo anchor("usuarios/",'Volver');?><br>