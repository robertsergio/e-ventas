<h2>Mostrar Carrito</h2>
<table>
	<tr>
		<td></td>
		<td><b>Producto</b></td>
		<td><b>Precio</b></td>
		<td><b>Comision</b></td>
	</tr>
	<?php if($cart!=null && count($cart)):
		 	foreach ($cart as $id => $producto):?>
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