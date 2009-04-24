<h2>Lista de Productos</h2>

<table cellpadding="5" cellspacing="0">
    <?php foreach($items as $ite):?>
        <tr valign="top">
            <td>
            <img width="60" height="70" src="<?=base_url().$ite['imagen']?>"/>
            </td>
            <td>
                <?php echo $ite['nombre'];?><br>
                <?php echo word_limiter($ite['descripcion'], 4);?> <br>
                <?php echo $ite['precio'].' Gs.';?>
            </td>
            <td>
                <a href="javascript:;" onClick="aviso_borrar('<?="productos"?>','<?=$ite['nombre']?>','<?=$ite['id']?>');">Borrar</a><br>
                <?php echo anchor("productos/editar/".$ite['id'],'Editar');?><br>
                <?php echo anchor("productos/ver/".$ite['id'],'Ver');?><br>
            </td>
        </tr>

    <?php endforeach;?>         
</table>
<?=$this->pagination->create_links();?>

<br>
<br>
<?php echo anchor("productos/agregar/",'Agregar');?><br>


