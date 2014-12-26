<?php
require_once ('../lib/libdba.php');
require_once('../model/Cliente.php');
$index = ($_GET['pag']-1)*10;
$cliente_hist = Cliente::getHistoricoCliente($_GET['id'],$index);
for($i=0;$i<sizeof($cliente_hist);$i++) {
	$cliente_hist[$i]['data'] = ConverteDataBD($cliente_hist[$i]['data']);
}
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao a:contains(<?=$_GET['pag']?>)').parent().toggleClass("active");
	});
</script>
<table class="table table-hover table-striped" >
	<thead>
		<th>Data</th>
		<th>Valor(R$)</th>
		<th>Tipo</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<sizeof($cliente_hist);$i++) { ?>
			<tr class="<?php echo ($cliente_hist[$i]['tipo']=='C')? 'success':'danger';?>">
				<td><?=$cliente_hist[$i]['data']?></td>
				<td><?=number_format($cliente_hist[$i]['valor'], 2, ',', '.')?></td>
				<td><?php echo ($cliente_hist[$i]['tipo']=='C')? 'Crédito':'Débito';?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>