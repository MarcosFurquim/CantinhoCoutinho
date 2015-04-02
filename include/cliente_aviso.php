<?php
require_once('./model/Cliente.php');
$saldo_negativo = false;
$clientes_saldo_negatvo = "";
$clientes = Cliente::getClientes();
for($i=0;$i<sizeof($clientes);$i++) {
	if($clientes[$i]['saldo'] < 0) {
		$saldo_negativo = true;
	}
}
?>
<?php if($saldo_negativo) { ?>
	<div class="cli_aviso_saldo alert alert-danger alert-dismissible" role="alert">
		 <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		Os seguintes clientes estão com saldo negativo(devendo):
		<?php for($i=0;$i<sizeof($clientes);$i++) {
			if($clientes[$i]['saldo'] < 0) {
				$clientes_saldo_negatvo .=  $clientes[$i]['nome'].", ";
			}
		}
		echo substr($clientes_saldo_negatvo,0,-2);
		?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
<?php } ?>