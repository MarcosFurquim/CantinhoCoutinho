<?php
date_default_timezone_set("Brazil/East");
require_once ('../lib/libdba.php');
require_once ('../model/Produto.php');
$produtos = Produto::getProdutos();

?>
<script src="./js/datapicker-13.1/js/bootstrap-datepicker.js"></script>
<script src="./js/datapicker-13.1/js/locales/bootstrap-datepicker.pt-BR.js"></script>
<link rel="stylesheet" href="./js/datapicker-13.1/css/datepicker3.css">
<script>
$(function() {
	$("#btn_data_range_p").click(function() {
		var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
		$.ajax({
				url: "./ajax_json/ajax_rel_produto_busca.php",
				type: "GET",
				data: 'dti='+$('#start_p').val()+'&dtf='+$('#end_p').val()+'&pid='+$('#filtro_produto_p').val(),
				beforeSend: function(){
					$("#produto_info").html("");
					$("#produto_info").append(img)
				},
				complete: function(){
					//$("#produto_info").append(img);
				},
				success:function(result){
					$("#produto_info").html(result);
				}
				}).done(function(result) {
					//alert(result);
				});
	});
	$('#datepicker_p').datepicker({
		todayBtn: "linked",
		clearBtn: true,
		language: "pt-BR",
		autoclose: true,
		todayHighlight: true
    });
});
</script>
<div class="form-group divCentro centralizado" style="margin-top:20;max-width:315px;">
	<div class="input-daterange input-group" id="datepicker_p">
		<input type="text" class="input-sm form-control" name="start" id="start_p" value="<?=date("d/m/Y")?>" />
		<span class="input-group-addon">Até</span>
		<input type="text" class="input-sm form-control" name="end" id="end_p" value="<?=date("d/m/Y")?>"" />		
	</div>
	<div>
		<select class="form-control" id="filtro_produto_p" >
			<option value="-1" selected="selected" >Produtos Mais Vendidos</option>
			<?php for($i=0;$i<sizeof($produtos);$i++) { ?>
				<option value="<?=$produtos[$i]['id']?>"><?=$produtos[$i]['nome']?></option>
			<?php } ?>
		</select>
	</div>
		<button type="button" class="btn btn-default btn-sm" id="btn_data_range_p">
		  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		</button>
</div>
<hr/>
<div id="produto_info"></div>