<?php

require_once ('./lib/libdba.php');
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cantina Tiago</title>
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
		<div class="container-narrow">
			<div>
				<ul class="nav nav-pills">
				  <li role="presentation"><a href="?page=venda">Venda</a></li>
				  <li role="presentation"><a href="?page=cliente">Clientes</a></li>
				  <li role="presentation"><a href="?page=produto">Produtos</a></li>
				  <li role="presentation"><a href="?page=relatorio">Relatórios</a></li>
				</ul>
			</div>
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
			<p style="font-size: 11px">Sistema Desenvolvido por Marcos Furquim<br>
						Email:<a href="mailto:markinfurkin@gmail.com?Subject=Sistema%20Cantina" target="_top">markinfurkin@gmail.com</a>
			</p>	
		</div>
	</body>
</html>