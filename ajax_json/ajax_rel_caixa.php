<?php
date_default_timezone_set("Brazil/East");
require_once ('../lib/libdba.php');
require_once ('../model/Caixa.php');
$caixa = Caixa::getCaixaReal();
?>
<script src="./js/datapicker-13.1/js/bootstrap-datepicker.js"></script>
<script src="./js/datapicker-13.1/js/locales/bootstrap-datepicker.pt-BR.js"></script>
<link rel="stylesheet" href="./js/datapicker-13.1/css/datepicker3.css">
<script>
$(function() {
	$("#btn_data_range_caixa").click(function() {
		var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
		$.ajax({
				url: "./ajax_json/ajax_rel_caixa_busca.php",
				type: "GET",
				data: 'dti='+$('#start_caixa').val()+'&dtf='+$('#end_caixa').val()+'&agrup='+$('input[name=\'agrupamento\']:checked').val(),
				beforeSend: function(){
					$("#caixa_info").html("");
					$("#caixa_info").append(img)
				},
				complete: function(){
					//$("#entrada_info").append(img);
				},
				success:function(result){
					$("#caixa_info").html(result);
				}
				}).done(function(result) {
					//alert(result);
				});
	});

	$('#datepicker_caixa').datepicker({
		todayBtn: "linked",
		clearBtn: true,
		language: "pt-BR",
		autoclose: true,
		todayHighlight: true
    });
});
</script>
<div class="form-group divCentro centralizado" style="margin-top:20;max-width:315px;">
	<div class="input-daterange input-group" id="datepicker_caixa">
		<input type="text" class="input-sm form-control" name="start" id="start_caixa" value="<?=date("d/m/Y")?>" />
		<span class="input-group-addon">Até</span>
		<input type="text" class="input-sm form-control" name="end" id="end_caixa" value="<?=date("d/m/Y")?>" />		
	</div>
	<div class="form-group">
        <label class="control-label">Agrupar por dia?</label>
        <div>
            <label class="radio-inline">
               <input type="radio" name="agrupamento" value="S" /> Sim
            </label>
            <label class="radio-inline">
                <input type="radio" name="agrupamento" value="N" checked /> Não
            </label>
        </div>
    </div>
		<button type="button" class="btn btn-default btn-sm" id="btn_data_range_caixa">
		  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		</button>
		<!--<button type="button" class="btn btn-default btn-sm" id="btn_print">
		  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
		</button>-->
</div>
<hr/>
<div id="caixa_info"></div>