<?php

class Fornecedor {
	var $nome;
	var $descricao;
	//public function __construct()  
	public function Fornecedor($nome, $descricao) {
		$this->nome = $nome;
		$this->descricao = $descricao;
	}
	
	public function cadastraFornecedor() {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_forn_id = $conexaoCantina->insert("fornecedor", [
		"nome" => $this->nome,
		"descricao" => $this->descricao
		]);
		return $last_forn_id;
	}
	
	public static function getFornecedor($idFornecedor) {
		$conexaoCantina = conectaCantina();
		$fornecedor = $conexaoCantina->get("fornecedor", "*",["id" => $idFornecedor]);
		return $fornecedor;
	}
	
	
	public static function getFornecedores() {
		//simular sobrecarga de metodo
		//arg[0]= filtro por nome 
		//arg[1]= index paginacao
		$conexaoCantina = conectaCantina();
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		 if($numArgs == 2){
			$fornecedor = $conexaoCantina->select("fornecedor", "*",["nome[~]" =>"%".$args[0]."%", "LIMIT" => [$args[1], 10],"ORDER" => "nome"]);
		} else if($numArgs == 1){
			$fornecedor = $conexaoCantina->select("fornecedor", "*",["nome[~]" =>"%".$args[0]."%","ORDER" => "nome"]);
		} else {
			$fornecedor = $conexaoCantina->select("fornecedor", "*",["ORDER" => "nome"]);
		}
		//var_dump($conexaoCantina->log());
		return $fornecedor;
	}
	
	public function atualizaFornecedor($idFornecedor) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->update("fornecedor", [
		"nome" => $this->nome,
		"descricao" => $this->descricao
		],["id" =>$idFornecedor]);
		return $rows_affected;
	}
	
	public static function excluiFornecedor($idFornecedor) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->delete("fornecedor", ["id" =>$idFornecedor]);
		return $rows_affected;
	}
	
	
	public static function getCount() {
		$conexaoCantina = conectaCantina();
		$count = $conexaoCantina->count("fornecedor");
		return $count;
	}

}
?>