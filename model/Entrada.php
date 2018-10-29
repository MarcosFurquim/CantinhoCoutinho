<?php

class Entrada {
	var $fornecedor_id;
	var $fornecedor_nome;
	var $valor;
	
	//public function __construct()  
	public function Entrada($fornecedor_id, $fornecedor_nome, $valor) {
		$this->fornecedor_id = $fornecedor_id;
		$this->fornecedor_nome = $fornecedor_nome;
		$this->valor = $valor;
	}
	
	public function cadastraEntrada() {
		require_once (dirname(__DIR__).'/lib/libdba.php');
		$conexaoCantina = conectaCantina();
		//simular sobrecarga de metodo
		//arg[0]= last record credito_cliente
		$numArgs = (int)func_num_args();
		$args = func_get_args();
		if($_POST['data']=='S') {
			$last_entrada_id = $conexaoCantina->insert("entrada", [
			"fornecedor_id" => $this->fornecedor_id,
			"fornecedor_nome" => $this->fornecedor_nome,
			"valor" => $this->valor,
			"#data" => 'NOW()'
			]);
		} else if($_POST['data']=='N') {
			$last_entrada_id = $conexaoCantina->insert("entrada", [
			"fornecedor_id" => $this->fornecedor_id,
			"fornecedor_nome" => $this->fornecedor_nome,
			"valor" => $this->valor,
			"#data" => inverteDataBD($_POST['campoData'])
			]);
		}
		return $last_entrada_id;
	}
	
	public static function getEntradas() {
		//simular sobrecarga de metodo
		//arg[0]= data inicio
		//arg[1]= data fim
		//arg[2]= filtro por fornecedor
		//arg[3]= index paginacao
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		$conexaoCantina = conectaCantina();
		if($numArgs == 2){
			$query = "select e.* from entrada e
					 where date(data) >= '$args[0]' and date(data) <= '$args[1]'
					order by e.data desc";
		} else if($numArgs == 3){
			$query = "select e.* from entrada e
					 where date(data) >= '$args[0]' and date(data) <= '$args[1]'
					 and e.fornecedor_id=$args[2]
					order by e.data desc";
		} else if($numArgs == 4){
			$query = "select e.* from entrada e
					 where date(data) >= '$args[0]' and date(data) <= '$args[1]'
					 and e.fornecedor_id=$args[2]
					order by e.data desc
					LIMIT $args[3],10";
		} else {
			$query = "select e.* from entrada e
					order by e.data desc";
		}
		//echo $query;
		$entradas = $conexaoCantina->query($query)->fetchAll();
		return $entradas;
	}
	
	public static function getEntradasAgrupado($dataI, $dataF, $Agrupamento) {
		$conexaoCantina = conectaCantina();
		$query = "select sum(e.valor) as valor,date(e.data) AS dataf
			from entrada e
			where date(data) >= '$dataI' and date(data) <= '$dataF'
			 group by dataf
			order by e.data desc";
		//echo $query;
		$vendas = $conexaoCantina->query($query)->fetchAll();
		return $vendas;
	}
	
	public static function getCount() {
		$conexaoCantina = conectaCantina();
		$count = $conexaoCantina->count("entrada");
		return $count;
	}
}
	