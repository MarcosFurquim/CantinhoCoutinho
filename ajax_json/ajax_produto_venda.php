<?php
require_once ('../lib/libdba.php');
require_once ('../model/venda.php');

$venda = Venda::getProdutosVenda($_GET['id']);



?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($venda);$i++) { ?>  
		<tr>
			<td><?=$venda[$i]['nome']?></td>
			<td><?=number_format($venda[$i]['produto_preco'], 2, ',', '.')?></td>
			<td><?=$venda[$i]['produto_qnt']?></td>
		</tr>
		<?php } ?>  
	</tbody>
</table>