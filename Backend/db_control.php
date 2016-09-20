<?php
class Database_Control{
  protected $conn = null;
  public function __construct(){

  }
  protected function connect(){
    if (!defined('PDO::ATTR_DRIVER_NAME'))
      error_log( 'PDO driver unavailable');
    try{
      $this->conn = new PDO('mysql:host=n1plcpnl0058.prod.ams1.secureserver.net; dbname=PHPDashboard', 'atanti98', 'testing123');
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
      error_log( "Connection failed:".$e->getMessage()."");
    }
  }
  protected function disconnect(){
    $this->conn = null;
  }
  protected function getField($table, $column, $value, $field){
    $sql = "SELECT * FROM ".$table." WHERE ".$column." = :value";
    $result = $this->conn->prepare($sql);
    $result->bindParam(":value", $value, PDO::PARAM_STR);
    $result->execute();
    $results = $result->fetch(PDO::FETCH_ASSOC);
    if($result){
      $fieldValue= $results[$field];
    }
    else{
      error_log("SQL_SEARCH_FAIL: SQL search for ".strtoupper($field)." using ".strtoupper($column)." = ".strtoupper($value).";");
    }
    return $fieldValue;
  }
  protected function checkExists($table, $column, $value){
    if(!empty($this->getField($table,$column,$value,$column))){
      return true;
    }
    else{
      return false;
    }
  }
  protected function insertRecord($table,$columns,$array){
    $sql = "INSERT INTO ".$table."";
    $table_columns = "(";
    $table_column_values = "(";
    for($i = 0; $i < count($columns); $i++){
      $table_columns = $table_columns.$columns[$i].",";
      $table_column_values = $table_column_values.":value".$i.",";
    }
    $table_columns = substr($table_columns,0,strlen($table_columns)-1);
    $table_column_values = substr($table_column_values,0,strlen($table_column_values)-1);
    $sql = $sql.$table_columns.") VALUES ".$table_column_values.")";
    $result = $this->conn->prepare($sql);
    for($i = 0; $i < count($array); $i++){
      $result->bindParam(":value".$i,$array[$i],PDO::PARAM_STR);
    }
    $result->execute();
  }
}
?>
