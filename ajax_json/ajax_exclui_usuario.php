<?php
require_once ('../model/cliente.php');

echo Cliente::excluiCliente($_GET['id']);

?>