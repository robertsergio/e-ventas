<?php
    if(count($navlist))
    {
        echo "<ul>";
        foreach($navlist as $nav)
        {
            echo "<li>";
            echo anchor("categorias/".$nav['id'],$nav['nombre']);
            echo "</li>";
              
        }
        echo "</ul>";
    }
?>
