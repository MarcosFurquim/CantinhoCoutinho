<?php
require_once './model/Produto.php';
$produtos = Produto::getProdutos();
?>
<script>
	$(function() {
	});
	
	function ajaxExcluiProduto(idProduto) {
		if(confirm('Deseja realmente excluir este produto?')) {
			$.ajax({
					url: "./ajax_json/ajax_exclui_produto.php",
					type: "GET",
					data: 'id='+idProduto,
					beforeSend: function(){
						//$("#carregando").show('fast');
						//$("#principal_div").html("");
						//$("#principal_div").append(img)
					},
					complete: function(){
						//$("#principal_div").append(img);
					},
					success:function(result){
						if(result>0) {
							alert('exclusão do produto efetuado com sucesso!');
							location.reload();
						}
					}
					}).done(function(result) {
						//alert(result);
					});
		}
	}
</script>
<div class="divbotao_novo"><button class="btn btn-default btn-sm" onclick="location.href='?page=CadastroProduto'">Novo</button></div>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Decrição</th>
            <th colspan="2">&nbsp;</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($produtos);$i++) { ?>  
		<tr>
			<td><?=$produtos[$i]['nome']?></td>
			<td><?=number_format($produtos[$i]['preco'], 2, ',', '.')?></td>
			<td><?=$produtos[$i]['descricao']?></td>
			<td>
				<button type="button" class="btn btn-default" onclick="location.href='?page=editaProduto&id=<?=$produtos[$i]['id']?>'"><span class="glyphicon glyphicon-pencil"></span></button>
			</td>
			<td>
				<button type="button" class="btn btn-default" onclick="ajaxExcluiProduto(<?=$produtos[$i]['id']?>)"><span class="glyphicon glyphicon-remove-sign"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>