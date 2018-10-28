<?php
require_once ('../model/cliente.php');
	$cliente = new Cliente($_POST['nome_cli'],$_POST['email_cli'],$_POST['tel_cli']);
	if(isset($_POST['btn_cadastrar'])) {
		if($cliente->cadastaCliente()) {
			echo "<script>alert('Cadastro efetuado com sucesso');
					location.assign('../?page=cliente');</script>";
		}
	} else if ($_POST['btn_atualizar']) {
			if($cliente->atualizaCliente($_POST['id_cliente'])) {
				echo "<script>alert('Alteração efetuada com sucesso');
					location.assign('../?page=cliente');</script>";
			}
	}
?>