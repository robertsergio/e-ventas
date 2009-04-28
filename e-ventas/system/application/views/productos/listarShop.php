<h2>Lista de Productos</h2>
<?php
if (count($cart) == true){
	echo anchor("productos/verCarrito", "Ver Carrito");
}
?>
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
                <?php echo anchor("productos/agregarCarrito/".$ite['id'],'Agregar al Carrito');?><br>
            </td>
        </tr>

    <?php endforeach;?>         
</table>
<?=$this->pagination->create_links();?>

<br>
<br>
<?php echo anchor("productos/agregar/",'Agregar');?><br>


