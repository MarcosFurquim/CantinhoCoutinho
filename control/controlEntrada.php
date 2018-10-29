<?php
require_once (dirname(__DIR__).'/lib/libdba.php');
require_once (dirname(__DIR__).'/model/Entrada.php');
require_once (dirname(__DIR__).'/model/Fornecedor.php');
$fornecedor = Fornecedor::getFornecedor($_POST['fornecedor_id']);
$preco = str_replace(",",".",str_replace(".","",$_POST['valor_entrada']));
$entrada = new Entrada($fornecedor['id'], $fornecedor['nome'], $preco);
if($entrada->cadastraEntrada()) {
	echo "<script>alert('Entrada efetuada com sucesso');
		location.assign('../?page=relatorio');</script>";
}

 ?>