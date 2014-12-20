<?php
require_once ('../model/produto.php');

echo Produto::excluiProduto($_GET['id']);

?>