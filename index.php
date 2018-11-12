<?php
$path = '.';
define('PATH',$path);
$GLOBALS['PATH'] = $path;
require_once (PATH.'/lib/libdba.php');
define("VERSAO","4.2");
session_start();


$page = isset($_GET['page']) ? addslashes(trim($_GET['page'])) : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	require_once ($GLOBALS['PATH'].'/model/Usuario.php');
	$usuario = Usuario::logar($_POST['usuario'],sha1($_POST['senha']));
	if($usuario) {
			$_SESSION["logado"] = true;
			header ('Location: ?page=venda');
	} else {
			session_destroy();
	}
}
if ($page != 'login' && !$_SESSION["logado"]) {
	header ("location: ?page=login");
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="./img/favicon.png" />
		<title>Cantinho do Coutinho</title>
		<script src="./js/jquery-1.11.1.min.js"></script>
		<script src="./js/bootstrap-3.3.1-dist/dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="./js/bootstrap-3.3.1-dist/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="./js/bootstrap-3.3.1-dist/dist/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="./css/cantina.css">
		<script src="./js/bootstrap-validator/js/bootstrapValidator.min.js"></script>
		<script src="./js/bootstrap-validator/js/language/pt_BR.js"></script>
		<script src="./js/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>
		<link rel="stylesheet" href="./js/bootstrap-validator/css/bootstrapValidator.min.css">
		<!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">-->
		<script src="./js/numeral/min/numeral.min.js"></script>
		<script src="./js/numeral/min/languages.min.js"></script>
		<script src="./js/numeral/min/languages/pt-br.min.js"></script>
		<script src="./js/funcoes.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top trasparente">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#div-navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#"><img alt="Brand" src="./img/brand.png"></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="div-navbar">
			  <ul class="nav navbar-nav">
				  <li role="presentation"><a href="?page=venda">Venda</a></li>
				  <li role="presentation"><a href="?page=entrada">Despesa</a></li>
				  <li role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					  Cadastros <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li role="presentation"><a href="?page=fornecedor">Fornecedores</a></li>
						<li role="presentation"><a href="?page=cliente">Clientes</a></li>
						<li role="presentation"><a href="?page=produto">Produtos</a></li>
					</ul>
				  </li>
				  <li role="presentation"><a href="?page=relatorio">Relatórios</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container trasparente">	
			<div class="container-contents">
			<?php
				// Aqui ele vai verificar se existe um parâmetro para $_GET na URL.
				$page = isset($_GET['page']) ? addslashes(trim($_GET['page'])) : false;

				// Se tiver parâmetro, então...
				if( $page != false ) {
					//... inclui o nome do parâmetro vindo do $_GET.
					include( "./view/$page.php" );
				// Ou então...
				} else { 
					// Redireciona para uma página de erro
					//header( "Location: 404.php" );
				} ?>
			</div>
		</div>
		<div id="footer">
			<p style="font-size: 11px">Sistema Desenvolvido por Marcos Furquim - Versão <?=VERSAO?><br>
						Email:<a href="mailto:markinfurkin@gmail.com?Subject=Sistema%20Cantina" target="_top">markinfurkin@gmail.com</a>
			</p>	
		</div>
	</body>
</html>