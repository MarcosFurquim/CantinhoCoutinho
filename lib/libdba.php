<?php
require_once ('medoo.php');

function conectaCantina() {
	$conexaoCantina = new medoo([
	'database_type' => 'mysql',
	'database_name' => 'energym_cantinho',
	'server' => 'localhost',
	'username' => 'energym_cantinho',
	'password' => 'mff72985141',
	'charset' => 'utf8'
	]);
	return $conexaoCantina;
}

function ConverteDataBD($data) {
	//2014-12-19 03:23:55
	$dataE = explode(" ",$data);
	
	return $dataE[1]." ".explode("-",$dataE[0])[2]."/".explode("-",$dataE[0])[1]."/".explode("-",$dataE[0])[0];
}

function inverteDataBD($data) {
	//DD/MM/YYYY PARA YYYY-MM-DD e YYYY-MM-DD para DD/MM/YYYY
	if(strpos($data,"/")!==false) {
		$dataE = explode("/",$data);
		return $dataE[2]."-".$dataE[1]."-".$dataE[0];
	} else {
		$dataE = explode("-",$data);
		return $dataE[2]."/".$dataE[1]."/".$dataE[0];
	}
}

?>