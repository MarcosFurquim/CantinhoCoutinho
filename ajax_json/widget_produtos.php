<?php
	require_once (dirname(__DIR__).'/lib/libdba.php');
	require_once (dirname(__DIR__).'/model/Produto.php');
	$produtos = Produto::getProdutos($_GET['nome']);
?>
<style>
 #widget tbody tr {
cursor:pointer;
}
</style>
<table id="widget" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço(R$)</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($produtos);$i++) { ?>  
		<tr>
			<td><?=$produtos[$i]['nome']?></td>
			<td data-id="<?=$produtos[$i]['id']?>"><?=number_format($produtos[$i]['preco'], 2, ',', '.')?></td>
		</tr>
		<?php } ?>  
	</tbody>
</table>