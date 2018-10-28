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
	$("#btn_data_range").click(function() {
		var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
		$.ajax({
				url: "./ajax_json/ajax_rel_venda_busca.php",
				type: "GET",
				data: 'dti='+$('#start').val()+'&dtf='+$('#end').val()+'&pid='+$('#filtro_produto').val()+'&agrup='+$('input[name=\'agrupamento\']:checked').val(),
				beforeSend: function(){
					$("#venda_info").html("");
					$("#venda_info").append(img)
				},
				complete: function(){
					//$("#venda_info").append(img);
				},
				success:function(result){
					$("#venda_info").html(result);
				}
				}).done(function(result) {
					//alert(result);
				});
	});
	$('#filtro_produto').change(function() {
		if($(this).val()>0){
			$('input[name=\'agrupamento\'][value=\'N\']').prop('checked',true);
			$('input[name=\'agrupamento\']').attr('disabled',true);
		} else {
			$('input[name=\'agrupamento\']').attr('disabled',false);
		}
	});
	$("#btn_print").click(function() {
		window.open('./ajax_json/ajax_rel_venda_busca_print.php?dti='+$('#start').val()+'&dtf='+$('#end').val()+'&pid='+$('#filtro_produto').val()+'&agrup='+$('input[name=\'agrupamento\']:checked').val(), '_blank');
	});
	$('#datepicker').datepicker({
		todayBtn: "linked",
		clearBtn: true,
		language: "pt-BR",
		autoclose: true,
		todayHighlight: true
    });
});
</script>
<div class="form-group divCentro centralizado" style="margin-top:20;max-width:315px;">
	<div class="input-daterange input-group" id="datepicker">
		<input type="text" class="input-sm form-control" name="start" id="start" value="<?=date("d/m/Y")?>" />
		<span class="input-group-addon">Até</span>
		<input type="text" class="input-sm form-control" name="end" id="end" value="<?=date("d/m/Y")?>" />		
	</div>
	<div>
		<select class="form-control" id="filtro_produto">
			<option value="-1" selected="selected" >Todos os Produtos</option>
			<?php for($i=0;$i<sizeof($produtos);$i++) { ?>
				<option value="<?=$produtos[$i]['id']?>"><?=$produtos[$i]['nome']?></option>
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
		<button type="button" class="btn btn-default btn-sm" id="btn_data_range">
		  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		</button>
		<button type="button" class="btn btn-default btn-sm" id="btn_print">
		  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
		</button>
</div>
<hr/>
<div id="venda_info"></div>