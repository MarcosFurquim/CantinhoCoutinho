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
		//simular sobrecarga de metodo
		//arg[0]= filtro por nome 
		//arg[1]= index paginacao
		$conexaoCantina = conectaCantina();
		$numArgs = (int)func_num_args();
		$args = func_get_args();
		 if($numArgs == 2){
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
						where nome like '%$args[0]%' order by nome limit $args[1],10
					";
		 } else if($numArgs == 1){
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
						where nome like '%$args[0]%' order by nome
					";
		 } else {
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
						order by nome
					";
		 }
		$clientes = $conexaoCantina->query($query)->fetchAll();
		return $clientes;
	}
	
	public static function creditaCliente($idCliente,$valor,$tipo) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_credito_id = 0;
		if(@$_POST['data']=='S' || !@$_POST['data']) {
			$last_credito_id = $conexaoCantina->insert("cliente_credito", [
			"id_cliente" => $idCliente,
			"valor" => $valor,
			"tipo" => $tipo,
			"#data" =>  'NOW()'
			]);
		} else if(@$_POST['data']=='N') {
			$last_credito_id = $conexaoCantina->insert("cliente_credito", [
			"id_cliente" => $idCliente,
			"valor" => $valor,
			"tipo" => $tipo,
			"data" => inverteDataBD($_POST['campoData'])
			]);
		}
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
	
	public static function getHistoricoCliente($idCliente) {
		//simular sobrecarga de metodo
		//arg[1]= index paginacao
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		$conexaoCantina = conectaCantina();
		if($numArgs == 2){
			$cliente_hist = $conexaoCantina->select("cliente_credito", "*",["id_cliente" => $idCliente,"ORDER" => "data DESC", "LIMIT" => [$args[1], 10]]);
		}else if($numArgs == 1) {
			$cliente_hist = $conexaoCantina->select("cliente_credito", "*",["id_cliente" => $idCliente,"ORDER" => "data DESC"]);
		}
		return $cliente_hist;
	}
	
	public static function getHistoricoClienteCount() {
		//simular sobrecarga de metodo
		//arg[0]= idCliente
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		$conexaoCantina = conectaCantina();
		if($numArgs == 1){
			$count = $conexaoCantina->count("cliente_credito",["id_cliente" =>$args[0]]);
		}else if($numArgs == 0) {
			$count = $conexaoCantina->count("cliente_credito");
		}
		return $count;
	}
	
	public static function getCount() {
		$conexaoCantina = conectaCantina();
		$count = $conexaoCantina->count("cliente");
		return $count;
	}
}
?>