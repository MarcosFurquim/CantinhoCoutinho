<?php
require_once ('../lib/libdba.php');
require_once '../model/Cliente.php';
$index = ($_GET['pag']-1)*10;
$clientes = Cliente::getClientes($_GET['nome'],$index);
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao a:contains(<?=$_GET['pag']?>)').parent().toggleClass("active");
	});
</script>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Fone</th>
            <th colspan="3">Crédito(R$)</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($clientes);$i++) { ?>  
		<tr <?php echo ($clientes[$i]['saldo'] < 0)?"class='danger'":""; ?>>
			<td><?=$clientes[$i]['nome']?></td>
			<td><?=$clientes[$i]['email']?></td>
			<td><?=$clientes[$i]['tel']?></td>
			<td><?=number_format($clientes[$i]['saldo'], 2, ',', '.')?></td>
			<td>
				<button data-nomeuser="<?=$clientes[$i]['nome']?>" data-iduser="<?=$clientes[$i]['id']?>"  data-toggle="modal" data-target="#creditar_modal" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span></button>
			</td>
			<td>
				<button type="button" class="btn btn-default" onclick="location.href='?page=editaCliente&id=<?=$clientes[$i]['id']?>'"><span class="glyphicon glyphicon-pencil"></span></button>
			</td>
			<td>
				<button type="button" class="btn btn-default" onclick="ajaxExcluiCliente(<?=$clientes[$i]['id']?>)"><span class="glyphicon glyphicon-remove"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>