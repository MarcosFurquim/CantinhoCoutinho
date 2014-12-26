<?php
require_once('./model/Cliente.php');

$clientes = Cliente::getClientes();

?>
<script>
	$(function() {
		$("#nome_cliente").hide();
	});
	
	function adicionaProdutoTrigger() {
		$(function() {
			$( "#widgetProduto tbody tr" ).click(function() {
				if(!$("#ProdutosAdicionados").find("[data-id='"+$(this).children("td:last-child").data("id")+"']").length) {
					$('#ProdutosAdicionados tbody:last').append("<tr>"+$(this).html()+"<td><input type='text' value='1' name=qnt["+$(this).children("td:last-child").data("id")+"] style='width: 52px;' /><td>"+$(this).children("td:last-child").html()+"</td></tr>");
					//$('#ProdutosAdicionados tbody:last').append("<tr><td>"+$(this).children("td:first-child")+"</td><td>"+$(this).children("td:last-child")+"</td></tr>");
					$("input[name^='qnt']").mask('0#');
					calculaTotalVenda();
					$("#detalheProduto").show();
					$("input[name^='qnt']").keyup(function() {
						var preco = numeral().unformat($(this).parent().prev().html());
						var vlr_total = ($(this).val()*preco);
						var numero_formato = numeral(vlr_total).format('0,0.00');
						$(this).parent().next().html(numero_formato);
						calculaTotalVenda();
					});
				}
			});
		});
	}
	
	function calculaTotalVenda() {
		var total=0;
		$('#ProdutosAdicionados tbody tr td:last-child').each(function() {
			total += numeral().unformat($(this).text());
		});
		$("#total_valor_venda").html(numeral(total).format('0,0.00'));
		$("[name='hdn_total_valor_venda']").val(total);
	}
	
	function AbreDivComCadastro(rd) {
		if(rd.value=="S") {
			$("#cliente").show();
			$("#nome_cliente").hide();
			$("[name='hdn_cli_saldo']").val($(cliente).find("option:selected").data('saldo'));
		} else if(rd.value=="N") {
			$("#cliente").hide();
			$("#nome_cliente").show();
			$("[name='hdn_cli_saldo']").val(-1);
				
		}
	}
	
	function mostraInfoCliente(cliente) {
		//$("#prod_nome").text(prod.options[prod.selectedIndex].text);
		//$("#prod_preco").text(prod.value);
		$("#cli_nome").text($(cliente).find("option:selected").text());
		$("#cli_saldo").text(numeral($(cliente).find("option:selected").data('saldo')).format('0,0.00'));
		$("[name='hdn_cli_saldo']").val($(cliente).find("option:selected").data('saldo'));
		$("#detalheCliente").show();
	
	}
	
	function mostraInfoProd(prod) {
		//$("#prod_nome").text(prod.options[prod.selectedIndex].text);
		//$("#prod_preco").text(prod.value);
		$("#prod_nome").text($(prod).find("option:selected").text());
		$("#prod_preco").text($(prod).find("option:selected").data('preco'));
		$("#detalheProduto").show();
	
	}
	function mostraWidgetProduto(input) {
		var nomeProduto = $("[name='buscaProduto']").val();
		console.log(nomeProduto);
		$.ajax({
					url: "./ajax_json/widget_produtos.php",
					type: "GET",
					data: 'nome='+nomeProduto,
					beforeSend: function(){
						//$("#carregando").show('fast');
						//$("#principal_div").html("");
						//$("#principal_div").append(img)
					},
					complete: function(){
						//$("#principal_div").append(img);
					},
					success:function(result){
						$("#widgetProduto").html(result)
					}
					}).done(function(result) {
						adicionaProdutoTrigger();
					});
	
		// .position() uses position relative to the offset parent, 
		//var pos = $(input).position();
		var pos = $(input).parent().offset();
		console.log(pos);
		// .outerWidth() takes into account border and padding.
		//var width = $(input).outerWidth();
		var width = $(input).parent().height();
		 //show the menu directly over the placeholder
		$("#widgetProduto").css({
			position: "absolute",
			top: (pos.top+width) + "px",
			left: (pos.left) + "px",
			zIndex: "100"
		}).show();
		$(document).mouseup(function (e)
		{
			var container = $("#widgetProduto");
			if ((!container.is(e.target)) // if the target of the click isn't the container...
				&& (container.has(e.target).length === 0) // ... nor a descendant of the container
				&& (e.target.name != "buscaProduto")) 
			{
				container.hide();
			}
		});
		
	}
	
		function validaVenda() {
			// console.log("hdn saldo:"+$("[name='hdn_cli_saldo']").val());
			// console.log("rd input:"+$("input[name=cadastro]:checked").val());
			// console.log("nome cliente input:"+$("#nome_cliente").val());
			// console.log("cliente select:"+$("#cliente").val());
			// console.log("div produtos:"+$("#detalheProduto").is(':visible'));
			
			// console.log("1:"+($("[name='hdn_cli_saldo']").val() != -1 && $("[name='hdn_cli_saldo']").val() != ""));
			// console.log("2:"+($("input[name=cadastro]:checked").val() == 'N' && $("#nome_cliente").val() == ""));
			// console.log("3:"+($("input[name=cadastro]:checked").val() == 'S' && $("#cliente").val()==null));
			// console.log("4:"+(!$("#detalheProduto").is(':visible')));
			
			if($("[name='hdn_cli_saldo']").val() != -1 && $("[name='hdn_cli_saldo']").val() != "")
			{
				var saldo_cli = parseFloat($("[name='hdn_cli_saldo']").val());
				var total_venda = parseFloat($("[name='hdn_total_valor_venda']").val());
				if(saldo_cli < total_venda) {
					alert('Saldo do cliente insuficiente para venda');
					return false;
				}
			}
			if($("input[name=cadastro]:checked").val() == 'N' && $("#nome_cliente").val() == "") {
				alert('Digite o nome do cliente');
				return false;
			}
			else if($("input[name=cadastro]:checked").val() == 'S' && $("#cliente").val()==null) {
				alert('Escolha o cliente');
				return false;
			}
			else if(!$("#detalheProduto").is(':visible')) {
				alert('Escolha ao menos um produto para venda');
				return false;
			}
			return true;
		}
