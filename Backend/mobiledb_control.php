<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "../Logs/location.log");

if(!empty($_POST['json'])){
  error_log($_POST['json']);
}
if(!empty($_POST['json'])){
  $json = json_decode($_POST['json'],true);
  $mobileControl = new Full_Database_Control($json);
}
class Full_Database_Control{
    private $mobile_id = null;
    private $conn = null;
    public function __construct($json){
        $this->connect();
        $this->checkJson($json);
        $this->disconnect();
    }
    public function connect(){
      if (!defined('PDO::ATTR_DRIVER_NAME'))
        error_log( 'PDO driver unavailable');
      try{
        $this->conn = new PDO('mysql:host=n1plcpnl0058.prod.ams1.secureserver.net; dbname=PHPDashboard', 'atanti98', 'testing123');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e){
        error_log( "Connection failed:".$e->getMessage()."");
      }
    }
    public function disconnect(){
      $this->conn = null;
    }
    private function checkJson($json){
      if(!empty($json['mobile']['id'])){
        $this->mobile_id = $json['mobile']['id'];
        if(!empty($json['Location'])){
          $this->setLocation($json['Location']);
        }
        else if(!empty($json['Battery'])){
          $this->setBattery($json['Battery']);
        }
      }
    }
    private function setBattery($json){
      $percent = $json['percent'];
      $status = $json['status'];
      $date = $json['created'];
      $sql = "INSERT INTO MobileBattery(MobileId, Percent, Status, Date) VALUES (:mobileId,:percent,:status,:date)";
      $result = $this->conn->prepare($sql);
      $result->bindParam(":mobileId", $this->mobileId, PDO::PARAM_STR);
      $result->bindParam(":percent", $percent, PDO::PARAM_STR);
      $result->bindParam(":status", $status, PDO::PARAM_STR);
      $result->bindParam(":date", $date, PDO::PARAM_STR);
      $result->execute();
    }
    private function setLocation($json){
      $lng = $json['longitudinal'];
      $lat = $json['latitudinal'];
      $date = $json['created'];
      $locationId = "";
      $address = $this->getGeocodeLocation('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyD7Uod5YOUT3_2fSpvYexTI1hgvgBO41fs');
      if(!$this->checkExists("LocationInfo","Address",$address)){
        $sql = "INSERT INTO LocationInfo(Address, Lng, Lat) VALUES (:address,:lng,:lat)";
        $result = $this->conn->prepare($sql);
        $result->bindParam(":address", $address, PDO::PARAM_STR);
        $result->bindParam(":lng", $lng, PDO::PARAM_STR);
        $result->bindParam(":lat", $lat, PDO::PARAM_STR);
        $result->execute();
      }
      $sql = "INSERT INTO MobileLocation(MobileId, LocationId, Date) VALUES (:mobileId, :locationId, :date)";
      $result = $this->conn->prepare($sql);
      $result->bindParam(":mobileId", $this->mobileId, PDO::PARAM_STR);
      $result->bindParam(":locationId", getField("LocationInfo","Address",$address,"ID"), PDO::PARAM_STR);
      $result->bindParam(":date", $date, PDO::PARAM_STR);
      $result->execute();
    }
    private function getGeocodeLocation($url){
      $json = json_decode(file_get_contents($url),true);
      if($json['status'] == "OK"){
        return $json['results'][0]['formatted_address'];
      }
    }
    private function getField($table, $column, $value, $field){
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
    private function checkExists($table, $column, $value){
      if(!empty($this->getField($table,$column,$value,"")){
        return true;
      }
      else{
        return false;
      }
    }
}
?>
