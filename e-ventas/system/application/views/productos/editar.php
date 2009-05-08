<h1>Editar Producto</h1>
<?php echo form_open_multipart('productos/actualizar')?>
	<?php echo form_hidden('id',$id);?>
	<p> 
		<b>Nombre:</b>
		<?php echo form_input('nombre',$producto['nombre']);?>
	</p>
	<p>
		<b>Descripcion:</b>
		<?php echo form_textarea('descripcion',$producto['descripcion']);?>
	</p>
	
	<p>
		<b>Precio:</b>
		<?php echo form_input('precio',$producto['precio']);?>	
	</p>
	<p>
		<b>Comision:</b>
		<?php 
			$options = array(
                  '0'  => '0%',
			      '0.1'  => '10%',
                  '0.2'  => '20%',
                  '0.3'  => '30%',
                  '0.4'  => '40%',
				  '0.5'  => '50%',
                  '0.6'  => '60%',
                  '0.7'  => '70%',
                  '0.8'  => '80%',
				  '0.9'  => '90%',
				  '1'  => '100%',
                );
                echo form_dropdown('comision', $options, $producto['comision']);
		?>	
	</p>
	<p>
		<b>Categoria:</b>
		<select name="categoria" id="categoria">
			<option value="ape">[Selecione Categoria]</option>
        	<?php
        	foreach($categorias as $key => $value) 
        	{
        	   if($key==$producto['categoria_id'])
        	   {
        			echo "<option selected value='$key'>$value</option>";	
        	   }else	
        	   {
        			echo "<option value='$key'>$value</option>";
        	   }	        		
        		
        	}
        	?> 
        </select>
			
	</p>
	
	<p> 
		<b>Imagen:</b>
		<input type="file" name="imagen" id="imagen" size="20"  />
	</p>
	<?php echo form_submit('guardar', 'Guardar'); ?>
		

<?php echo form_close();?>

<?php echo anchor("productos/listar",'Volver');?><br>