
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
				data: 'dti='+$('#start').val()+'&dtf='+$('#end').val(),
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
	$('#datepicker').datepicker({
		todayBtn: "linked",
		clearBtn: true,
		language: "pt-BR",
		autoclose: true,
		todayHighlight: true
    });
});
</script>
<div class="form-group divCentro centralizado">
	<div class="input-daterange input-group" id="datepicker">
		<input type="text" class="input-sm form-control" name="start" id="start" value="<?=date("d/m/Y")?>" />
		<span class="input-group-addon">Até</span>
		<input type="text" class="input-sm form-control" name="end" id="end" value="<?=date("d/m/Y")?>"" />		
	</div>
		<button type="button" class="btn btn-default btn-sm" id="btn_data_range">
		  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		</button>
</div>
<div id="venda_info"></div>