<?php

class Caixa {

		//public function __construct()  
	public function Caixa() {
	
	}
	
	public static function getCaixaCompleto() {
		$conexaoCantina = conectaCantina();
		$queryEntrada="select sum(e.valor)*-1 as valor,date(e.data) AS dataf
				from entrada e
				group by dataf
				order by dataf desc";
		$entrada = $conexaoCantina->query($queryEntrada)->fetchAll();
		$queryVenda="select sum(v.valor) as valor,date(v.data) AS dataf
					from venda v 
					group by dataf
					order by dataf desc";
		$venda = $conexaoCantina->query($queryVenda)->fetchAll();
		foreach ($entrada as  $v) {
			foreach ($v as $key => $value) {
				echo "Key: $key; Value:$value<br />\n";
			}
		}
		//var_dump($entrada);
		//var_dump($venda);
	
	}
	public static function getCaixa() {
		//simular sobrecarga de metodo
		//arg[0]= data inicio
		//arg[1]= data fim
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		$conexaoCantina = conectaCantina();
		if($numArgs == 2){
			$query = "select SUM(valor) as valor, dataf from(
						(select sum(e.valor)*-1 as valor,date(e.data) AS dataf
									from entrada e
									where date(data) >= '$args[0]' and date(data) <= '$args[1]'
									group by dataf)
						 UNION   
						(select sum(v.valor) as valor,date(v.data) AS dataf
									from venda v 
									where date(data) >= '$args[0]' and date(data) <= '$args[1]'
									 group by dataf)) t
						group by dataf
						order by dataf desc";
		} else {
			$query = "select SUM(valor) as valor, dataf from(
						(select sum(e.valor)*-1 as valor,date(e.data) AS dataf
									from entrada e
								
									group by dataf)
						 UNION   
						(select sum(v.valor) as valor,date(v.data) AS dataf
									from venda v 
								
									 group by dataf)) t
						group by dataf
						order by dataf desc";
		}
		//echo $query;
		$caixa = $conexaoCantina->query($query)->fetchAll();
		return $caixa;
	}
	public static function getCaixaReal() {
		//simular sobrecarga de metodo
		//arg[0]= data inicio
		//arg[1]= data fim
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		$conexaoCantina = conectaCantina();
		if($numArgs == 2){
			$query = "select  t.data,t.data_completo,t.valor,t.cliente,t.tipo from(
        /* Cliente sem cadastro venda Paga */
						(select v.valor,date(v.data) AS data, v.data as data_completo, concat('Venda Paga Cliente Sem Cadastro') as tipo,
					  concat((select vv.cliente_nome from venda vv where vv.id=v.id)) as cliente
                  from venda v
                 where date(data) >= '$args[0]' and date(data) <=  '$args[1]'
								and v.cliente_id=0
                and v.pago='S'                     
								 /*group by data*/)
              UNION
               /* Cliente com cadastro venda Paga */
              	(select v.valor,date(v.data) AS data, v.data as data_completo, concat('Venda Paga Cliente Com Cadastro') as tipo,
					  concat((select c.nome from cliente c where id=v.cliente_id)) as cliente
                  from venda v
                 where date(data) >= '$args[0]' and date(data) <=  '$args[1]'
								and v.cliente_id<>0
                and v.pago='S'                    
								 /*group by data*/)
						UNION
						 /* Cliente Crédito */		
						(select cc.valor, date(cc.data) as data, cc.data as data_completo, concat('Crédito Cliente') as tipo,
            concat((select c.nome from cliente c where id=cc.id_cliente)) as cliente              
							   from cliente_credito cc
                  where date(data) >= '$args[0]' and date(data) <=  '$args[1]'
							   and cc.tipo='C'
                 and cc.id_venda=0                       
							   /*group by data*/)) t
					/*	group by data*/
						order by data_completo desc";
		} else {
			$query = "select  t.data,t.data_completo,t.valor from(

						(select v.valor,date(v.data) AS data, v.data as data_completo
									from venda v
								where v.cliente_id=0
								 /*group by data*/)

						UNION
								
						(select cc.valor, date(cc.data) as data, cc.data as data_completo
							   from cliente_credito cc
							   where cc.tipo='C'
							   /*group by data*/)) t
					/*	group by data*/
						order by data_completo desc";
		}
		//echo "<pre>".$query."</pre>";
		$caixa = $conexaoCantina->query($query)->fetchAll();
		return $caixa;
	}
	public static function getCaixaRealAgrupado() {
		//simular sobrecarga de metodo
		//arg[0]= data inicio
		//arg[1]= data fim
		$numArgs = (int)func_num_args();
        $args = func_get_args();
		$conexaoCantina = conectaCantina();
		if($numArgs == 2){
			$query = "select  t.data,sum(t.valor) as valor from(

						(select sum(v.valor) as valor,date(v.data) AS data, v.data as data_completo
									from venda v 
									where date(data) >= '$args[0]' and date(data) <=  '$args[1]'
									and v.cliente_id=0
								 group by data)

						UNION
								
						(select sum(cc.valor) as valor, date(cc.data) as data, cc.data as data_completo
							   from cliente_credito cc
							   where date(data) >= '$args[0]' and date(data) <=  '$args[1]'
							   and cc.tipo='C'
							   group by data)) t
						group by data
						order by data desc";
		} else {
			$query = "select  t.data,sum(t.valor) as valor from(

						(select sum(v.valor) as valor,date(v.data) AS data, v.data as data_completo
									from venda v 
									where v.cliente_id=0
								 group by data)

						UNION
								
						(select sum(cc.valor) as valor, date(cc.data) as data, cc.data as data_completo
							   from cliente_credito cc
							   where cc.tipo='C'
							   group by data)) t
						group by data
						order by data desc";
		}
		//echo $query;
		$caixa = $conexaoCantina->query($query)->fetchAll();
		return $caixa;
	}
}
?>