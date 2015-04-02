<?php
require_once ('../model/fornecedor.php');

echo Fornecedor::excluiFornecedor($_GET['id']);

?>