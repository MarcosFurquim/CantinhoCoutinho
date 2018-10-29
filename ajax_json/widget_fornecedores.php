<?php
	require_once (dirname(__DIR__).'/lib/libdba.php');
	require_once (dirname(__DIR__).'../model/Fornecedor.php');
	$fornecedores = Fornecedor::getFornecedores($_GET['nome']);
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
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($fornecedores);$i++) { ?>  
		<tr forne-id="<?=$fornecedores[$i]['id']?>" forne-desc="<?=$fornecedores[$i]['descricao']?>">
			<td><?=$fornecedores[$i]['nome']?></td>
		</tr>
		<?php } ?>  
	</tbody>
</table>