<?php
    if(count($navlist))
    {
        echo "<ul>";
        foreach ($navlist as $nombre => $url) 
        {
            echo "<li>";
            echo anchor($nav[''],$nav['nombre']);
            echo "</li>";
              
        }
        echo "</ul>";
        
    }
?>
