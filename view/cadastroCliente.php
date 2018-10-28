<form class="form-horizontal" name="frm_cadastra_usuario" role="form" method="post" action="./control/controlCliente.php">
	<legend>Cadastro Cliente</legend>
	<fieldset>
		<div class="form-group">
			<label for="nome_cli" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nome_cli" id="nome_cli" placeholder="Nome" />
			</div>
		</div>
		<div class="form-group">
			<label for="email_cli" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-8">
			  <input type="email" class="form-control" name="email_cli" id="email_cli" placeholder="Email" />
			</div>
		</div>
		<div class="form-group">
			<label for="tel_cli" class="col-sm-2 control-label">Telefone/Celular</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="tel_cli" id="tel_cli" placeholder="Telefone" />
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