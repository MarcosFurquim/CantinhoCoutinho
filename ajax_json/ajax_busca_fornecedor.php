﻿<?php
require_once ('../lib/libdba.php');
require_once '../model/Fornecedor.php';
$index = ($_GET['pag']-1)*10;
$fornecedors = Fornecedor::getFornecedores($_GET['nome'],$index);
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao a:contains(<?=$_GET['pag']?>)').parent().toggleClass("active");
		$("[data-tt=tooltip]").tooltip();
	});
</script>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th colspan="2">&nbsp;</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($fornecedors);$i++) { ?>  
		<tr>
			<td><?=$fornecedors[$i]['nome']?></td>
			<td><?=$fornecedors[$i]['descricao']?></td>
			<td>
				<button type="button" class="btn btn-info" onclick="location.href='?page=editaFornecedor&id=<?=$fornecedors[$i]['id']?>'" data-tt='tooltip' title='Editar Fornecedor'><span class="glyphicon glyphicon-pencil"></span></button>
			</td>
			<td>
				<button type="button" class="btn btn-danger" onclick="ajaxExcluiFornecedor(<?=$fornecedors[$i]['id']?>)" data-tt='tooltip' title='Excluir Fornecedor'><span class="glyphicon glyphicon-remove"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>