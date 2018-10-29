<?php
require_once (dirname(__DIR__).'/lib/libdba.php');
require_once (dirname(__DIR__).'/model/Cliente.php');
$saldo_negativo = false;
$clientes_saldo_negatvo = "";
$clientes = Cliente::getClientes();
for($i=0;$i<sizeof($clientes);$i++) {
	if($clientes[$i]['saldo']+$clientes[$i]['bonus'] < 0) {
		$saldo_negativo = true;
	}
}
?>
<?php if($saldo_negativo) { ?>
  <ul class="nav navbar-nav navbar-right">
	<li class="dropdown alert-danger">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">&nbsp;<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></a>
	  <ul class="dropdown-menu aviso" role="menu">
		<li>
			Os seguintes clientes estão com saldo negativo(devendo):
			<div class="cli_aviso_saldo alert alert-danger alert-dismissible" role="alert">
				<?php for($i=0;$i<sizeof($clientes);$i++) {
					if($clientes[$i]['saldo']+$clientes[$i]['bonus'] < 0) {
						$clientes_saldo_negatvo .=  $clientes[$i]['nome']."<br/> ";
					}
				}
				echo substr($clientes_saldo_negatvo,0,-2);
				?>
			</div>
		</li>
	  </ul>
	</li>
  </ul>
<?php } ?>