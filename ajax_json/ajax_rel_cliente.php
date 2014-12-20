<?php
require_once ('../lib/libdba.php');
require_once('../model/Cliente.php');
$clientes = Cliente::getClientes();

?>
<div class="form-group">
	<div class="selectContainer">
		<label class="control-label field">Cliente:&nbsp;</label>
		<select class="form-control"  name="cliente" id="cliente" onchange="mostraInfoCliente(this)">
			<option value="" selected="selected" disabled >Selecione o Cliente</option>
			<?php for($i=0;$i<sizeof($clientes);$i++) { ?>
				<option value="<?=$clientes[$i]['id']?>" data-saldo="<?=$clientes[$i]['saldo']?>"><?=$clientes[$i]['nome']?></option>
			<?php } ?>
		</select>
	</div>
</div>
<table class="table table-hover table-striped" >
	
</table>