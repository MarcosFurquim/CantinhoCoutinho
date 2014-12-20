<?php
	require_once ('../lib/libdba.php');
	require_once('../model/Produto.php');
	$produtos = Produto::getProdutos($_GET['nome']);
?>
<style>
tbody tr {
cursor:pointer;
}
</style>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
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