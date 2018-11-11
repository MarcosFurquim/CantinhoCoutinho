<form class="form-horizontal" name="frm_cadastra_usuario" role="form" method="post" action="">
<legend>Login</legend>
<fieldset>
		<div class="form-group">
			<label for="usuario" class="col-sm-2 control-label">Usuário</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nome">
			</div>
		</div>
		<div class="form-group">
			<label for="senha" class="col-sm-2 control-label">Senha</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="senha" id="senha" placeholder="Senha">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="submit" name="btn_login" class="btn btn btn-success" value="Entrar">
			</div>
		</div>
	</fieldset>
</form>