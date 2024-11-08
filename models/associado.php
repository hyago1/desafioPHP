<?php 
Class Associado{
 private $nome ;
 private $email;
 private $cpf;
 private $data ;
 private $anoY;
  public function __construct(){} 
}
  
 
 function  getDataAssociado($sql) {
    $query = pg_query(connection(),$sql );
    return $query;
  }
  function insertAssociado($sql) {
    $query = pg_query(connection(),$sql );
    return $query;
  }


?>