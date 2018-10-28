<?php
require_once ('../lib/libdba.php');
require_once('../model/Cliente.php');
$index = ($_GET['pag']-1)*10;
$cliente_hist = Cliente::getHistoricoCliente($_GET['id'],$index);
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
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao li:nth-child(<?=$_GET['pag']?>)').toggleClass("active");
	});
</script>
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