<script>
	$(function() {
		 $('#preco_pro').mask("#.##0,00", {reverse: true});
	});
</script>
<form class="form-horizontal" name="frm_cadastra_usuario" role="form" method="post" action="./control/controlProduto.php">
	<legend>Cadastro Produto</legend>
	<fieldset>
		<div class="form-group">
			<label for="nome_pro" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nome_pro" id="nome_pro" placeholder="Nome" />
			</div>
		</div>
		<div class="form-group">
			<label for="preco_pro" class="col-sm-2 control-label">Preço</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="preco_pro" id="preco_pro" placeholder="Preço" />
			</div>
		</div>
		<div class="form-group">
			<label for="desc_prod" class="col-sm-2 control-label">Descrição</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="desc_prod" id="desc_prod" placeholder="Descrição do Produto" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" name="btn_cadastrar" class="btn btn btn-success" value="Cadastrar" />
			</div>
		</div>
	</fieldset>
</form>