</script>
<style>
	#nome_cliente {
		display:block;
	}
	#detalheProduto {
		float:none;
		display:none;
		border: dotted 1px #000;
		margin-left: auto;
		margin-right: auto;
		margin-top: 30px;
		width: auto;
	}
	#detalheCliente {
		text-align:center;
		float:none;
		display:none;
		border: dotted 1px #000;
		margin-left: auto;
		margin-right: auto;
		margin-top: 30px;
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
		#widgetProduto {
			display:none;
			background: #fff;
			border: 1px solid #d3d3d3;
			outline: none;
			overflow: visible;
			padding: 10px 0;
			box-shadow: 0 2px 4px rgba(0,0,0,.2);
		}
</style>
<div>
<legend>Venda</legend>
<fieldset>
<form method="post" action="./control/controlVenda.php" onsubmit="return validaVenda();"  role="form">
	<div class="form-group">
        <label class="control-label">Cliente</label>
        <div>
            <label class="radio-inline">
               <input type="radio" name="cadastro" id="rd_com_cadastro" value="S"  checked onclick="AbreDivComCadastro(this)" /> Com Cadastro
            </label>
            <label class="radio-inline">
                <input type="radio" name="cadastro" id="rd_sem_cadastro" value="N" onclick="AbreDivComCadastro(this)" /> Sem Cadastro
            </label>
        </div>
    </div>
	<div class="form-group">
		<div class="selectContainer">
			<label class="control-label field">Cliente:&nbsp;</label>
			<select class="form-control"  name="cliente" id="cliente" onchange="mostraInfoCliente(this)">
				<option value="-1" selected="selected" disabled >Selecione o Cliente</option>
				<?php for($i=0;$i<sizeof($clientes);$i++) { ?>
					<option value="<?=$clientes[$i]['id']?>" data-saldo="<?=$clientes[$i]['saldo']?>"><?=$clientes[$i]['nome']?></option>
				<?php } ?>
			</select>
			<input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Nome do Cliente" />
		</div>
	</div>
	<div class="form-group">
		<label  for="buscaProduto" class="control-label field">Produtos:&nbsp;</label>
		<!--<select class="form-control" id="produto" onchange="mostraInfo(this)">
			<option value="" selected="selected" disabled >Selecione o Produto</option>
			<?php for($i=0;$i<sizeof($produtos);$i++) { ?>
				<option value="<?=$produtos[$i]['id']?>" data-preco="<?=$produtos[$i]['preco']?>"><?=$produtos[$i]['nome']?></option>
			<?php } ?>
		</select>-->
		<div>
			<div id="imaginary_container"> 
				<div class="input-group stylish-input-group">
					<input type="text" class="form-control"  placeholder="Busca Produto" onfocus="mostraWidgetProduto(this)" onkeyup="mostraWidgetProduto(this)" name="buscaProduto" >
					<span class="input-group-addon">
						
							<span class="glyphicon glyphicon-search"></span>
						 
					</span>
				</div>
				<div id="widgetProduto">
					
				</div>
			</div>
		</div>
	</div>	
	
	<div id="detalheCliente" class=" col-sm-offset-3 col-sm-5 ">
		<b>Nome:&nbsp;</b><span id="cli_nome"></span><br/>
		<b>Crédito(R$):&nbsp;</b><span id="cli_saldo"></span><br/>
	</div>
	<div id="detalheProduto" class=" col-sm-offset-3 col-sm-5 ">
		<table id="ProdutosAdicionados" class="table">
			<thead>
				<th>Nome</th>
				<th>Preço(R$)</th>
				<th>Quantidade</th>
				<th>Preço Total(R$)</th>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<th colspan="3">Total:</th>
				<th id="total_valor_venda"></th>
			</tfoot>
		</table>
	</div>
	<div class="form-group"  style="display:block; margin-top: 30px;">
		<label class="control-label field">&nbsp;</label>
		<button type="submit" class="btn btn-success">Vender</button>
		<input type="hidden"  name="hdn_cli_saldo" value="" />
		<input type="hidden"  name="hdn_total_valor_venda" value="" />
	</div>
</form>
</fieldset>
</div>