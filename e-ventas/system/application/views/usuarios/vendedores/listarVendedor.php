<h2>Lista de Vendedores</h2>
<?php if(count($items)==0):?>
			<b>No tiene vendedores asignados.</b>
<?php else:?>
		<table cellpadding="5" cellspacing="0">
			<tr>
				<td><b>Nombre</b> </td>
				<td><b>Username</b></td>
				<td><b>Rol</b></td>
			</tr>
		    <?php foreach($items as $item):?>
		        <tr valign="top">
		            <td>
		                <?php echo $item['nombre'];?><br>
		            </td>
		            <td>
		                <?php echo $item['username'];?> <br>
		            </td>
		            <td>
		                <?php echo $item['rol_nombre'];?> <br>
		            </td>
		            <td>
		               <?php echo anchor("usuarios/verVendedor/".$item['id'],'Ver');?>
		               <?php echo anchor("usuarios/editarVendedor/".$item['id'],'Editar');?>
		               <a href="javascript:;" onClick="aviso_borrar('<?="usuarios"?>','<?=$item['nombre']?>','<?=$item['id']?>');">Borrar</a>
		            </td>
		        </tr>
		
		    <?php endforeach;?>         
		</table>
	<?=	$this->pagination->create_links();?>
<?php endif;?>

<br>
<br>
<?php echo anchor("usuarios/agregarVendedor/",'Agregar');?><br>

