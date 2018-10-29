<?php
require_once ($GLOBALS['PATH'].'/model/Produto.php');
$produtos = Produto::getProdutos("",0);
$produtos_qnt = Produto::getCount();

$qnt_page = number_format($produtos_qnt/10,2);
$qnt_page = (substr($qnt_page, strrpos($qnt_page, ".")+1, 1) > 0)?(substr($qnt_page, 0, strrpos($qnt_page, "."))+1):substr($qnt_page, 0, strrpos($qnt_page, "."));

?>
<script>
	$(function() {
		$('#paginacao li:nth-child(1)').toggleClass("active");
		$('#filtro_nome_produto').keyup(function() {
			var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
			$.ajax({
					url: "./ajax_json/ajax_busca_produto.php",
					type: "GET",
					data: 'nome='+$(this).val()+'&pag=1',
					beforeSend: function(){
						$("#produto_list").html("");
						$("#produto_list").append(img)
					},
					complete: function(){
						//$("#produto_list").append(img);
					},
					success:function(result){
						$("#produto_list").html(result);
						//caso o filtro estiver vazio, entao qnt é a mesma da original, senao pega de qts voltaram
						var qnt_reg;
						if($("#filtro_nome_produto").val()=="") {
							qnt_reg = parseInt($("#paginacao").data("treg"));
						} else {
							qnt_reg = $("table tbody tr").length;
						}
						//atualiza numero acima da tabela
						$(".divqnt span b").html(qnt_reg);
						//calcula qnt de pagina a partir de qnts resultados foram encontrados
						var qnt_page = qnt_reg/10;
						qnt_page = (qnt_page.toString().substr(2, 1) > 0)?(parseInt(qnt_page.toString().substr(0, 1))+1):qnt_page.toString().substr(0, 1);
						console.log(qnt_page);
						//limpa a paginacao
						$("#paginacao").html("");
						//monta paginacao
						for(var i=1;i<=qnt_page;i++) {
							$("#paginacao").append("<li><a href='#'>"+i+"</a></li>");
						}
						//ativa a primeira pagina
						$('#paginacao li:nth-child(1)').toggleClass("active");
						paginacao();
					}
					}).done(function(result) {
						//alert(result);
					});
		});
		function paginacao(){
			$('#paginacao a').click(function (e) {
				e.preventDefault();
				var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
				$.ajax({
						url: "./ajax_json/ajax_busca_produto.php",
						type: "GET",
						data: 'nome='+$('#filtro_nome_produto').val()+'&pag='+$(this).html(),
						beforeSend: function(){
							$("#produto_list").html("");
							$("#produto_list").append(img)
						},
						complete: function(){
							//$("#produto_list").append(img);
						},
						success:function(result){
							$("#produto_list").html(result);
						}
						}).done(function(result) {
							//alert(result);
						});
			});
		}
		paginacao();
		$("[data-tt=tooltip]").tooltip({container: 'body'});
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
<div class="divbotao_novo"><button class="btn btn-default btn-sm" onclick="location.href='?page=cadastroProduto'">Novo</button></div>
<div class="divqnt"><span><b><?=$produtos_qnt?></b></span> produto(s)</div>
<div class="form-group " style="margin-top:30px;">
	<input type="text" class="form-control" placeholder="Filtrar por nome" id="filtro_nome_produto" />
</div>
<div id="produto_list" class="form-group">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Preço(R$)</th>
				<th>Descrição</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<sizeof($produtos);$i++) { ?>  
			<tr>
				<td><?=$produtos[$i]['nome']?></td>
				<td><?=number_format($produtos[$i]['preco'], 2, ',', '.')?></td>
				<td><?=$produtos[$i]['descricao']?></td>
				<td class="btn-group">
					<button type="button" class="btn btn-info" onclick="location.href='?page=editaProduto&id=<?=$produtos[$i]['id']?>'" data-tt='tooltip' title='Editar Produto'><span class="glyphicon glyphicon-pencil"></span></button>
					<button type="button" class="btn btn-danger" onclick="ajaxExcluiProduto(<?=$produtos[$i]['id']?>)" data-tt='tooltip' title='Excluir Produto'><span class="glyphicon glyphicon-remove"></span></button>
				</td>
			</tr>
			<?php } ?>  
		</tbody>
	</table>
</div>
<hr/>
<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao" data-treg="<?=$produtos_qnt?>">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>