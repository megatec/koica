<?php
//Creacion de coneccion a base de datos usando PDO  
function estructuraBase($base){
   try {
       $con = new PDO("mysql:host=localhost;dbname={$base}", 'root', '');
   } catch(PDOException $e) {
       print 'Ha ocurrido un Error: ';
       print '<br />' . $e->getMessage();
   }
   //Mostrar las tablas de la base de datos seleccionadas    
   $sql='SHOW TABLES;';	
   $tablas=$con->query($sql);
   $tablas->setFetchMode(PDO::FETCH_NUM);
   
   //se extraen los nombres de las tablas para hacer la consulta de los 
   //campos que la componen junto con los detalles de los campos
   while($tabla = $tablas->fetch()) {
       $campos=$con->query('SHOW COLUMNS FROM ' .  $tabla[0] . ';');
       $campos->setFetchMode(PDO::FETCH_ASSOC);
       print '<table border=1 width=400>';
       print '<tr><td colspan=6>' . $tabla[0] . '</td></tr>';
       
       //se define el ciclo para poder extrear un primer arreglo e imprimir los nombres de las columnas
           foreach($campos->fetchAll() as $indice=>$valores) {
               print '<tr>';
               foreach($valores as $nombrecolumna=>$dato) {
                   print '<td>';
                   print $nombrecolumna;
                   print '</td>';					
               }
               print '</tr>';
               
               //se realiza una salida forzada del ciclo para que solo imprima una vez los encabezados
               //de nuestra tabla
               break;
           }
           	
       // se repite la extracccion de los campos pero aqui se usara los datos de detalles
       //que devuelve la consulta
       $campos=$con->query('SHOW COLUMNS FROM ' . $tabla[0] . ';');
       $campos->setFetchMode(PDO::FETCH_ASSOC);
       foreach ($campos->fetchAll() as $indice=>$valores) {
           print '<tr>';
           foreach ($valores as $nombrecolumna=>$dato) {
               print '<td>';
               print $dato;
               print '</td>';
           }
       print '</tr>';
       }
       print '</table><br />';
       
       //Mostrar las tablas con sus respectivas relaciones
   }	

   $sql="SELECT table_name, referenced_table_name, referenced_column_name,column_name
		 FROM information_schema.key_column_usage
		 WHERE referenced_table_schema ='{$base}'
   		 AND referenced_table_name is not NULL ";
   print '<br/>datos de referencias entre tablas<br/>';
   $camposcla = $con->query($sql);
   $camposcla->setFetchMode(PDO::FETCH_ASSOC);
   print '<table border = 1 >';
   print '<tr><td>tabla primaria</td><td>tabla con referencia</td><td>pk</td><td>fk</td></tr>';
   foreach($camposcla->fetchAll() as $campos=>$valores) {
       print '<tr>';
       foreach ($valores as $nombrecolumna=>$dato) {
           print '<td>';
           print $dato;
           print '</td>';
       }
       print '</tr>';
   }
   print '</table>';
}
estructuraBase('information_schema');
?>