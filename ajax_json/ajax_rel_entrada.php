<?php
date_default_timezone_set("Brazil/East");
require_once ('../lib/libdba.php');
require_once ('../model/Fornecedor.php');
$fornecedores = Fornecedor::getFornecedores();

?>
<script src="./js/datapicker-13.1/js/bootstrap-datepicker.js"></script>
<script src="./js/datapicker-13.1/js/locales/bootstrap-datepicker.pt-BR.js"></script>
<link rel="stylesheet" href="./js/datapicker-13.1/css/datepicker3.css">
<script>
$(function() {
	$("#btn_data_range_entrada").click(function() {
		var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
		$.ajax({
				url: "./ajax_json/ajax_rel_entrada_busca.php",
				type: "GET",
				data: 'dti='+$('#start_entrada').val()+'&dtf='+$('#end_entrada').val()+'&fid='+$('#filtro_fornecedor').val()+'&agrup='+$('input[name=\'agrupamento\']:checked').val(),
				beforeSend: function(){
					$("#entrada_info").html("");
					$("#entrada_info").append(img)
				},
				complete: function(){
					//$("#entrada_info").append(img);
				},
				success:function(result){
					$("#entrada_info").html(result);
				}
				}).done(function(result) {
					//alert(result);
				});
	});
		$('#filtro_fornecedor').change(function() {
		if($(this).val()>0){
			$('input[name=\'agrupamento\'][value=\'N\']').prop('checked',true);
			$('input[name=\'agrupamento\']').attr('disabled',true);
		} else {
			$('input[name=\'agrupamento\']').attr('disabled',false);
		}
	});
	$('#datepicker_entrada').datepicker({
		todayBtn: "linked",
		clearBtn: true,
		language: "pt-BR",
		autoclose: true,
		todayHighlight: true
    });
});
</script>
<div class="form-group divCentro centralizado" style="margin-top:20;max-width:315px;">
	<div class="input-daterange input-group" id="datepicker_entrada">
		<input type="text" class="input-sm form-control" name="start" id="start_entrada" value="<?=date("d/m/Y")?>" />
		<span class="input-group-addon">Até</span>
		<input type="text" class="input-sm form-control" name="end" id="end_entrada" value="<?=date("d/m/Y")?>" />		
	</div>
	<div>
		<select class="form-control" id="filtro_fornecedor">
			<option value="-1" selected="selected" >Todos os Fornecedores</option>
			<?php for($i=0;$i<sizeof($fornecedores);$i++) { ?>
				<option value="<?=$fornecedores[$i]['id']?>"><?=$fornecedores[$i]['nome']?></option>
			<?php } ?>
		</select>
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
		<button type="button" class="btn btn-default btn-sm" id="btn_data_range_entrada">
		  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		</button>
		<button type="button" class="btn btn-default btn-sm" id="btn_print">
		  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
		</button>
</div>
<hr/>
<div id="entrada_info"></div>