<?php
require 'config.php';
require 'coneccion.php';
require 'controles.php';

function Formularios($bdd,$folder){
    
$bandera=0;
$objCon=new controles();
$con = new coneccion();
$con->Conectar();
$sql = "SHOW TABLES from $bdd";
$ser= $con->Consulta($sql,$bdd);

if(!file_exists("vistas")){
    mkdir("vistas");
} 

 while ($tabla = mysql_fetch_array($ser)){ 
     $nomT=str_replace("_", "", $tabla[0]);
     if(!file_exists("vistas/".$nomT)){
        mkdir("vistas/".$nomT);
        } 
    chmod("vistas/".$nomT, 0777);
    $fp = fopen("vistas/".$nomT."/formulario.php", 'w');
    fputs($fp, "<?php require  \"Mformulario.php\" ?>

<h2>".ucfirst($nomT)."</h2>
<script type=\"text/javascript\">
<!--
    $().ready(function() {
        $(\"#formulario\").validate({
            errorClass: \"novale\"
        })
});
    // -->
</script>
    <form name='".$nomT."' id=\"formulario\" action='acciones.php' method='POST'>
        <?php print \$rotulo;?>
    <table>"); 
    
    $sql_campos="SHOW COLUMNS from $bdd.".$tabla[0];
    $res=$con->Consulta($sql_campos,$bdd);
    
   
    while($fila = mysql_fetch_array($res)){ 
        $nomF=str_replace("_", "", $fila['Field']);        
        if($nomF=="id"){
            fputs($fp, "<input type='hidden' name='".$nomF."' value='<?php print \$obj->get".$nomF."();?>' />");
        }else{
            fputs($fp,"
                <tr>
                <td><labe id='rotulo'>".str_replace("_", " ", $fila['Field'])."</label></td>
                <td><?php print \$objCon->texto(\"".$nomF."\",\$obj->get".  ucfirst($nomF)."()); ?></td>
                </tr>
                ");
        }
    }; 
   fputs($fp,"           
        <tr>\n<td colspan=2><input type='submit' name='bot'  value='<?php print \$nbo?>' class ='btn primary'/>
        </table>
     </form>
     
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/ista/pie.php\"; ?>
");
chmod("vistas/".$nomT."/formulario.php",0777);    
 };
 
 $bandera=1;
 return $bandera; 

}

function MFormularios($bdd,$folder){
    
$bandera=0;
$con = new coneccion();
$con->Conectar();
$sql = "SHOW TABLES from $bdd";
$ser= $con->Consulta($sql,$bdd);

if(!file_exists("vistas")){
    mkdir("vistas");
} 

 while ($tabla = mysql_fetch_array($ser)){ 
     $nomT=str_replace("_", "", $tabla[0]);
     if(!file_exists("vistas/".$nomT)){
        mkdir("vistas/".$nomT);
        } 
    chmod("vistas/".$nomT, 0777);
    $fp = fopen("vistas/".$nomT."/Mformulario.php", 'w');
      
fputs($fp, "<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/controles.php\" ?>
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/encabezado.php\"; ?>  
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/modelos/".$nomT.".php\"; ?> 
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/coneccion.php\"; ?> 
<?php 
\$objCon=new controles();
\$obj= new ".ucfirst($nomT)."();
\$con=new coneccion();
\$con->Conectar(); "); 
    
    fputs($fp,"if(@\$_REQUEST[\"formu\"]==\"Mod\"){
@\$sql=\"SELECT * FROM ".$nomT." WHERE id=\".\$_REQUEST['id'].\"\";
\$resl=\$con->Consulta(\$sql,\"".$bdd."\");\n");
  $sql_campos="SHOW COLUMNS from $bdd.".$tabla[0];
  $res=$con->Consulta($sql_campos,$bdd);
   while($fila = mysql_fetch_array($res)){    
            fputs($fp, "\$obj->set".ucfirst(str_replace("_", "", $fila['Field']))."(mysql_result(\$resl,0,\"".$fila['Field']."\"));\n");
            };
    
            fputs($fp,"
\$rotulo=\"<p>Numero de Registro a Modificar \".\$obj->getId().\"</p>\";
\$nbo=\"Modificar\";
    
}else{\n");
            
  $sql_setv="SHOW COLUMNS from $bdd.".$tabla[0];
  $resv=$con->Consulta($sql_setv,$bdd);
   while($fila = mysql_fetch_array($resv)){    
            fputs($fp, "\$obj->set".ucfirst(str_replace("_", "", $fila['Field']))."(\"\");\n");
            };          
    
            fputs($fp,"\$rotulo=\"\";
    \$nbo=\"Guardar\";
}
?>");
 

chmod("vistas/".$nomT."/Mformulario.php",0777);    
 };
 
 $bandera=1;
 return $bandera; 

}


function index($bdd,$folder){
$bandera=0;
$objCon=new controles();
$con = new coneccion();
$con->Conectar();
$sql = "SHOW TABLES from $bdd";
$ser= $con->Consulta($sql,$bdd);

if(!file_exists("vistas")){
    mkdir("vistas");
}

chmod("vistas", 0777);
 while ($tabla = mysql_fetch_array($ser)){     
     $nomT=str_replace("_", "", $tabla[0]);
     
    if(!file_exists("vistas/".$nomT)){
         mkdir("vistas/".$nomT);
     } 
     
    chmod("vistas/".$nomT, 0777);
    $fp = fopen("vistas/".$nomT."/index.php", 'w');
    fputs($fp,"<?php 
require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/controladores/".$nomT.".php\";
    require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/controles.php\";
\$control = new controles();
\$persis= new C".ucfirst($nomT)."();
?>
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/encabezado.php\"; ?>
<h2> prueba de index de app ".$nomT." </h2>
<?php 

    \$objt=\$persis->consultar(\"".$tabla[0]."\");
    
    
print \$control->imprimetabla(\$objt,\"zebra-striped\") ?>
<a href='formulario.php' title='crear ".$nomT."'> Nuevo  ".$nomT."</a>
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/pie.php\"; ?>  
        ");
    chmod("vistas/".str_replace("_", "", $tabla[0])."/index.php",0777);
 };
 
 $bandera=1;
 return $bandera; 
}

function accciones($bdd,$folder){
    $bandera=0;
    $objCon=new controles();
    $con = new coneccion();
    $con->Conectar();
    $sql = "SHOW TABLES from $bdd";
    $ser= $con->Consulta($sql,$bdd);

    if(!file_exists("vistas")){
        mkdir("vistas");
        
      } 
      
    chmod("vistas", 0777);
    
    while ($tabla = mysql_fetch_array($ser)){
        $nomT=str_replace("_", "", $tabla[0]);
        
        if(!file_exists("vistas/".$nomT)){
            mkdir("vistas/".$nomT);
          }
        chmod("vistas/".$nomT, 0777);     
        $fp = fopen("vistas/".$nomT."/acciones.php", 'w');
        $sql_camposcl = "SHOW COLUMNS from ".$tabla[0];
        $campocl = $con->Consulta($sql_camposcl,$bdd);
        fputs($fp, "<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/encabezado.php\"; ?> 
<script>
	$(function() {		
		$( \"#mensaje\" ).dialog( \"destroy\" );	
		$( \"#mensaje\" ).dialog({
			modal: true,
                        show: \"slide\",
			buttons: {
				Ok: function() {
					$( this ).dialog( \"close\" );
                                         url = \"index.php\"; 
                                         $(location).attr('href',url);  
				}
			}
		});
	});
 </script>
<div id='mensaje'>
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/$folder/controladores/".$nomT.".php\";
\$persis=new C".ucfirst(str_replace("_", "", $tabla[0]))."();            ");
   
        while($fila = mysql_fetch_array($campocl)){    
            fputs($fp, "@\$persis->set".ucfirst(str_replace("_", "", $fila['Field']))."(\$_REQUEST[\"".str_replace("_", "", $fila['Field'])."\"]);\n");
            };
            
        fputs($fp,"\nswitch (\$_REQUEST[\"bot\"]){
    case \"Guardar\":
        print \$persis->guardar(\$persis);
    break;
    case \"Modificar\":
        print \$persis->modificar(\$persis,\$_REQUEST[\"id\"]);
    break;
    case \"Borrar\";
        print \$persis->borrar(\$_REQUEST[\"id\"]);
    break;
    default:
        print \"No seleccionado accion\";
    break;
    }
?>
 </div>
       
<?php require  \$_SERVER[\"DOCUMENT_ROOT\"].\"/ista/pie.php\"; ?>        



");

       chmod("vistas/".str_replace("_", "", $tabla[0])."/acciones.php",0777);   
 };
 
 $bandera=1;
 return $bandera;
}

if(isset($_REQUEST["bdd"]) && $_REQUEST["bdd"]!="" && isset($_REQUEST['folder']) && $_REQUEST['folder']!=""){    
    if(Formularios($_REQUEST["bdd"],$_REQUEST['folder'])==1 && index($_REQUEST["bdd"],$_REQUEST['folder'])==1 && accciones($_REQUEST["bdd"],$_REQUEST['folder'])==1&& MFormularios($_REQUEST["bdd"],$_REQUEST['folder'])==1){
        print "Formularios Creados :)";
    }else{
        print "Error :(";
    }
    
}else{
?>
<form action="appformularios.php" method="POST">
    
    <p>Ingrese el nombre de la base de datos </p>
    <input type="text" name="bdd" />
    <p>Ingrese el nombre de carpeta </p>
    <input type="text" name="folder" />
    <input type="submit" name="bot" value="Crear Vistas " />
    
</form>

<?php } ?>