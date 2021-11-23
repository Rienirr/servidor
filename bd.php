<?php

define("CADENA_CONEXION",'mysql:dbname=pedidos;host=127.0.0.1');
define("USUARIO_CONEXION", 'root');
define("CLAVE_CONEXION",'');

function  comprobar_usuario($nombre,$clave){
    try {
        $bd= new PDO(CADENA_CONEXION, USUARIO_CONEXION, CLAVE_CONEXION);
        
        $ins="SELECT CodRes, Correo From restaurantes where Correo='$nombre' and Clave='$clave' ";

        $resul= $bd->query($ins);
        if($resul->rowCount()===1){
            return true;
        }else{
            echo "<p> <h2> Usuario no registrado</h2></p>";
            return false;
        }
         
    } catch (PDOException $e) {
        echo 'Error con la base de datos: '.$e->getMessage();
    }
}
function cargar_categorias(){
    try{
        $bd= new PDO(CADENA_CONEXION, USUARIO_CONEXION, CLAVE_CONEXION);
        $ins= "SELECT CodCat, Nombre FROM categoria";
        $resul= $bd->query($ins);
        if(!$resul){
            return false;
        }
        if($resul->rowCount() ===0) {
            return false;
        }
        return $resul;
        
    } catch (PDOException $e) {
        echo 'Error con la base de datos'.$e->getMessage();
    
        
    }
    
    }
    
function cargar_categoria($codCat){
    try {
        $bd= new PDO(CADENA_CONEXION, USUARIO_CONEXION, CLAVE_CONEXION);
         $ins= "SELECT Nombre, Descripcion FROM categoria WHERE CodCat=$codCat";    
         $resul= $bd->query($ins);
         if(!$resul){
             return false;
         }if($resul->rowCount()===0){
            return false;
             
         }
         return $resul;
    }catch (PDOException $e) {
           echo 'Error con la base de datos'.$e->getMessage();
    }
}

function  cargar_productos_categoria($codCat){
    
           try {
               $bd= new PDO(CADENA_CONEXION, USUARIO_CONEXION, CLAVE_CONEXION);
             $sql= "SELECT * FROM productos WHERE CodCat=$codCat";
             $resul= $bd->query($sql);
           if(!$resul){
               return false;
           }
           if($resul->rowCount()===0){
               return false;
           }
           return $resul;
    } catch (PDOException $e) {
 echo 'Error con la base de datos'.$e->getMessage();
    }
}

function cargar_productos($codigosProductos){
    try {
        $bd= new PDO(CADENA_CONEXION, USUARIO_CONEXION, CLAVE_CONEXION);
        $texto_in = implode(",", $codigosProductos);
        $ins= "SELECT * FROM productos WHERE CodProd in($texto_in)";
        $resul =$bd->query($ins);
        if(!$resul){
            return false;
        }
        return $resul;
        
    } catch (PDOException $e) {
 echo 'Error con la base de datos'.$e->getMessage();
    }   
}

function insertar_pedido($carrito,$CodRes){
    try {
        $bd= new PDO(CADENA_CONEXION, USUARIO_CONEXION, CLAVE_CONEXION);
        $bd->beginTransaction();
        $hora= date("Y-m-d H:i:s", time());
        $sql= "INSERT into pedidos(Fecha,Enviado,Restaurante) VALUES ('$hora',0,$CodRes)";
        $resul = $bd->query($sql);
        if(!$resul){
            return false;
        }
        $pedido= $bd->lastInsertId();
        foreach ($carrito as $codProd=>$unidades){
            $ins ="INSERT into pedidosproductos(CodPed, CodProd, Unidades) VALUES ($pedido,$codProd,$unidades)";
            $resul= $bd->query($ins);
            if(!$resul){
                $bd->rollBack();
                return false;
            }
            
        }
        $bd->commit();
        return $pedido;
        
    } catch (Exception $e) {
 echo 'Error con la base de datos'.$e->getMessage();
    }   
    
    
}