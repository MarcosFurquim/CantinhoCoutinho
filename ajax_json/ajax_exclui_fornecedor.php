<?php
require_once ('../model/Fornecedor.php');

echo Fornecedor::excluiFornecedor($_GET['id']);

?>