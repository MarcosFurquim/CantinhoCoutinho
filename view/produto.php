<?php
require_once './model/Produto.php';
$produtos = Produto::getProdutos("",0);
$produtos_qnt = Produto::getCount();

$qnt_page = $produtos_qnt/10;
$qnt_page = (substr($qnt_page, 2, 1) > 0)?(substr($qnt_page, 0, 1)+1):substr($qnt_page, 0, 1);
?>
<script>
	$(function() {
		$('#paginacao a:contains(1)').parent().toggleClass("active");
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
						$('#paginacao a:contains(1)').parent().toggleClass("active");
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
					<button type="button" class="btn btn-default" onclick="ajaxExcluiProduto(<?=$produtos[$i]['id']?>)"><span class="glyphicon glyphicon-remove"></span></button>
				</td>
			</tr>
			<?php } ?>  
		</tbody>
	</table>
</div>
<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao" data-treg="<?=$produtos_qnt?>">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>