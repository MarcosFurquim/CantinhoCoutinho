<?php
require_once ('../model/Venda.php');

if($_POST['cadastro']=='S') {
	$venda = new Venda($_POST['cliente'], '');
	require_once ('../model/Cliente.php');
	$last_credito_id = Cliente::creditaCliente($_POST['cliente'],$_POST['hdn_total_valor_venda'],'D');
	if($_POST['pago']=='S'){
		$last_credito_id_pago = Cliente::creditaCliente($_POST['cliente'],$_POST['hdn_total_valor_venda'],'C');
		if($venda->cadastraVenda($last_credito_id, $last_credito_id_pago)) {
		echo "<script>alert('Venda efetuada com sucesso');
			location.assign('../?page=venda');</script>";
		}
	} else {
		if($venda->cadastraVenda($last_credito_id)) {
			echo "<script>alert('Venda efetuada com sucesso');
				location.assign('../?page=venda');</script>";
		}
	}
} else if($_POST['cadastro']=='N') {
	$venda = new Venda(0, $_POST['nome_cliente']);
	if($venda->cadastraVenda()) {
		echo "<script>alert('Venda efetuada com sucesso');
			location.assign('../?page=venda');</script>";
	}
}
 ?>