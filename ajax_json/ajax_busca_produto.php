<?php
require_once ('../lib/libdba.php');
require_once '../model/Produto.php';
$index = ($_GET['pag']-1)*10;
$produtos = Produto::getProdutos($_GET['nome'],$index);
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao li:nth-child(<?=$_GET['pag']?>)').toggleClass("active");
		$("[data-tt=tooltip]").tooltip({container: 'body'});
	});
</script>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço(R$)</th>
            <th>Descrição</th>
            <th colspan="2">&nbsp;</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($produtos);$i++) { ?>  
		<tr>
			<td><?=$produtos[$i]['nome']?></td>
			<td><?=number_format($produtos[$i]['preco'], 2, ',', '.')?></td>
			<td><?=$produtos[$i]['descricao']?></td>
			<td class="btn-group btn-group-4">
				<button type="button" class="btn btn-info" onclick="location.href='?page=editaProduto&id=<?=$produtos[$i]['id']?>'" data-tt='tooltip' title='Editar Produto'><span class="glyphicon glyphicon-pencil"></span></button>
				<button type="button" class="btn btn-danger" onclick="ajaxExcluiProduto(<?=$produtos[$i]['id']?>)" data-tt='tooltip' title='Excluir Produto'><span class="glyphicon glyphicon-remove"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>