<?php

class Produto {
	var $nome;
	var $preco;
	var $descricao;
	//public function __construct()  
	public function Produto($nome, $preco, $descricao) {
		$this->nome = $nome;
		$this->preco = $preco;
		$this->descricao = $descricao;
	}
	
	public function cadastraProduto() {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_user_id = $conexaoCantina->insert("produto", [
		"nome" => $this->nome,
		"preco" => $this->preco,
		"descricao" => $this->descricao
		]);
		return $last_user_id;
	}
	
	public static function getProduto($idProduto) {
		$conexaoCantina = conectaCantina();
		$produto = $conexaoCantina->get("produto", "*",["id" => $idProduto]);
		return $produto;
	}
	
	
	public static function getProdutos() {
		//simular sobrecarga de metodo
		//arg[0]= filtro por nome 
		//arg[1]= index paginacao
		$conexaoCantina = conectaCantina();
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		 if($numArgs == 2){
			$produto = $conexaoCantina->select("produto", "*",["nome[~]" =>"%".$args[0]."%", "LIMIT" => [$args[1], 10],"ORDER" => "nome"]);
		} else if($numArgs == 1){
			$produto = $conexaoCantina->select("produto", "*",["nome[~]" =>"%".$args[0]."%","ORDER" => "nome"]);
		} else {
			$produto = $conexaoCantina->select("produto", "*",["ORDER" => "nome"]);
		}
		//var_dump($conexaoCantina->log());
		return $produto;
	}
	
	public function atualizaProduto($idProduto) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->update("produto", [
		"nome" => $this->nome,
		"preco" => $this->preco,
		"descricao" => $this->descricao
		],["id" =>$idProduto]);
		return $rows_affected;
	}
	
	public static function excluiProduto($idProduto) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->delete("produto", ["id" =>$idProduto]);
		return $rows_affected;
	}
	
	public static function getPreco($idProduto) {
		$conexaoCantina = conectaCantina();
		$preco = $conexaoCantina->get("produto", "preco",[
		"id" =>$idProduto]);
		return $preco;
	}
	
	public static function getCount() {
		$conexaoCantina = conectaCantina();
		$count = $conexaoCantina->count("produto");
		return $count;
	}
	public static function getProdutoRelatorio($dti,$dtf,$id_produto) {
		$conexaoCantina = conectaCantina();
		$query = "select  v.data,vp.*,p.id as produto_id,p.nome as produto_nome,
				if(v.cliente_id<>0,c.nome, cliente_nome) as cliente_nome
				from venda v
				left join cliente c on(v.cliente_id=c.id)
				inner join venda_produto vp on(v.id=vp.id_venda)
				inner join produto p on(vp.produto_id=p.id)
				where date(v.data) >= '$dti' and date(v.data) <= '$dtf' 
				and vp.produto_id = $id_produto
				order by v.data desc";
		$rel_produtos = $conexaoCantina->query($query)->fetchAll();
		return $rel_produtos;
	}
	
	public static function getProdutoRelatorioMaisVendidos($dti,$dtf) {
		$conexaoCantina = conectaCantina();
		$query = "select sum(vp.produto_qnt) as total_qnt,p.id as produto_id,p.nome as produto
				from venda v
				inner join venda_produto vp on(v.id=vp.id_venda)
				inner join produto p on(vp.produto_id=p.id)
				where date(v.data) >= '$dti' and date(v.data) <= '$dtf' 
				group by produto_id
				order by total_qnt desc";
		$rel_produtos = $conexaoCantina->query($query)->fetchAll();
		return $rel_produtos;
	}
}
?>