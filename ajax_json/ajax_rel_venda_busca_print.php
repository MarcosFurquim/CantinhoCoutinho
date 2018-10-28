<?php
require_once ('../lib/libdba.php');
require_once('../model/Venda.php');
if($_GET['pid']>0) {
	$vendas = Venda::getVendas(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']),$_GET['pid']);
} else {
	if($_GET['agrup'] == "S") {
		$vendas = Venda::getVendasAgrupado(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']),$_GET['agrup']);
	} else {
		$vendas = Venda::getVendas(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']));
	}

}
$vendas_qnt = Venda::getCount();
$venda_total = 0;
for($i=0;$i<sizeof($vendas);$i++) {
	if($_GET['agrup']== "N") {
		$vendas[$i]['data'] = ConverteDataBD($vendas[$i]['data']);
		$vendas[$i]['data_hora'] = explode(" ", $vendas[$i]['data'])[0];
		$vendas[$i]['data_dia'] = explode(" ", $vendas[$i]['data'])[1];
	} else {
		$vendas[$i]['dataf'] = inverteDataBD($vendas[$i]['dataf']);
	}
	$venda_total += $vendas[$i]['valor'];
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="./img/favicon.png" />
	<title>Cantinho do Coutinho</title>
	<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap-3.3.1-dist/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../js/bootstrap-3.3.1-dist/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../js/bootstrap-3.3.1-dist/dist/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../js/bootstrap-validator/css/bootstrapValidator.min.css">
	<!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">-->
	<script src="../js/numeral/min/numeral.min.js"></script>
	<script src="../js/numeral/min/languages.min.js"></script>
	<script src="../js/numeral/min/languages/pt-br.min.js"></script>
	<script>
		$(document).ready(function () {
			window.print();
		});
	</script>
</head>
<body>
<h1 style="text-align:center;">Relatório de vendas</h1>
<div id="rel_venda">
	<?php if($_GET['agrup']== "N") { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Data</th>
				<th>Cliente</th>
				<th>Valor(R$)</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($vendas);$i++) { ?>
					<tr>
						<td><?=$vendas[$i]['data_hora']?><br/><?=$vendas[$i]['data_dia']?></td>
						<td><?=$vendas[$i]['cliente']?></td>
						<td class="valor-venda-td"><?=number_format($vendas[$i]['valor'], 2, ',', '.')?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">Total</td>
					<th id="total_valor_venda"><?=number_format($venda_total, 2, ',', '.')?></th>
			</tfoot>
		</table>
	<?php } else if($_GET['agrup']== "S") { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Data</th>
				<th>Valor(R$)</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($vendas);$i++) { ?>
					<tr>
						<td><?=$vendas[$i]['dataf']?></td>
						<td class="valor-venda-td"><?=number_format($vendas[$i]['valor'], 2, ',', '.')?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th>Total</td>
					<th id="total_valor_venda"><?=number_format($venda_total, 2, ',', '.')?></th>
			</tfoot>
		</table>
	<?php } ?>

</div>
<!--<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>-->
</body>
</html>