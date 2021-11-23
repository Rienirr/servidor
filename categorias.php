<?php
require 'sesiones.php';
require_once 'bd.php';
comprobar_sesion();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta  charset="UTF-8">
        <title> Lista de categorias </title>
    </head>
    <body>
        <?php require 'cabecera.php'; ?>
        <h1>Lista de categorías </h1>
        <?php
        $categorias= cargar_categorias();
        if($categorias===false){
            echo "<p class='error'>Error al conectar con la base de datos</p>";
        }else{
            echo"<ul>";
            foreach ($categorias as $cat){
                //$cat[nombre] $cat['codCat']
            $url="productos.php?categoria=".$cat['CodCat'];
                echo"<li><a href='$url'>".$cat['Nombre']."</a></li>";
            }
            echo "</ul>";
            
            } ?>
        
        
    </body>
    
    
</html>