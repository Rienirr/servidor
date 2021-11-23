<?php
require_once 'bd.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $usu= comprobar_usuario($_POST['usuario'], $_POST['clave']);
    if($usu===false){
        $err=true;
        $usuario=$_POST['usuario'];
    } else {
        session_start();
        //Añadido para saber el email del usuario. para que lo muestro y lo sepa.
        $_SESSION['nombreUsuario']=$_POST['usuario'];
        $_SESSION['usuario']=$usu;
        $_SESSION['carrioto']=[];
        header("Location: categorias.php");
        return;
         
    }
     
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Formulario login</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php if(isset($_GET["redirigido"])){
            echo"<p> Haga login para continuar</p>";
        }?>
         <?php if(isset($err) && $err== true){
            echo"<p> Revise usuario y contraseña </p>";
        }?>
        <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " method="POST">
            <label for="usuario"> Usuario </label>
            <input value=" <?php if(isset($usuario)) echo $usuario; ?> " id="usuario" name="usuario" type="text">
            <label for="clave">Clave </label>
            <input id="clave" name="clave" type="password">
            <input type="submit">   
        </form>
    </body>
</html>