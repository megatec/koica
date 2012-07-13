
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//include 'coneccion.php';
/**
 * Description of controles
 *
 * @author alphyon
 */
class controles {
    private $textoC;
    private $claveC;
    private $radioC;
    private $areaC;
    private $listaC;
    private $listaD;
    private $fecha;
    private $tabla;
    
    
    public function texto($nombre,$value="",$required="required",$read=0,$tamaño=25){
        if($read != 0){
            $lec="readonly";
        }else{
            $lec="";
        }
        
        $this->textoC = "<input ".$lec." type='text' name='".$nombre."' id='".$nombre."' value='".$value."' class='".$required."' size='".$tamaño."' />";
        
        return $this->textoC;
    }
    
    public function clave($nombre,$value="", $tamaño=25, $required="required"){
        $this->claveC = "<input type='password' name='".$nombre."' id='".$nombre."' value='".$value."' class='".$required."' size='".$tamaño."' />";
        
        return $this->claveC;
    }    
    public function texarea($nombre,$value="",$required="required"){
        $this->areaC = "<textarea name='".$nombre."' id='".$nombre."'  class='".$required."'>".$value." </textarea>";
        
        return $this->areaC;
    }    
    public function radio($nombre,$valor,$activo=0,$required="required"){
        
            if($activo==1){
                $ele="checked";
            }  else {
                $ele="";
            }
        
        $this->radioC = "<input type='radio' name='".$nombre."' id='".$nombre."' class='".$required."' value='".$valor."' ".$ele." />";
        
        return $this->radioC;
    }    
    public function lista($nombre, $array,$required="required"){
        $this->listaC = "<select name='".$nombre."' id='".$nombre."' class='".$required."'>";
        foreach ($array as $value) {
            $this->listaC .="<option value='".$value."'>".$value."</option>";
        }
        $this->listaC .="</select>";
        
        return $this->listaC;
    }    
    public function listaDatos($nombre,$bdd,$modelo,$valor="",$campos="",$required="required"){
        
        
        $this->listaD = "<select name='".$nombre."' id='".$nombre."' class='".$required."'>";        
        $con=new coneccion();        
        $con->Conectar();        
        if ($campos !="" ) {
            $datos="id,".$campos; 
           $corta=explode(",", $campos);
        }else{
            $datos="id,nombre";
            $corta=explode(",", $datos);
        } 
        
         if($valor==""){
           $this->listaD.="<option value='".$valor."'>Elija un dato</option>";
           $sql="SELECT ".$datos." FROM ".$modelo;
        }else{
           
            $sqlint="SELECT * FROM ".$modelo." WHERE id=".$valor;
            $exe=$con->Consulta($sqlint, $bdd);
            $this->listaD.="<option value='".mysql_result($exe, 0, 'id')."'>";
            $this->listaD.=mysql_result($exe, 0, 'nombre');
            $this->listaD.="</option>";
            
            $sql="SELECT ".$datos." FROM ".$modelo." WHERE NOT id=".$valor;
            
        }
        
        
        
        $res=$con->Consulta($sql,$bdd);   
        $sql_columnas_var = "SHOW COLUMNS from ".$modelo;
        $res1=$con->Consulta($sql_columnas_var,$bdd);
      
        while($fila = mysql_fetch_array($res)){ 
            $this->listaD .= "<option value=".$fila[0].">";
             for($i=1;$i<count($corta);$i++){
                 $this->listaD .= $fila[$corta[$i]]." ";
         }
         
         $this->listaD .="</option>";  
       }      
        $con->Cerrar();
        $this->listaD .="</select>";        
        return $this->listaD;
    }    
    public function fecha($nombre,$id,$dfecha=""){
        if($dfecha==""){
            $val=date('Y-m-d');
        }else{
            $val=$dfecha;
        }
        
        $this->fecha="
       <script> 
       $(document).ready(
            function(){
                \$(\"#".$id."\").datepicker(    
                    {
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        showAnim:'slide'
                    }
                    
                 );
            }
           
       )
       </script>
         
           <input type=text id=\"".$id."\" name='".$nombre."' value=\"".$val."\">";              
        return $this->fecha;        
    } 
    
   public function imprimetabla($objeto,$editar,$estilo="") {
      @$vdat=array_key_exists("id", $objeto);
      if($objeto!=null){
      if($vdat){
      
$indices=array_keys($objeto);
$this->tabla="<table class='$estilo'><tr>";
foreach ($indices as $array) {
    $this->tabla.= "<td>";
    $this->tabla.= str_replace("_"," ",$array);    
    }
    if($editar!="0"){
       $this->tabla.= "<td>Modificar<td>Eliminar"; 
    }
    
    $this->tabla.= "</tr>";
 
 for($i=0; $i< count($objeto[$array]);$i++){
     $this->tabla.= "<tr>";
     foreach ($indices as $array) {   

        $this->tabla.= "<td>";
        $this->tabla.= $objeto[$array][$i];
        /***********************/
        
        
        /*********************/
        $this->tabla.= "</td>";
        
        
        
        
    }
    
    if($editar!="0"){
    $this->tabla.="<td><a href=formulario.php?id=".$objeto['id'][$i]."&formu=Mod>Modificar</a></td>";
    $this->tabla.= "<td><a href=acciones.php?id=".$objeto['id'][$i]."&bot=Borrar>Eliminar</a></td>";    
    }
    
    $this->tabla.= "</tr>";
 }
  $this->tabla.= "<table>"; 
  
      }else{
          $this->tabla="Debe haber un id definido para la tabla o utilizarse en la lista de campos";
      }
      }
  
  return $this->tabla;
   
       
   } 
    
    
    
    
}

?>
