<?php
require_once ('../model/Cliente.php');

echo Cliente::excluiCliente($_GET['id']);

?>