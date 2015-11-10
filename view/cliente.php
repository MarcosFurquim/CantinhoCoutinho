<?php
require_once('./model/Cliente.php');
$clientes = Cliente::getClientes("",0);
$clientes_qnt = Cliente::getCount();

$qnt_page = number_format($clientes_qnt/10,2);
$qnt_page = (substr($qnt_page, strrpos($qnt_page, ".")+1, 1) > 0)?(substr($qnt_page, 0, strrpos($qnt_page, "."))+1):substr($qnt_page, 0, strrpos($qnt_page, "."));

for($i=0;$i<sizeof($clientes);$i++) {
	if($clientes[$i]['saldo']<0) {
		if($clientes[$i]['saldo']+$clientes[$i]['bonus']>0) {
			$clientes[$i]['bonus']+=$clientes[$i]['saldo'];
			$clientes[$i]['saldo'] =0;
		} else {
			$clientes[$i]['saldo'] +=$clientes[$i]['bonus'];
			$clientes[$i]['bonus']=0;
		}
	}
}
?>
<script>
	$(function() {
		$('#creditar_modal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget); // Button that triggered the modal
		  var id_user = button.data('iduser'); // Extract info from data-* attributes
		  var tipo_credito = button.data('tipocredito'); // Extract info from data-* attributes
		  var texto_tipo=(tipo_credito=='C')?'Creditar':'Bonificar';
		  var nome_user = button.data('nomeuser'); // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this);
		  modal.find('#ModalLabel').text(texto_tipo+' ' + nome_user);
		  modal.find('#id_user').val(id_user);
		  modal.find('#tipo_credito').val(tipo_credito);
		  modal.find("#valor").val("");
		  $('#valor').mask("#.##0,00", {reverse: true});
		});
		$('#creditar_modal').on('shown.bs.modal', function (event) {
			$('#valor').focus();
		});
		$("body").keypress(function(event){
			 var keycode = (event.keyCode ? event.keyCode : event.which);
			// console.log(keycode);
			// console.log(event.currentTarget);
			// console.log($(event.currentTarget).hasClass("modal-open"));
			if(event.keyCode == 13 && $(event.currentTarget).hasClass("modal-open")){//tecla enter e tela de credito estiver aberto
				event.preventDefault();
				ajaxCreditarUsuario();
			}
		});
		 
		 function paginacao(){
			$('#paginacao a').click(function (e) {
				e.preventDefault();
				var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
				$.ajax({
						url: "./ajax_json/ajax_busca_cliente.php",
						type: "GET",
						data: 'nome='+$('#filtro_nome_cliente').val()+'&pag='+$(this).html(),
						beforeSend: function(){
							$("#cliente_list").html("");
							$("#cliente_list").append(img)
						},
						complete: function(){
							//$("#cliente_list").append(img);
						},
						success:function(result){
							$("#cliente_list").html(result);
						}
						}).done(function(result) {
							//alert(result);
						});
			});
		}
		paginacao();
		$('#paginacao li:nth-child(1)').toggleClass("active");
		$('#filtro_nome_cliente').keyup(function() {
			var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
			$.ajax({
					url: "./ajax_json/ajax_busca_cliente.php",
					type: "GET",
					data: 'nome='+$(this).val()+'&pag=1',
					beforeSend: function(){
						$("#cliente_list").html("");
						$("#cliente_list").append(img)
					},
					complete: function(){
						//$("#cliente_list").append(img);
					},
					success:function(result){
						$("#cliente_list").html(result);
						//caso o filtro estiver vazio, entao qnt é a mesma da original, senao pega de qts voltaram
						var qnt_reg;
						if($("#filtro_nome_cliente").val()=="") {
							qnt_reg = parseInt($("#paginacao").data("treg"));
						} else {
							qnt_reg = $("table tbody tr").length;
						}
						//atualiza numero acima da tabela
						$(".divqnt span b").html(qnt_reg);
						//calcula qnt de pagina a partir de qnts resultados foram encontrados
						var qnt_page = qnt_reg/10;
						qnt_page = (qnt_page.toString().substr(2, 1) > 0)?(parseInt(qnt_page.toString().substr(0, 1))+1):qnt_page.toString().substr(0, 1);
						console.log(qnt_page);
						//limpa a paginacao
						$("#paginacao").html("");
						//monta paginacao
						for(var i=1;i<=qnt_page;i++) {
							$("#paginacao").append("<li><a href='#'>"+i+"</a></li>");
						}
						//ativa a primeira pagina
						$('#paginacao li:nth-child(1)').toggleClass("active");
						paginacao();
					}
					}).done(function(result) {
						//alert(result);
					});
		});
		 $("[data-tt=tooltip]").tooltip();
	});

	function ajaxCreditarUsuario() {
		if(numeral().unformat($("#valor").val()) > 0) {
			$.ajax({
						url: "./ajax_json/ajax_credita_usuario.php",
						type: "GET",
						data: 'id='+$("#id_user").val()+'&valor='+$("#valor").val()+'&tipocredito='+$("#tipo_credito").val(),
						beforeSend: function(){
							//$("#carregando").show('fast');
							//$("#principal_div").html("");
							//$("#principal_div").append(img)
						},
						complete: function(){
							//$("#principal_div").append(img);
						},
						success:function(result){
							if(result>0) {
								alert('Creditado cliente com sucesso!');
								location.reload();
							}
						}
						}).done(function(result) {
							//alert(result);
						});
		} else {
			return false;
		}
	}
	
	function ajaxExcluiCliente(idUser) {
		if(confirm('Deseja realmente excluir esse cliente?')) {
			$.ajax({
					url: "./ajax_json/ajax_exclui_usuario.php",
					type: "GET",
					data: 'id='+idUser,
					beforeSend: function(){
						//$("#carregando").show('fast');
						//$("#principal_div").html("");
						//$("#principal_div").append(img)
					},
					complete: function(){
						//$("#principal_div").append(img);
					},
					success:function(result){
						if(result>0) {
							alert('exclusão de cliente efetuado com sucesso!');
							location.reload();
						}
					}
					}).done(function(result) {
						//alert(result);
					});
		}
	}
