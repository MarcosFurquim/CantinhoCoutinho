<form class="form-horizontal" name="frm_cadastra_usuario" role="form" method="post" action="./control/controlFornecedor.php">
	<legend>Cadastro Fornecedor</legend>
	<fieldset>
		<div class="form-group">
			<label for="nome_pro" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nome_pro" id="nome_pro" placeholder="Nome" />
			</div>
		</div>
		<div class="form-group">
			<label for="desc_prod" class="col-sm-2 control-label">Descrição</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="desc_prod" id="desc_prod" placeholder="Descrição do Fornecedor" />
			</div>
		</div>
		<hr/>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" name="btn_cadastrar" class="btn btn btn-success" value="Cadastrar" />
			</div>
		</div>
	</fieldset>
</form>