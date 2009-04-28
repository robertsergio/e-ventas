<h2>Mostrar Carrito</h2>
<table>
	<?php if($cart!=null && count($cart)):
		 	foreach ($cart as $id => $producto):?>
			<tr>
				<td><?=$producto['cantidad'] ?>&times;</td>
				<td><?=$producto['nombre'] ?></td>
				<td><?=$producto['precio'] ?></td>
			</tr>
			<?php endforeach;?>
			<tr>
			    <td colspan="2">Total</td>
			    <td><?=$precioTotal?></td>
	  		</tr>
   <?php else :
   			echo 'El carrito está vacío.'; 
   		endif;?>
	
			
</table>