<?php

class Venda {
	var $cliente_id;
	var $cliente_nome;
	
	//public function __construct()  
	public function Venda($cliente_id, $cliente_nome) {
		$this->cliente_id = $cliente_id;
		$this->cliente_nome = $cliente_nome;
	}
	
	public function cadastraVenda() {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_venda_id = $conexaoCantina->insert("venda", [
		"cliente_id" => $this->cliente_id,
		"cliente_nome" => $this->cliente_nome,
		"#data" => 'NOW()'
		]);
		$precototal = 0;
		require_once ('../model/Produto.php');
		foreach($_POST["qnt"] as $id => $qnt) {
			$preco = Produto::getPreco($id);
			$conexaoCantina->insert("venda_produto", [
			"id_venda" => $last_venda_id,
			"produto_id" => $id,
			"produto_qnt" => $qnt,
			"produto_preco" => $preco
			]);
			$precototal +=$preco*$qnt;
		}
		$conexaoCantina->update("venda", [
		"valor" => $precototal
		],["id" =>$last_venda_id]);
			var_dump( $conexaoCantina->log() );
		return $last_venda_id;
	}
	
	public static function getVendas() {
		$conexaoCantina = conectaCantina();
		$query = "select v.*, c.nome,
					if(v.cliente_id<>0,c.nome, cliente_nome) as cliente
					from venda v
					left join cliente c on(v.cliente_id=c.id)
					order by v.data";
		$vendas = $conexaoCantina->query($query)->fetchAll();
		return $vendas;
	}
	public static function getProdutosVenda($idVenda) {
		$conexaoCantina = conectaCantina();
		$query = "select vd.*, p.nome from venda_produto vd
				inner join produto p on (vd.produto_id=p.id)
				 where vd.id_venda=$idVenda
				";
		$produtos_venda = $conexaoCantina->query($query)->fetchAll();
		return $produtos_venda;
	}
}	