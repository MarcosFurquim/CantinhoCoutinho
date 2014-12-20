<?php
require_once('./model/Cliente.php');
$clientes = Cliente::getClientes();
?>
<script>
	$(function() {
		$('#creditar_modal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget); // Button that triggered the modal
		  var id_user = button.data('iduser'); // Extract info from data-* attributes
		  var nome_user = button.data('nomeuser'); // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this);
		  modal.find('#ModalLabel').text('Creditar ' + nome_user);
		  modal.find('#id_user').val(id_user);
		  modal.find("#valor").val("");
		  //modal.find('.modal-body input').val(recipient)
		});
		 $('#valor').mask("#.##0,00", {reverse: true});
	});

	function ajaxCreditarUsuario() {
		$.ajax({
					url: "./ajax_json/ajax_credita_usuario.php",
					type: "GET",
					data: 'id='+$("#id_user").val()+'&valor='+$("#valor").val(),
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
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Fone</th>
            <th colspan="3">Crédito</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($clientes);$i++) { ?>  
		<tr>
			<td><?=$clientes[$i]['nome']?></td>
			<td><?=$clientes[$i]['email']?></td>
			<td><?=$clientes[$i]['tel']?></td>
			<td><?=number_format($clientes[$i]['saldo'], 2, ',', '.')?></td>
			<td>
				<button data-nomeuser="<?=$clientes[$i]['nome']?>" data-iduser="<?=$clientes[$i]['id']?>"  data-toggle="modal" data-target="#creditar_modal" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span></button>
			</td>
			<td>
				<button type="button" class="btn btn-default" onclick="location.href='?page=editaCliente&id=<?=$clientes[$i]['id']?>'"><span class="glyphicon glyphicon-pencil"></span></button>
			</td>
			<td>
				<button type="button" class="btn btn-default" onclick="ajaxExcluiCliente(<?=$clientes[$i]['id']?>)"><span class="glyphicon glyphicon-remove-sign"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>
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
			<div class="input-group col-sm-4 divCentro">
				<span class="input-group-addon">R$</span>
				<input type="text" class="form-control" id="valor" placeholder="Valor">
				<input type="hidden"  id="id_user">
			</div>
          </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" onclick="ajaxCreditarUsuario()">Salvar</button>
      </div>
    </div>
  </div>
</div>