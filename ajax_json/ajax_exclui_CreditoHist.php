<?php
require_once ('../model/cliente.php');

echo Cliente::excluiHist($_GET['id']);

?>