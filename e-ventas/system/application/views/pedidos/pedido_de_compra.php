
<?= form_open_multipart('pedidos/guardarPedido')?>

<input type="hidden" name="vendedor_id" value=<?=$user_id?>/>
<table>
	<tr id="clientes" >
		<td colspan="2"><b>Ced. de Identidad del Cliente:</b></td>
		<td>
			<input type="text" id='cliente' name="cliente" value=""  />
			<a href="javascript:;" onClick="buscarCliente();">Buscar</a><br>		
		</td>
		
	</tr>
	<tr>
		<td id="datos_cliente" colspan="4">
					
		</td>
	</tr>
	<tr>
		<td colspan="2"><b>Observacion:</b></td>
		<td>
			<textarea name="observacion"></textarea>		
		</td>
	</tr>
	
 	<?php if($cart!=null && count($cart)):?>
 		<tr>
		<td></td>
		<td><b>Producto</b></td>
		<td><b>Precio</b></td>
		<td><b>Comision</b></td>
		</tr>
		 	<?php foreach ($cart as $id => $producto):?>
			<tr>
				<td><?=$producto['cantidad'] ?>&times;</td>
				<td><?=$producto['nombre'] ?></td>
				<td><?=$producto['precio'].' Gs.' ?></td>
				<td><?=$producto['comision'].' Gs.' ?></td>
			</tr>
			<?php endforeach;?>
			<tr>
			    <td colspan="2"><b>Total</b></td>
			    <td><b><?=$precioTotal.' Gs.'?></b></td>
			    <td><b><?=$comisionTotal.' Gs.'?></b></td>
	  		</tr>
   <?php else :
   			echo 'El carrito está vacío.'; 
   		endif;?>    
	
   	
			
</table>    
     <?php echo form_submit('guardar', 'Guardar'); ?>
<?= form_close()?>


