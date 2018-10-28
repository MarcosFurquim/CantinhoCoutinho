
<script>
	$(function() {
		$('#produtos_modal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget); // Button that triggered the modal
		  var id_venda = button.data('idvenda'); // Extract info from data-* attributes
		  console.log(id_venda);
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  $.ajax({
						url: "./ajax_json/ajax_produto_venda.php",
						type: "GET",
						data: 'id='+id_venda,
						beforeSend: function(){
							//$("#carregando").show('fast');
							//$("#principal_div").html("");
							//$("#principal_div").append(img)
						},
						complete: function(){
							//$("#principal_div").append(img);
						},
						success:function(result){
							$("#infoProdutos").html(result);
						}
						}).done(function(result) {
							//alert(result);
						});
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this);
		  //modal.find('.modal-body input').val(recipient)
		});
		$('#relatorio_tab a').click(function (e) {
			e.preventDefault();
		  
			var url = $(this).data("url");
			var href = this.hash;
			var pane = $(this);
			
			// ajax load from data-url
			$(href).load(url,function(result){      
				pane.tab('show');
			});
		});

		// load first tab content
		console.log($('.active a'));
		console.log($('.active a').data("url"));
		$('#rel_venda').load($('#relatorio_tab .active a').data("url"),function(result){
		  $('.active a').tab('show');
		});
	});
	function infoProdutos() {
		
	}
	
</script>
<legend>Relatórios</legend>
<ul class="nav nav-tabs"id="relatorio_tab">
  <li role="presentation" class="active"><a href="#rel_venda" data-url="./ajax_json/ajax_rel_venda.php">Venda</a></li>
  <li role="presentation"><a href="#rel_entrada" data-url="./ajax_json/ajax_rel_entrada.php">Despesa</a></li>
  <li role="presentation"><a href="#rel_cliente" data-url="./ajax_json/ajax_rel_cliente.php">Cliente</a></li>
  <li role="presentation"><a href="#rel_produto" data-url="./ajax_json/ajax_rel_produto.php">Produto</a></li>
  <li role="presentation"><a href="#rel_caixa" data-url="./ajax_json/ajax_rel_caixa.php">Caixa</a></li>
</ul>
<div class="tab-content">
	<div id="rel_venda" class="tab-pane active">
	</div>
	<div id="rel_entrada" class="tab-pane">
	</div>
	<div id="rel_cliente" class="tab-pane">
	</div>
	<div id="rel_produto" class="tab-pane">
	</div>
	<div id="rel_caixa" class="tab-pane">
	</div>
</div>

<div class="modal fade" id="produtos_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog w450">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4 class="modal-title centralizado" id="ModalLabel">Produtos da Venda</h4>
      </div>
      <div class="modal-body">
	   <form role="form" class="form-horizontal">
          <div class="form-group">
			<div class="divCentro" id="infoProdutos">
			</div>
          </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>