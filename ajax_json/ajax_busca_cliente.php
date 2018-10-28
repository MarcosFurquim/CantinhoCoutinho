<?php
require_once ('../lib/libdba.php');
require_once '../model/Cliente.php';
$index = ($_GET['pag']-1)*10;
$clientes = Cliente::getClientes($_GET['nome'],$index);
for($i=0;$i<sizeof($clientes);$i++) {
	if($clientes[$i]['saldo']<0) {
		if($clientes[$i]['saldo']+$clientes[$i]['bonus']>0) {
			$clientes[$i]['bonus']+=$clientes[$i]['saldo'];
			$clientes[$i]['saldo'] =0;
		} else {
			$clientes[$i]['saldo'] +=$clientes[$i]['bonus'];
			$clientes[$i]['bonus']=0;
		}
	}
}
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao li:nth-child(<?=$_GET['pag']?>)').toggleClass("active");
		$("[data-tt=tooltip]").tooltip({container: 'body'});
	});
</script>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Fone</th>
            <th>Saldo(R$)</th>
            <th>Bônus(R$)</th>
            <th>Saldo Final(R$)</th>
            <th></th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($clientes);$i++) { ?>  
		<tr <?php echo ($clientes[$i]['saldo'] < 0)?"class='danger'":""; ?>>
			<td><?=$clientes[$i]['nome']?></td>
			<td><?=$clientes[$i]['email']?></td>
			<td><?=$clientes[$i]['tel']?></td>
			<td><?=number_format($clientes[$i]['saldo'], 2, ',', '.')?></td>
			<td><?=number_format($clientes[$i]['bonus'], 2, ',', '.')?></td>
			<td><?=number_format(($clientes[$i]['saldo']+$clientes[$i]['bonus']), 2, ',', '.')?></td>
			<td class="btn-group btn-group-4">
				<button data-nomeuser="<?=$clientes[$i]['nome']?>" data-iduser="<?=$clientes[$i]['id']?>"  data-toggle="modal" data-target="#creditar_modal" type="button" class="btn btn-success" data-tt='tooltip' title='Creditar Cliente' data-tipocredito="C"><span class="glyphicon glyphicon-plus"></span></button>
				<button data-nomeuser="<?=$clientes[$i]['nome']?>" data-iduser="<?=$clientes[$i]['id']?>"  data-toggle="modal" data-target="#creditar_modal" type="button" class="btn btn-primary" data-tt='tooltip' title='Bonificar Cliente' data-tipocredito="B"><span class="glyphicon glyphicon-plus"></span></button>
				<button type="button" class="btn btn-info" onclick="location.href='?page=editaCliente&id=<?=$clientes[$i]['id']?>'" data-tt='tooltip' title='Editar Cliente'><span class="glyphicon glyphicon-pencil"></span></button>
				<button type="button" class="btn btn-danger" onclick="ajaxExcluiCliente(<?=$clientes[$i]['id']?>)" data-tt='tooltip' title='Excluir Cliente'><span class="glyphicon glyphicon-remove"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>