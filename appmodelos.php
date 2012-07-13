<?php
require 'coneccion.php';

//declaracion funcion de creacion de Modelos
function CrearModelos($bdd){
    
$bandera=0;
$con = new coneccion();
$con->Conectar();
$sql_tablas = "SHOW TABLES from $bdd";
$ser= $con->Consulta($sql_tablas,$bdd);

//crear carpeta para modelos de datos
if(!file_exists("modelos")){
    mkdir("modelos");
} 
chmod("modelos", 0777);
// ciclo que genera automaticamente las clases dependiendo de las tabals de bases de datos
//define el nombre da las clases crea un archivo para cada tabla
 while ($tabla = mysql_fetch_array($ser)){
     
     $nomT=str_replace("_", "", $tabla[0]);
     $fp = fopen("modelos/".$nomT.".php", 'w');     
     fputs($fp,"<?php\n class ".$nomT."{\n");

     $sql_columnas_var = "SHOW COLUMNS from $bdd.".$tabla[0];
     $sql_columnas_sg = "SHOW COLUMNS from $bdd.".$tabla[0];
     $res=$con->Consulta($sql_columnas_var,$bdd);
     $otra=$con->Consulta($sql_columnas_sg,$bdd);
     
   //ciclo que extrae los campos de la tabala para crear cada propiedad
   
    while($fila = mysql_fetch_array($res)){    
    fputs($fp, "\tprivate \$".str_replace("_", "", $fila['Field']).";\n");
    };
    
    // ciclo que genera los set y get de la clase 
   
    while($clase = mysql_fetch_array($otra)){   
    fputs($fp, "
        public function set".ucfirst(str_replace("_", "", $clase['Field']))."(\$valor){
        \$this->".str_replace("_", "", $clase['Field'])."= \$valor;
        }
        
        public function get".ucfirst(str_replace("_", "", $clase['Field']))."(){
        return \$this->".str_replace("_", "", $clase['Field']).";
        }
    ");
    };
 
   fputs($fp, "\n}\n?>");
   chmod("modelos/".$nomT.".php",0777);    
 }
 
 $bandera=1;
 $con->Cerrar();
 return $bandera; 
}

if(isset($_REQUEST["bdd"]) && $_REQUEST["bdd"]!=""){    
    if(CrearModelos($_REQUEST["bdd"])==1){
        print "Modelos Creados :)";
    }else{
        print "Error :(";
    }    
}else{
?>
<form action="appmodelos.php" method="POST">    
    <p>Ingrese el nombre de la base de datos </p>
    <input type="text" name="bdd" />
    <input type="submit" name="bot" value="Crear Modelos " />    
</form>

<?php } ?>
