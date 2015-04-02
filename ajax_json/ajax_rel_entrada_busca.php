<?php
require_once ('../lib/libdba.php');
require_once('../model/Entrada.php');
if($_GET['fid']>0) {
	$entradas = Entrada::getEntradas(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']),$_GET['fid']);
} else {
	if($_GET['agrup'] == "S") {
		$entradas = Entrada::getEntradasAgrupado(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']),$_GET['agrup']);
	} else {
		$entradas = Entrada::getEntradas(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']));
	}

}
$entradas_qnt = Entrada::getCount();
$venda_total = 0;
for($i=0;$i<sizeof($entradas);$i++) {
	if($_GET['agrup']== "N") {
		$entradas[$i]['data'] = ConverteDataBD($entradas[$i]['data']);
		$entradas[$i]['data_hora'] = explode(" ", $entradas[$i]['data'])[0];
		$entradas[$i]['data_dia'] = explode(" ", $entradas[$i]['data'])[1];
	} else {
		$entradas[$i]['dataf'] = inverteDataBD($entradas[$i]['dataf']);
	}
	$venda_total += $entradas[$i]['valor'];
}
$qnt_page = $entradas_qnt/10;
$qnt_page = (substr($qnt_page, 2, 1) > 0)?(substr($qnt_page, 0, 1)+1):substr($qnt_page, 0, 1);
?>
<script>
	
</script>
<div id="rel_venda">
	<?php if($_GET['agrup']== "N") { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Data</th>
				<th>Fornecedor</th>
				<th>Valor(R$)</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($entradas);$i++) { ?>
					<tr>
						<td><?=$entradas[$i]['data_hora']?><br/><?=$entradas[$i]['data_dia']?></td>
						<td><?=$entradas[$i]['fornecedor_nome']?></td>
						<td class="valor-venda-td"><?=number_format($entradas[$i]['valor'], 2, ',', '.')?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">Total</td>
					<th colspan="2" id="total_valor_venda"><?=number_format($venda_total, 2, ',', '.')?></th>
			</tfoot>
		</table>
	<?php } else if($_GET['agrup']== "S") { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Data</th>
				<th>Valor(R$)</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($entradas);$i++) { ?>
					<tr>
						<td><?=$entradas[$i]['dataf']?></td>
						<td class="valor-venda-td"><?=number_format($entradas[$i]['valor'], 2, ',', '.')?></td>
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