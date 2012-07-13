<?php
require_once 'coneccion.php';
require_once 'config.php';

function CrearControladores($bdd,$folder){
    $bandera=0;
    $con = new coneccion();
    $con->Conectar();
    $sql_tablas = "SHOW TABLES from $bdd";
    $tablabd= $con->Consulta($sql_tablas,$bdd);
    
    if(!file_exists("controladores")){
        mkdir("controladores");
    } 
    
    chmod("controladores", 0777);

    while ($tabla = mysql_fetch_array($tablabd)){   
        $fp = fopen("controladores/".str_replace("_", "", $tabla[0]).".php", 'w');
        chmod("controladores/".str_replace("_", "", $tabla[0]).".php",0777);
     fputs($fp,  "<?php\n     
require_once \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/modelos/".str_replace("_", "", $tabla[0]).".php\";
require_once \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/coneccion.php\";
class  C".ucfirst(str_replace("_", "", $tabla[0]))." extends ".str_replace("_", "", $tabla[0])."{     
    public function guardar(\$objeto){
        \$con=new coneccion();  
        \$con->Conectar();\n");
     
        $des="\$sql= \"INSERT INTO ";
        $des.= $tabla[0];
        $des.= " (";    
        $sql_camposv = "SHOW COLUMNS from ".$tabla[0];
        $camposbd = $con->Consulta($sql_camposv,$bdd);
        
        while($fila = mysql_fetch_array($camposbd)){    
            $des.=$fila['Field'].",";
            };       
        $des.=") VALUES (";
        $sql_camposg = "SHOW COLUMNS from ".$tabla[0];
        $camposg = $con->Consulta($sql_camposg,$bdd);
        
        while($fila = mysql_fetch_array($camposg)){    
            $des.="'\".parent::get".ucfirst(str_replace("_", "", $fila['Field']))."().\"'";
            $des.=",";      
            };
        $des.=");\";\n";       
        fputs($fp,  str_replace(",)", ")", $des));
        fputs($fp,"if(\$con->Consulta(\$sql,\"".$bdd."\")){
    \$msg= \"Datos Almacenados\";
}else{             
    \$msg= \"Error al Guardar los datos<br />\". mysql_error().\"<br /> Numero de error\".  mysql_errno();
}
return \$msg;   
}
    
function modificar(\$objeto,\$id){
    \$con=new coneccion();             
    \$con->Conectar();");
        
        $des1="\n\t\$sql= \"UPDATE ";
        $des1.= $tabla[0];
        $des1.= " SET ";      
        $sql_camposu = "SHOW COLUMNS from ".$tabla[0];
        $camposu = $con->Consulta($sql_camposu,$bdd);      
        
        while($fila = mysql_fetch_array($camposu)){    
            $des1.=$fila['Field']." = '";
            $des1.="\".parent::get".ucfirst(str_replace("_", "", $fila['Field']));
            $des1.="().\"',";    
        };  
      
        $des1.=" WHERE id=\".\$id.\";\";\n";   
        fputs($fp,  str_replace(", WHERE", " WHERE", $des1));            
        fputs($fp,"if(\$con->Consulta(\$sql,\"".$bdd."\")){
    \$msg= \"Datos Actualizados\";                                
}else{
    \$msg= \"Error Actualizar datos<br />\".  mysql_error().\"<br /> Numero de error\".  mysql_errno();
}
return \$msg;
}

public function borrar(\$id){
    \$con=new coneccion();            
    \$con->Conectar();
    \$sql= \"DELETE FROM ". $tabla[0] ." WHERE id=\".\$id.\";\";
    
    if(\$con->Consulta(\$sql,\"".$bdd."\")){
        \$msg= \"Datos Borrados\";                               
    }else{
        \$msg= \"Error al Borrar datos<br />\".  mysql_error().\"<br /> Numero de error\".  mysql_errno();
    }    
             
   return \$msg;   
}


public function consultar(\$tabla,\$campos=\"*\"){
    \$con=new coneccion();
    \$con->Conectar();
    
    if(\$campos==\"*\"){
        \$sql=\"SELECT * FROM \$tabla\";
        
        \$cam=\$con->Consulta(\"SHOW COLUMNS FROM \$tabla\", \"".$bdd."\");
        
        while (\$row = mysql_fetch_array(\$cam)) {
            if(\$row['Key']=='MUL'){
              \$dato[]=\$row['Field'].\"_for\";
            }else{
             \$dato[]=\$row['Field'];
            }      
            }
        
        
    }else{
       \$dato=explode(\",\", \$campos);
        \$sql=\"SELECT \".\$campos.\" FROM \$tabla\";
    }
    
  
   \$res=\$con->Consulta(\$sql,\"".$bdd."\");

   
    if(\$res){
       
        while (\$obj = mysql_fetch_array(\$res)) {
            

foreach (\$dato as \$value) {
                
                 
                 
                  \$evalua=preg_match(\"([a-z0-9]_for$)\", \$value);
           
           if(\$evalua){
               \$dlimitado=explode(\"_\", \$value);
               \$ind=str_replace(\"_for\", \"\", \$value);
               
              \$sqlrel=\"SELECT * FROM \".\$dlimitado[1].\" WHERE id=\".\$obj[\$ind].\";\";
              \$dtcrel=\$con->Consulta(\$sqlrel, \"ISTA\");
              while (\$filarelacion = mysql_fetch_array(\$dtcrel)) {
                \$tablac[\$ind][]=\$filarelacion[\"nombre\"];
              }
               
           }else{
                 
              \$tablac[\$value][]=\$obj[\$value];
                 
           }     
                 
                
            }




            
            
        }
        
       
}else{
        \$tablac = \"Error Consultar los datos <br />\". mysql_error().\"<br /> Numero de error\".  mysql_errno();
      }
      

    
return @\$tablac;
}
public function consultarid(\$tabla,\$pm,\$campos=\"*\"){
    \$con=new coneccion();
    \$con->Conectar();
    
    if(\$campos==\"*\"){
        \$sql=\"SELECT * FROM \$tabla WHERE id=\$pm\";
        
        \$cam=\$con->Consulta(\"SHOW COLUMNS FROM \$tabla\", \"".$bdd."\");
        
        while (\$row = mysql_fetch_array(\$cam)) {
            \$dato[]=\$row['Field'];
        }
        
        
    }else{
       \$dato=explode(\",\", \$campos);
        \$sql=\"SELECT \".\$campos.\" FROM \$tabla WHERE id=\$pm \";
    }
    
  
   \$res=\$con->Consulta(\$sql,\"".$bdd."\");

   
    if(\$res){
       
        while (\$obj = mysql_fetch_array(\$res)) {
            
            for(\$i=0;\$i<count(\$dato);\$i++){
                \$tablac[\$dato[\$i]][]=\$obj[\$i];
            }
            
        }
        
       
}else{
        \$tablac = \"Error Consultar los datos <br />\". mysql_error().\"<br /> Numero de error\".  mysql_errno();
      }
      

    
return @\$tablac;
}

}   
?>");
    
chmod("controladores/".str_replace("_", "", $tabla[0]).".php",0777);
}
 $bandera=1;
 $con->Cerrar();
 return $bandera; 
}



if(isset($_REQUEST["bdd"]) && $_REQUEST["bdd"]!="" && isset($_REQUEST['folder']) && $_REQUEST['folder']!="") {    
    if(CrearControladores($_REQUEST["bdd"],$_REQUEST['folder'])==1){
        print "Contoladores Creados :)";
    }else{
        print "Error :(";
    }
    
}else{
?>
<form action="appcontroladores.php" method="POST">
    
    <p>Ingrese el nombre de la base de datos </p>
    <input type="text" name="bdd" />
    <p>Ingrese el nombre de carpeta </p>
    <input type="text" name="folder" />
    <input type="submit" name="bot" value="Crear Controladores " />
    
</form>

<?php } ?>