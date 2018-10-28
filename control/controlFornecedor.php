<?php
require_once ('../model/Fornecedor.php');
$fornecedor = new Fornecedor($_POST['nome_pro'],$_POST['desc_prod']);
if(isset($_POST['btn_cadastrar'])) {
	if($fornecedor->cadastraFornecedor()) {
		echo "<script>alert('Cadastro efetuado com sucesso');
				location.assign('../?page=fornecedor');</script>";
	}
} else if ($_POST['btn_atualizar']) {
		if($fornecedor->atualizaFornecedor($_POST['id_fornecedor'])) {
			echo "<script>alert('Alteração efetuada com sucesso');
				location.assign('../?page=fornecedor');</script>";
		}
}
?>