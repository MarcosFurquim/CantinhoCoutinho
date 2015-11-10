<?php
require_once('./model/Fornecedor.php');

$fornecedores = Fornecedor::getFornecedores();

?>
<script src="./js/datapicker-13.1/js/bootstrap-datepicker.js"></script>
<script src="./js/datapicker-13.1/js/locales/bootstrap-datepicker.pt-BR.js"></script>
<link rel="stylesheet" href="./js/datapicker-13.1/css/datepicker3.css">
<script>
	$(function() {
		//$("#campoData").mask("99/99/9999");
		$("#campoData").datepicker({
			todayBtn: "linked",
			clearBtn: true,
			language: "pt-BR",
			autoclose: true,
			todayHighlight: true
		});
		$("#campoData").prop('disabled', true);
		$('#valor_entrada').mask("#.##0,00", {reverse: true});
	});
	function modificaData(rd) {
		if(rd.value=="S") {
			 $("#campoData").prop('disabled', true);
			 //var d = new Date();
			 $("#campoData").val('<?=date("d/m/Y")?>');
		} else if(rd.value=="N") {
			$("#campoData").prop('disabled', false);
		}
	}
	function adicionaFornecedorTrigger() {
		$(function() {
			$( "#widgetFornecedor tbody tr" ).click(function() {
				$('#nome_fornecedor').html($(this).children("td:first-child").html());
				$('#descricao_fornecedor').html($(this).attr("forne-desc"));
				//$('#FornecedorSelecionado tbody:last').html("<tr>"+$(this).html());
				//$('#FornecedorSelecionado tbody:last').html("<tr>"+$(this).html()+$(this).children("td:last-child").html()+"</td></tr>");
				$("#detalheFornecedor").show();
				$("#fornecedor_id").val($(this).attr("forne-id"));
				$("#widgetFornecedor").hide();
			});
		});
	}

	
	function mostraWidgetFornecedor(input) {
		var nomeFornecedor = $("[name='buscaFornecedor']").val();
		$.ajax({
					url: "./ajax_json/widget_fornecedores.php",
					type: "GET",
					data: 'nome='+nomeFornecedor,
					beforeSend: function(){
						//$("#carregando").show('fast');
						//$("#principal_div").html("");
						//$("#principal_div").append(img)
					},
					complete: function(){
						//$("#principal_div").append(img);
					},
					success:function(result){
						$("#widgetFornecedor").html(result)
					}
					}).done(function(result) {
						adicionaFornecedorTrigger();
					});
	
		// .position() uses position relative to the offset parent, 
		//var pos = $(input).position();
		var pos = $(input).parent().offset();
		//console.log(pos);
		// .outerWidth() takes into account border and padding.
		//var width = $(input).outerWidth();
		var width = $(input).parent().height();
		 //show the menu directly over the placeholder
		$("#widgetFornecedor").css({
			position: "absolute",
			top: (pos.top+width) + "px",
			left: (pos.left) + "px",
			zIndex: "100"
		}).show();
		$(document).mouseup(function (e)
		{
			var container = $("#widgetFornecedor");
			if ((!container.is(e.target)) // if the target of the click isn't the container...
				&& (container.has(e.target).length === 0) // ... nor a descendant of the container
				&& (e.target.name != "buscaFornecedor")) 
			{
				container.hide();
			}
		});
		
	}
	
		function validaEntrada() {
			if($("#valor_entrada").val()=="") {
				alert('Digite um valor');
				return false;
			}
			if($("#fornecedor_id").val()=="") {
				alert('Selecione um fornecedor');
				return false;
			}
			return true;
		}
</script>
<style>
	#detalheFornecedor {
		float:none;
		display:none;
		//border: dotted 1px #000;
		margin-left: auto;
		margin-right: auto;
		margin-top: 30px;
		margin-bottom: 15px;
		width: auto;
	}
	#imaginary_container{
		//margin-top:20%; /* Don't copy this */
	}
	.stylish-input-group .input-group-addon{
		background: white !important; 
	}
	.stylish-input-group .form-control{
		border-right:0; 
		box-shadow:0 0 0; 
		border-color:#ccc;
	}
	.stylish-input-group button{
		border:0;
		background:transparent;
	}
	#widgetFornecedor {
		display:none;
		background: #fff;
		border: 1px solid #d3d3d3;
		outline: none;
		overflow: visible;
		overflow-y: scroll;
		max-height: 300px;
		padding: 10px 0;
		box-shadow: 0 2px 4px rgba(0,0,0,.2);
	}
	#campoData {
		display: inline;
		width: 100px;
	}
	#hr_divide {
		margin:10px 0px;
	}
</style>
<div>
<legend>Despesa</legend>
<fieldset>
<form method="post" action="./control/controlEntrada.php" onsubmit="return validaEntrada();"  role="form">
	<div class="form-group">
		<label  for="buscaFornecedor" class="control-label field">Fornecedor:&nbsp;</label>
		<div>
			<div id="imaginary_container"> 
				<div class="input-group stylish-input-group">
					<input type="text" autocomplete="off" class="form-control"  placeholder="Busca Fornecedor" onfocus="mostraWidgetFornecedor(this)" onkeyup="mostraWidgetFornecedor(this)" name="buscaFornecedor" >
					<span class="input-group-addon">
						
							<span class="glyphicon glyphicon-search"></span>
						 
					</span>
				</div>
				<div id="widgetFornecedor">
					
				</div>
			</div>
		</div>
	</div>	
	<div id="detalheFornecedor" class=" col-sm-offset-3 panel panel-info">
		<div class="panel-heading">Fornecedor Selecionado</div>
		<div class="panel-body">
			<div id="FornecedorSelecionado">
				<span id="nome_fornecedor" style="font-weight:bold">NOME FORNECEDOR</span>
				<hr>
				<span id="descricao_fornecedor">descricao aki</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="valor_entrada" class="control-label">Valor:</label>
		<div class="input-group col-sm-2">
		  <input type="text" class="form-control" name="valor_entrada" id="valor_entrada" placeholder="Valor Entrada"  />
		</div>
	</div>
	<div class="form-group">
        <label class="control-label">Data</label>
        <div>
            <label class="radio-inline">
               <input type="radio" name="data" id="rd_dt_hj" value="S"  checked onclick="modificaData(this)" /> Hoje
            </label>
            <label class="radio-inline">
                <input type="radio" name="data" id="rd_sem_cadastro" value="N" onclick="modificaData(this)" /> Data específica:
            </label>
			<input type="text" class="form-control" name="campoData" id="campoData" value="<?=date('d/m/Y')?>"/>
        </div>
    </div>
	<hr id="hr_divide" />
	<div class="form-group"  style="display:block; margin-top: 30px;">
		<label class="control-label field">&nbsp;</label>
		<button type="submit" class="btn btn-success">OK</button>
		<input type="hidden" name="fornecedor_id" id="fornecedor_id" />
	</div>
</form>
</fieldset>
</div>