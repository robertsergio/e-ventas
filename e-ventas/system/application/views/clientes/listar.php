<h2>Lista de Clientes</h2>

<table cellpadding="5" cellspacing="0">
	<?php if(count($items)==0):?>
			<tr>
				<td><b>Actualmente, no tiene clientes.</b> </td>
			</tr>
	
	<?php else:?>
			<tr>
				<td><b>Nombre</b> </td>
				<td><b>RUC</b></td>
				<td><b>Telefono</b></td>
			</tr>
		    <?php foreach($items as $item):?>
		        <tr valign="top">
		            <td>
		                <?php echo $item['nombre'];?><br>
		            </td>
		            <td>
		                <?php echo $item['ruc'];?> <br>
		            </td>
		            <td>
		                <?php echo $item['telefono'];?> <br>
		            </td>
		            <td>
		               <?php echo anchor("clientes/ver/".$item['id'],'Ver');?>
		               <?php echo anchor("clientes/editar/".$item['id'],'Editar');?>
		               <a href="javascript:;" onClick="aviso_borrar('<?="clientes"?>','<?=$item['nombre']?>','<?=$item['id']?>');">Borrar</a>
		            </td>
		        </tr>
		
		    <?php endforeach;?>
	<?php endif;?>         
</table>
<?=	$this->pagination->create_links();?>

<br>
<br>
<?php echo anchor("clientes/agregar/",'Agregar');?><br>



