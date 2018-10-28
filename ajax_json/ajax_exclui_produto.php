<?php
require_once ('../model/Produto.php');

echo Produto::excluiProduto($_GET['id']);

?>