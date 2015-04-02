<?php
require_once ('../lib/libdba.php');
require_once ('../model/Venda.php');

echo Venda::excluiVenda($_GET['id']);

?>