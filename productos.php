<?php
require 'sesiones.php';
require_once 'bd.php';
comprobar_sesion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tabla de productos por categoría </title>
        
    </head>
    <body>
        <?php
        
        require 'cabecera.php';
        $categorias= cargar_categoria($_GET["categoria"]);
       
       $prodcutos= cargar_productos_categoria($_GET["categoria"]);
        if($categorias === false or $prodcutos === false) {
            echo "<p class='error'> Error al conectar con la base datos</p> ";
            exit;
        }
        foreach($categorias as $cat){
        echo "<h1>".$cat['Nombre']."</h1>";
        echo "<p>".$cat['Descripcion']."</p>";
        echo "<table>";
        echo "<tr> <th> Nombre</th> <th> Descripción </th> <th> Peso </th> <th> Stock </th> <th> Comprar </th> </tr> ";
        foreach($prodcutos as $producto){
            $cod=$producto['CodProd'];
            $nom=$producto['Nombre'];
            $des=$producto['Descripcion'];
            $peso=$producto['Peso'];
            $stock=$producto['Stock']; 
        echo "<tr> <td> $nom</td>   <td> $des</td>  <td> $peso </td> <td> $stock </td> "
                . " <td> <form action ='anadir.php'  method='POST'> "
                . "<input name='unidades' type='number' min ='1' value='1'> "
                . "<input type='submit' value='Comprar'> <input name ='cod' type='hidden' value='$cod'> "
                . "</form> </td></tr>";
           }
        }
        echo"</table>"; 
        ?>   
    </body>
</html>