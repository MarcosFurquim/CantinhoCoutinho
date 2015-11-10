<?php
require_once ('../lib/libdba.php');
require_once('../model/Cliente.php');
$clientes = Cliente::getClientes();

?>
<script>
$(function() {
	$("#cliente").change(function() {
		var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
		$.ajax({
				url: "./ajax_json/ajax_rel_cliente_busca.php",
				type: "GET",
				data: 'id='+$(this).val(),
				beforeSend: function(){
					$("#cliente_info").html("");
					$("#cliente_info").append(img)
				},
				complete: function(){
					//$("#cliente_info").append(img);
				},
				success:function(result){
					$("#cliente_info").html(result);
					$("#saldo_cli b").html(numeral($("#cliente").find("option:selected").data('saldo')).format('0,0.00'));
				}
				}).done(function(result) {
				});
	});
});
</script>
<div class="form-group">
	<div class="selectContainer">
		<label class="control-label field">Cliente:&nbsp;</label>
		<select class="form-control"  name="cliente" id="cliente">
			<option value="" selected="selected" disabled >Selecione o Cliente</option>
			<?php for($i=0;$i<sizeof($clientes);$i++) { ?>
				<option value="<?=$clientes[$i]['id']?>" data-saldo="<?=($clientes[$i]['saldo']+$clientes[$i]['bonus'])?>"><?=$clientes[$i]['nome']?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div id="cliente_info"></div>
