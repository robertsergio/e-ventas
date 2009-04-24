
<h2>Agregar Producto</h2>

<ul>
	<?php echo validation_errors(); ?>
	<?php if(isset($mensaje)) echo '<li>'.$mensaje.'/li';?>
</ul>
<?php echo form_open_multipart('productos/crear')?>
	<p> 
		<b>Nombre:</b>
		<?php echo form_input('nombre',set_value('nombre'));?>
	</p>
	<p>
		<b>Descripcion:</b>
		<?php echo form_textarea('descripcion',set_value('descripcion'));?>
	</p>
	
	<p>
		<b>Precio:</b>
		<?php echo form_input('precio',set_value('precio'));?>	
	</p>
	<p>
		<b>Cantidad:</b>
		<?php echo form_input('cantidad',set_value('cantidad'));?>	
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
                echo form_dropdown('comision', $options, set_value('comision'));
		?>	
	</p>
	<p>
		<b>Categoria:</b>
		<select name="categoria_id" id="categoria_id">
			<option value="ape">[Selecione Categoria]</option>
        	<?php foreach($categorias as $key => $value):?> 
        		<option value="<?=$key ?>"><?=$value ?></option>
        	<?php endforeach;?> 
        </select>
			
	</p>
	
	<p> 
		<b>Imagen:</b>
		<input type="file" name="imagen" id="imagen" size="20"  />
	</p>
	<?php echo form_submit('agregar', 'Agregar'); ?>
		

<?php echo form_close()?>

<?php echo anchor("productos/",'Volver');?><br>