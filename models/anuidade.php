<?php
final class anuidade
{
  private $ano;
  private $valor;
  public function __construct($ano, $valor)
  {
    $this->ano = $ano;
    $this->valor = $valor;
  }

  public function getDataAnuidade($what, $equality): mixed
  {
    $sql = "select " . $what . " from anuidade where anoAnu  " . $equality . " '" . (string)$this->getAno() . "' ";
    $query = pg_query(connection(), $sql);
    return $query;
  }

  function insertAnuidade()
  {
    $sql = "insert into anuidade (anoAnu, valor) values ('" . (string)$this->getAno() . "', '" . (string)$this->getValor() . "' )";
    $query = pg_query(connection(), $sql);
    return $query;
  }

  public function getValor()
  {
    return $this->valor;
  }

  public  function getAno()
  {
    return $this->ano;
  }


}


function updateAnuidade($valor, $id)
{
  $query = pg_query(connection(), "update anuidade set valor = '$valor' where id = $id ");
  return $query;
}
function getDataAnuidade($sql): mixed
{
  $query = pg_query(connection(), $sql);
  return $query;
}
