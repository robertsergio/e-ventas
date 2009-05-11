
<h2>Editar Cliente</h2>

<ul>
	<?php echo validation_errors(); ?>
	
</ul>
<?php echo form_open_multipart('clientes/actualizar')?>
	<?php echo form_hidden('id',$id);?>
	<table>
		<tbody>
			<tr>
				<td><b>Nombres:</b></td>
				<td><?php echo form_input('nombre',$cliente['nombre']);?></td>
			</tr>
			<tr>
			  	<td><b>Apellidos:</b></td>
				<td><?php echo form_input('apellido',$cliente['apellido']);?></td>
			</tr>
			<tr>
				<td><b>Ced. de Identidad:</b></td>
				<td><?php echo form_input('ci',$cliente['ci']);?></td>
			</tr>
			<tr>
				<td><b>R.U.C:</b></td>
				<td><?php echo form_input('ruc',$cliente['ruc']);?></td>
			</tr>
			<tr>
				<td><b>Direccion:</b></td>
				<td><?php echo form_input('direccion',$cliente['direccion']);?></td>
			</tr>
			<tr>
				<td><b>Ciudad:</b></td>
				<td>
					<select name="ciudad" id="ciudad" onchange="cargarBarrios()">
						<option value="ape">[Seleccione una Ciudad]</option>
        				<?php foreach($ciudades as $key => $value)
        					{
			        			if($key==$cliente['ciudad_id'])
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
			        			if($key==$cliente['barrio_id'])
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
				<td><?php echo form_input('telefono',$cliente['telefono']);?></td>
			</tr>
			<tr>
				<td><b>Celular:</b></td>
				<td><?php echo form_input('celular',$cliente['celular']);?></td>
			</tr>
			<tr>
				<td><b>E_mail:</b></td>
				<td><?php echo form_input('email',$cliente['email']);?></td>
			</tr>
			
			<tr>
				<td><b>Vendedor:</b></td>
					<td>
						<select name="vendedor_id" id="vendedor_id" >
							<option value="ape">[Seleccione un Vendedor]</option>
	        				<?php foreach($vendedores as $key => $value)
	        				{ 
	        					if($key==$cliente['vendedor_id'])
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

<?php echo anchor("clientes/listar",'Volver');?><br>