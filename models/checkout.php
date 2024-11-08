<?php




function getDataFilterCheckout($cond)
{


  $cond = $cond ? 'TRUE' : 'FALSE';

  $sql = "select nome, cpf, email, anoanu, valor, CASE WHEN pago = 't' THEN 'Sim'
       WHEN pago = 'f' THEN 'Não'
  END as pago
  from associado, anuidade, pagamento 
  where associado.id = pagamento.id_associado
  and anuidade.id = pagamento.id_anuidade
  and pago = $1
  order by nome";
  

  $query = pg_query_params(connection(), $sql, array($cond));
  return $query;
}
function getDataCheckout(){

 

  $sql = "select nome, cpf, email, anoanu, valor, CASE WHEN pago = 't' THEN 'Sim'
       WHEN pago = 'f' THEN 'Não'
  END as pago
  from associado, anuidade, pagamento 
  where associado.id = pagamento.id_associado
  and anuidade.id = pagamento.id_anuidade
  order by nome";
  

  $query = pg_query(connection(), $sql);
  return $query;
}

function insertPagamento($sql)
{
  $query = pg_query(connection(), $sql);
  return $query;
}
