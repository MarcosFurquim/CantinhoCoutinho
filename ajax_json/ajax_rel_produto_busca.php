<?php
require_once ('../lib/libdba.php');
require_once('../model/Produto.php');
if($_GET['pid']>0) {
	$produto = Produto::getProdutoRelatorio(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']),$_GET['pid']);
	$produto_total = array();
	$produto_total['qnt'] = 0;
	$produto_total['valor'] = 0;
	for($i=0;$i<sizeof($produto);$i++) {
		$produto[$i]['data'] = ConverteDataBD($produto[$i]['data']);
		$produto[$i]['data_hora'] = explode(" ", $produto[$i]['data'])[0];
		$produto[$i]['data_dia'] = explode(" ", $produto[$i]['data'])[1];
		$produto[$i]['valor_total'] = $produto[$i]['produto_qnt'] * $produto[$i]['produto_preco'];
		$produto_total['qnt'] += $produto[$i]['produto_qnt'];
		$produto_total['valor'] += $produto[$i]['valor_total'];
	}
} else {
	
	//echo "<span style='display:block;text-align:center;' align='center'><b>Selecione um Produto!</b></span>";
	//exit;
	$produto = Produto::getProdutoRelatorioMaisVendidos(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']));
	$total = 0;

	foreach($produto as $key => $values) {
		$total += $values[ 'total_qnt' ];
	}
	
}


?>
<div id="rel_produto">
	<?php if($_GET['pid']>0) { ?>
	<table class="table table-hover table-striped" >
		<thead>
			<th>Data</th>
			<th>Cliente</th>
			<th>Quantidade</th>
			<th>Preço(R$)</th>
			<th>Valor Total(R$)</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<sizeof($produto);$i++) { ?>
				<tr>
					<td><?=$produto[$i]['data_hora']?><br/><?=$produto[$i]['data_dia']?></td>
					<td><?=$produto[$i]['cliente_nome']?></td>
					<td><?=$produto[$i]['produto_qnt']?></td>
					<td><?=number_format($produto[$i]['produto_preco'], 2, ',', '.')?></td>
					<td><?=number_format($produto[$i]['valor_total'], 2, ',', '.')?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">Total</td>
				<th colspan="2"><?=$produto_total['qnt']?></th>
				<th><?=number_format($produto_total['valor'], 2, ',', '.')?></th>
		</tfoot>
	</table>
	<?php } else { ?>
		<table class="table table-hover table-striped" >
			<thead>
				<th>Produto</th>
				<th>Quantidade</th>
			</thead>
			<tbody>
				<?php for($i=0;$i<sizeof($produto);$i++) { ?>
					<tr>
						<td><?=$produto[$i]['produto']?></td>
						<td><?=$produto[$i]['total_qnt']?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
			<tr>
				<th>Total</td>
				<th><?=$total?></th>
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