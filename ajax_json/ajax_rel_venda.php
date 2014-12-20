<?php
require_once ('../lib/libdba.php');
require_once('../model/Venda.php');
$vendas = Venda::getVendas();
for($i=0;$i<sizeof($vendas);$i++) {
	$vendas[$i]['data'] = ConverteDataBD($vendas[$i]['data']);
}

?>
<table class="table table-hover table-striped" >
	<thead>
		<th>Data</th>
		<th>Cliente</th>
		<th>Valor</th>
		<th>Produtos</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<sizeof($vendas);$i++) { ?>
			<tr>
				<td><?=$vendas[$i]['data']?></td>
				<td><?=$vendas[$i]['cliente']?></td>
				<td><?=number_format($vendas[$i]['valor'], 2, ',', '.')?></td>
				<td>
					<button class="btn btn-default" type="button" data-target="#produtos_modal" data-toggle="modal" data-idvenda="<?=$vendas[$i]['id']?>">
						<span class=" glyphicon glyphicon-info-sign"></span>
					</button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>