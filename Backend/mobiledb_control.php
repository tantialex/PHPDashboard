<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "../Logs/location.log");

require("db_control.php");
class Mobile_Database_Control extends Database_Control{
    private $mobile_id = null;
    public function __construct($mid,$json){
        $this->mobile_id = $mid;
        $this->connect();
        $this->checkJson($json);
        $this->disconnect();
    }
    private function checkJson($json){
        if(!empty($json['Location'])){
          $this->setLocation($json['Location']);
        }
        if(!empty($json['Battery'])){
          $this->setBattery($json['Battery']);
        }
    }
    private function setBattery($json){
      $percent = $json['percent'];
      $status = $json['status'];
      $date = $json['created'];
      //MobileBattery
      $this->insertRecord("MobileBattery",["MobileId","Percent","Status","Date"],[$this->mobile_id,$percent,$status,$date]);
    }
    private function setLocation($json){
      $lng = $json['longitudinal'];
      $lat = $json['latitudinal'];
      $date = $json['created'];
      $locationId = "";
      $address = $this->getGeocodeLocation($lat,$lng);
      if(!$this->checkExists("LocationInfo","Address",$address)){
        //LocationInfo
        $this->insertRecord("LocationInfo",["Address","Lng","Lat"],[$address,$lng,$lat]);
      }
      $locationId = $this->getField("LocationInfo","Address",$address,"ID");
      //MobileLocation
      $this -> insertRecord("MobileLocation",["MobileId","LocationId","Date"],[$this->mobile_id,$date]);
    }
    private function getGeocodeLocation($lat,$lng){
      $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyD7Uod5YOUT3_2fSpvYexTI1hgvgBO41fs';
      $json = json_decode(file_get_contents($url),true);
      if($json['status'] == "OK"){
        return $json['results'][0]['formatted_address'];
      }
    }
}

if(!empty($_POST['mobileID'])){
  error_log($_POST['mobileID']);
  error_log($_POST['json']);
}
if(!empty($_POST['mobileID'])){
  if(!empty($_POST['json'])){
    $json = json_decode($_POST['json'],true);
    $mobileControl = new Mobile_Database_Control($_POST['mobileID'],$json);
  }
}
else{
  echo "Access Denied";
}
?>
