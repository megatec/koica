<?php session_start(); ?>
<?php require 'config.php';?>
<?php require 'login.php'; ?>
<?php require 'coneccion.php';?>


<?php 
     $login = new login();
    if( $login->validar($_REQUEST["usuario"], $_REQUEST["clave"])){
        $_SESSION["ok"]=TRUE;
        
        $_SESSION["usuario"]=$_REQUEST["usuario"];
      
    }else{
        $_SESSION["ok"]=FALSE;   
              
    }
    @header("Location:http://localhost/ista/index.php");
    exit;
?>