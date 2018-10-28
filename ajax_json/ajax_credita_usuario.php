<?php
require_once ('../model/cliente.php');
$valor = str_replace(",",".",str_replace(".","",$_GET['valor']));

echo Cliente::creditaCliente($_GET['id'],$valor,$_GET['tipocredito']);



?>