<?php
require_once ('../model/Venda.php');

var_dump($_POST);
if($_POST['cadastro']=='S') {
	$venda = new Venda($_POST['cliente'], '');
	require_once ('../model/Cliente.php');
	Cliente::creditaCliente($_POST['cliente'],$_POST['hdn_total_valor_venda'],'D');
} else if($_POST['cadastro']=='N') {
	$venda = new Venda(0, $_POST['nome_cliente']);
}
	if($venda->cadastraVenda()) {
		echo "<script>alert('Venda efetuada com sucesso');
			location.assign('../?page=relatorio');</script>";
	}
 ?>