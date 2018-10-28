<?php
require_once ('../lib/libdba.php');
require_once('../model/Caixa.php');

if($_GET['agrup'] == "S") {
		$caixa = Caixa::getCaixaRealAgrupado(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']));
	} else {
		$caixa = Caixa::getCaixaReal(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']));
	}


$caixa_total = 0;
for($i=0;$i<sizeof($caixa);$i++) {
	if($_GET['agrup']== "N") {
		$caixa[$i]['data'] = ConverteDataBD($caixa[$i]['data_completo']);
		$caixa[$i]['data_hora'] = explode(" ", $caixa[$i]['data'])[0];
		$caixa[$i]['data_dia'] = explode(" ", $caixa[$i]['data'])[1];
	} else {
		$caixa[$i]['data'] = inverteDataBD($caixa[$i]['data']);
	}
	$caixa_total += $caixa[$i]['valor'];
}


?>
<script>
	
</script>
<div id="rel_caixa">
	<?php if($_GET['agrup']== "N") { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Data</th>
				<th>Cliente</th>
				<th>Valor(R$)</th>
				<th>Tipo</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($caixa);$i++) { ?>
					<tr>
						<td><?=$caixa[$i]['data_hora']?><br/><?=$caixa[$i]['data_dia']?></td>
						<td style="width:30%"><?=$caixa[$i]['cliente']?></td>
						<td class="valor-venda-td"><?=number_format($caixa[$i]['valor'], 2, ',', '.')?></td>
						<td style="width:30%"><?=$caixa[$i]['tipo']?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">Total</td>
					<th colspan="2" id="total_valor_venda"><?=number_format($caixa_total, 2, ',', '.')?></th>
			</tfoot>
		</table>
	<?php } else if($_GET['agrup']== "S") { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Data</th>
				<th>Valor(R$)</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($caixa);$i++) { ?>
					<tr>
						<td><?=$caixa[$i]['data']?></td>
						<td class="valor-venda-td"><?=number_format($caixa[$i]['valor'], 2, ',', '.')?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th>Total</td>
					<th id="total_valor_venda"><?=number_format($caixa_total, 2, ',', '.')?></th>
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