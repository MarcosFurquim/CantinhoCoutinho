<?php
 class Usuario {
     public static function logar($usuario, $senha) {
        $conexaoCantina = conectaCantina();
        $usuario = $conexaoCantina->has("usuario",["AND"=>["login" => $usuario, "senha" => $senha]]);
        return $usuario;
     }
 }


?>