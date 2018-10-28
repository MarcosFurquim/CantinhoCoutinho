<?php
require_once ('../lib/libdba.php');
require_once('../model/Cliente.php');
$cliente_hist = Cliente::getHistoricoCliente($_GET['id'],0);
$cliente_hist_qnt = Cliente::getHistoricoClienteCount($_GET['id']);
for($i=0;$i<sizeof($cliente_hist);$i++) {
	$cliente_hist[$i]['data'] = ConverteDataBD($cliente_hist[$i]['data']);
	$cliente_hist[$i]['data_hora'] = explode(" ", $cliente_hist[$i]['data'])[0];
	$cliente_hist[$i]['data_dia'] = explode(" ", $cliente_hist[$i]['data'])[1];
	$cliente_hist[$i]['classeCss'] = "";
	switch($cliente_hist[$i]['tipo']) {
		case 'C':
			$cliente_hist[$i]['classeCss'] = 'success';
			$cliente_hist[$i]['tipoExt'] = 'Crédito';
		break;
		case 'D':
			$cliente_hist[$i]['classeCss'] = 'danger';
			$cliente_hist[$i]['tipoExt'] = 'Débito';
		break;
		case 'B':
			$cliente_hist[$i]['classeCss'] = 'info';
			$cliente_hist[$i]['tipoExt'] = 'Bônus';
		break;
	}
}
$qnt_page = number_format($cliente_hist_qnt/10,2);
$qnt_page = (substr($qnt_page, strrpos($qnt_page, ".")+1, 1) > 0)?(substr($qnt_page, 0, strrpos($qnt_page, "."))+1):substr($qnt_page, 0, strrpos($qnt_page, "."));
?>
<script>
	$(function() {
		$('#paginacao a').click(function (e) {
			e.preventDefault();
			console.log(e);
			var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
			$.ajax({
					url: "./ajax_json/ajax_rel_cliente_busca_pagina.php",
					type: "GET",
					data: 'id='+$('#cliente').val()+'&pag='+$(this).html(),
					beforeSend: function(){
						$("#hist_cliente").html("");
						$("#hist_cliente").append(img)
					},
					complete: function(){
						//$("#hist_cliente").append(img);
					},
					success:function(result){
						$("#hist_cliente").html(result);
					}
					}).done(function(result) {
						//alert(result);
					});
		});
		$('#paginacao li:nth-child(1)').toggleClass("active");
	});
	function ajaxExcluiCreditoHist(idHist) {
		if(confirm('Deseja realmente excluir esse crédito?')) {
			$.ajax({
					url: "./ajax_json/ajax_exclui_CreditoHist.php",
					type: "GET",
					data: 'id='+idHist,
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
							alert('exclusão efetuada com sucesso!');
							location.reload();
						}
					}
					}).done(function(result) {
						//alert(result);
					});
		}
	}
</script>
<div id="saldo_cli" >Saldo do cliente:R$ <b></b></div>
<div id="hist_cliente">
	<table class="table table-hover table-striped" >
		<thead>
			<th>Data</th>
			<th>Valor(R$)</th>
			<th>Tipo</th>
			<th class="th-btn-group"></th>
		</thead>
		<tbody>
			<?php for($i=0;$i<sizeof($cliente_hist);$i++) { ?>
				<tr class="<?=$cliente_hist[$i]['classeCss']?>">
					<td><?=$cliente_hist[$i]['data_hora']?><br/><?=$cliente_hist[$i]['data_dia']?></td>
					<td><?=number_format($cliente_hist[$i]['valor'], 2, ',', '.')?></td>
					<td><?=$cliente_hist[$i]['tipoExt']?></td>
					<td>
						<?php if ($cliente_hist[$i]['id_venda'] == 0) { ?> 
							<button title="" data-tt="tooltip" onclick="ajaxExcluiCreditoHist(<?=$cliente_hist[$i]['id'] ?>)" class="btn btn-danger" type="button" data-original-title="Exckuir"><span class="glyphicon glyphicon-remove"></span></button>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>