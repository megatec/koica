<?php
class login {
    public function validar($user,$clave){
        $eclave=md5($clave);
        $con= new coneccion();
        $con->Conectar();
        $exe=$con->Consulta("SELECT usuario,clave,id_tipousuario FROM login WHERE usuario='$user' and clave='$eclave';", "ISTA");
        $va=@mysql_result($exe, 0,'usuario');
        $vb=@mysql_result($exe,0,'clave');
        
        if($eclave == $vb & $user == $va){
            $var = true;
        }else{
            $var=false;
        }
        
        return $var;
    }
    
}


?>
