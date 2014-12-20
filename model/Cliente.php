<?php

class Cliente {
	var $nome;
	var $email;
	var $fone;
	//public function __construct()  
	public function Cliente($nome, $email, $fone) {
		$this->nome = $nome;
		$this->email = $email;
		$this->fone = $fone;
	}
	
	public function cadastaCliente() {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_user_id = $conexaoCantina->insert("cliente", [
		"nome" => $this->nome,
		"email" => $this->email,
		"tel" => $this->fone
		]);
		return $last_user_id;
	}
	
	public static function getCliente($idCliente) {
		$conexaoCantina = conectaCantina();
		$cliente = $conexaoCantina->get("cliente", "*",["id" => $idCliente]);
		return $cliente;
	}
	
	public static function getClientes() {
		//require_once ('./lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$query = "select id, nome,email,tel,
					coalesce(credito, 0) credito, 
					coalesce(debito, 0) debito,
					(coalesce(credito, 0))-(coalesce(debito, 0)) saldo

					from (

					(select c.id,c.nome,c.email,c.tel, sum(valor) as credito
					from cliente_credito cc
					right join cliente c on(c.id=cc.id_cliente)
					and tipo='C' group by id) as credito
					left join
					(select c.id as id_, sum(valor) as debito
					from cliente_credito cc
					right join cliente c on(c.id=cc.id_cliente)
					and tipo='D' group by id_) as debito
					on(credito.id=debito.id_)

					)  

				";
		$clientes = $conexaoCantina->query($query)->fetchAll();
		return $clientes;
	}
	
	public static function creditaCliente($idCliente,$valor,$tipo) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_credito_id = $conexaoCantina->insert("cliente_credito", [
		"id_cliente" => $idCliente,
		"valor" => $valor,
		"tipo" => $tipo
		]);
		return $last_credito_id;
		
	}
	
	public function atualizaCliente($idCliente) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->update("cliente", [
		"nome" => $this->nome,
		"email" => $this->email,
		"tel" => $this->fone
		],["id" =>$idCliente]);
		return $rows_affected;
	}
	
	public static function excluiCliente($idCliente) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$conexaoCantina->delete("cliente_credito", ["id_cliente" =>$idCliente]);
		$rows_affected = $conexaoCantina->delete("cliente", ["id" =>$idCliente]);
		return $rows_affected;
	}
}
?>