<?php
require_once ('../model/Produto.php');
$preco = str_replace(",",".",str_replace(".","",$_POST['preco_pro']));
$produto = new Produto($_POST['nome_pro'],$preco,$_POST['desc_prod']);
if(isset($_POST['btn_cadastrar'])) {
	if($produto->cadastraProduto()) {
		echo "<script>alert('Cadastro efetuado com sucesso');
				location.assign('../?page=produto');</script>";
	}
} else if ($_POST['btn_atualizar']) {
		if($produto->atualizaProduto($_POST['id_produto'])) {
			echo "<script>alert('Alteração efetuada com sucesso');
				location.assign('../?page=produto');</script>";
		}
}
?>