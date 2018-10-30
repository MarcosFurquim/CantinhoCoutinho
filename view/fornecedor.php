<?php
require_once ($GLOBALS['PATH'].'/model/Fornecedor.php');
$fornecedores = Fornecedor::getFornecedores("",0);
$fornecedores_qnt = Fornecedor::getCount();

$qnt_page = $fornecedores_qnt/10;
$qnt_page = (substr($qnt_page, 2, 1) > 0)?(substr($qnt_page, 0, 1)+1):substr($qnt_page, 0, 1);
?>
<script>
	$(function() {
		$('#paginacao a:contains(1)').parent().toggleClass("active");
		$('#filtro_nome_fornecedor').keyup(function() {
			var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
			$.ajax({
					url: "./ajax_json/ajax_busca_fornecedor.php",
					type: "GET",
					data: 'nome='+$(this).val()+'&pag=1',
					beforeSend: function(){
						$("#fornecedor_list").html("");
						$("#fornecedor_list").append(img)
					},
					complete: function(){
						//$("#fornecedor_list").append(img);
					},
					success:function(result){
						$("#fornecedor_list").html(result);
						//caso o filtro estiver vazio, entao qnt é a mesma da original, senao pega de qts voltaram
						var qnt_reg;
						if($("#filtro_nome_fornecedor").val()=="") {
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
						url: "./ajax_json/ajax_busca_fornecedor.php",
						type: "GET",
						data: 'nome='+$('#filtro_nome_fornecedor').val()+'&pag='+$(this).html(),
						beforeSend: function(){
							$("#fornecedor_list").html("");
							$("#fornecedor_list").append(img)
						},
						complete: function(){
							//$("#fornecedor_list").append(img);
						},
						success:function(result){
							$("#fornecedor_list").html(result);
						}
						}).done(function(result) {
							//alert(result);
						});
			});
		}
		paginacao();
		$("[data-tt=tooltip]").tooltip({container: 'body'});
	});
	
	function ajaxExcluiFornecedor(idFornecedor) {
		if(confirm('Deseja realmente excluir este fornecedor?')) {
			$.ajax({
					url: "./ajax_json/ajax_exclui_fornecedor.php",
					type: "GET",
					data: 'id='+idFornecedor,
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
							alert('exclusão do fornecedor efetuado com sucesso!');
							location.reload();
						}
					}
					}).done(function(result) {
						//alert(result);
					});
		}
	}
</script>
<div class="divbotao_novo"><button class="btn btn-default btn-sm" onclick="location.href='?page=cadastroFornecedor'">Novo</button></div>
<div class="divqnt"><span><b><?=$fornecedores_qnt?></b></span> fornecedor(es)</div>
<div class="form-group " style="margin-top:30px;">
	<input type="text" class="form-control" placeholder="Filtrar por nome" id="filtro_nome_fornecedor" />
</div>
<div id="fornecedor_list" class="table-responsive form-group">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Descrição</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<sizeof($fornecedores);$i++) { ?>  
			<tr>
				<td><?=$fornecedores[$i]['nome']?></td>
				<td><?=$fornecedores[$i]['descricao']?></td>
				<td class="btn-group">
					<button type="button" class="btn btn-info" onclick="location.href='?page=editaFornecedor&id=<?=$fornecedores[$i]['id']?>'" data-tt='tooltip' title='Editar Fornecedor'><span class="glyphicon glyphicon-pencil"></span></button>
					<button type="button" class="btn btn-danger" onclick="ajaxExcluiFornecedor(<?=$fornecedores[$i]['id']?>)" data-tt='tooltip' title='Exckuir Fornecedor'><span class="glyphicon glyphicon-remove"></span></button>
				</td>
			</tr>
			<?php } ?>  
		</tbody>
	</table>
</div>
<hr/>
<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao" data-treg="<?=$fornecedores_qnt?>">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>