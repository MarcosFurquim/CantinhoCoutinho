<?php
require_once ('medoo.min.php');

function conectaCantina() {
	$conexaoCantina = new medoo([
	'database_type' => 'mysql',
	'database_name' => 'cantina',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	]);
	return $conexaoCantina;
}

function ConverteDataBD($data) {
	//2014-12-19 03:23:55
	$dataE = explode(" ",$data);
	
	return $dataE[1]." ".explode("-",$dataE[0])[2]."/".explode("-",$dataE[0])[1]."/".explode("-",$dataE[0])[0];
}

?>