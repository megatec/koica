<?php
class coneccion {
    public function Conectar() {
        $this->conexion = mysql_connect(HOST,USUARIO,CLAVE);
 
        if(!$this->conexion){
            echo "No se ha podido conectar a la base de datos.";
         }
    }
 
 
 public function Consulta($sql,$bdd){
  $bd=mysql_select_db($bdd,  $this->conexion);
  $resultado = mysql_query($sql,$this->conexion); 
  if(!$resultado){
   print  "Error de Consulta : ".mysql_error();
   print  "<br />Numero de error : ".mysql_errno();
   exit;
  }
  return $resultado;
 } 
 
 public function  Cerrar(){
     if($this->conexion){
         mysql_close();
     }else{
       echo "Error al cerrar la conexion: ".mysql_error();
   exit;  
     }
 }
 
}


/*$bd=new coneccion();


$bd->Conectar();
$bd->Consulta("SHOW TABLES from ISTA");
$bd->Cerrar();*/



?>