</script>
<div class="divbotao_novo"><button class="btn btn-default btn-sm" onclick="location.href='?page=CadastroCliente'">Novo</button></div>
<div class="divqnt"><span><b><?=$clientes_qnt?></b></span> cliente(s)</div>
<div class="form-group " style="margin-top:30px;">
	<input type="text" class="form-control" placeholder="Filtrar por nome" id="filtro_nome_cliente" />
</div>
<div id="cliente_list" class="form-group">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Email</th>
				<th>Fone</th>
				<th>Saldo (R$)</th>
				<th>Bônus (R$)</th>
				<th colspan="5">Saldo Final (R$)</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<sizeof($clientes);$i++) { ?>  
			<tr <?php echo ($clientes[$i]['saldo'] < 0)?"class='danger'":""; ?>>
				<td><?=$clientes[$i]['nome']?></td>
				<td><?=$clientes[$i]['email']?></td>
				<td><?=$clientes[$i]['tel']?></td>
				<td><?=number_format($clientes[$i]['saldo'], 2, ',', '.')?></td>
				<td><?=number_format($clientes[$i]['bonus'], 2, ',', '.')?></td>
				<td><?=number_format(($clientes[$i]['saldo']+$clientes[$i]['bonus']), 2, ',', '.')?></td>
				<td>
					<button data-nomeuser="<?=$clientes[$i]['nome']?>" data-iduser="<?=$clientes[$i]['id']?>"  data-toggle="modal" data-target="#creditar_modal" type="button" class="btn btn-success" data-tt='tooltip' title='Creditar Cliente' data-tipocredito="C"><span class="glyphicon glyphicon-plus"></span></button>
				</td>
				<td>
					<button data-nomeuser="<?=$clientes[$i]['nome']?>" data-iduser="<?=$clientes[$i]['id']?>"  data-toggle="modal" data-target="#creditar_modal" type="button" class="btn btn-primary" data-tt='tooltip' title='Bonificar Cliente' data-tipocredito="B"><span class="glyphicon glyphicon-plus"></span></button>
				</td>
				<td>
					<button type="button" class="btn btn-info" onclick="location.href='?page=editaCliente&id=<?=$clientes[$i]['id']?>'" data-tt='tooltip' title='Editar Cliente'><span class="glyphicon glyphicon-pencil"></span></button>
				</td>
				<td>
					<button type="button" class="btn btn-danger" onclick="ajaxExcluiCliente(<?=$clientes[$i]['id']?>)" data-tt='tooltip' title='Excluir Cliente'><span class="glyphicon glyphicon-remove"></span></button>
				</td>
			</tr>
			<?php } ?>  
		</tbody>
	</table>
</div>
<hr/>
<div class="modal fade" id="creditar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog w450">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4 class="modal-title centralizado" id="ModalLabel">Creditar Cliente</h4>
      </div>
      <div class="modal-body">
	   <form role="form" class="form-horizontal">
          <div class="form-group">
			<div class="input-group col-sm-4 divCentro" style="max-width:215px;">
				<span class="input-group-addon">R$</span>
				<input type="text" class="form-control" id="valor" placeholder="Valor">
				<input type="hidden"  id="id_user">
				<input type="hidden"  id="tipo_credito">
			</div>
          </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" onclick="ajaxCreditarUsuario()" id="btn_creditar">Salvar</button>
      </div>
    </div>
  </div>
</div>
<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao" data-treg="<?=$clientes_qnt?>">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>