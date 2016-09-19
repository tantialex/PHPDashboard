<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "../Logs/error.log");#
if(isset($_POST['func'])){
  $result = null;
  $userControl = new Database_Users_Control;
  if($_POST['func'] == "Register"){
    $result = $userControl->SignUp();
  }
  else if($_POST['func'] == "Login"){
    $result = $userControl->Login($_POST['username'],$_POST['password']);
  }
  echo $result;
}


class Database_Users_Control{
  private $conn = null;

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
  private function hashPassword($password){
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    return $hashed;
  }
  public function SignUp(){
    $flag = false;
    $this->connect();
    if(empty($_POST['username'])){
      return "Username is missing";
    }
    else if(!($this->checkLength($_POST['username'],6,20))){
      return "Username must be between 6 to 20 characters";
    }
    else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['username'])){
      return "Username contains special characters";
    }
    else if(empty($_POST['email'])){
      return "Email is missing";
    }
    else if(!preg_match('/@/', $_POST['email']) && !preg_match('/./', $_POST['email'])){
      return "Invalid Email";
    }
    else if(!($this->checkLength($_POST['email'],6,40))){
      return "Email must be between 6 to 40 characters";
    }
    else if(empty($_POST['password'])){
      return "Password is missing";
    }
    else if(!($this->checkLength($_POST['password'],6,20))){
      return "Password must be between 6 to 20 characters";
    }
    else if($_POST['password'] != $_POST['passwordConfirm']){
      return "Passwords do not match";
    }
    else if($this->checkFor("UserInfo","Username",$_POST['username'])){
      return "Username already exists";
    }
    else if($this->checkFor("UserInfo","Email",$_POST['email'])){
      return "Email already exists";
    }
    else{
      $this->addUser();
      return "Sign Up Successful";
    }
    $this->disconnect();
  }

  public function Login($username, $password){
    $this->connect();
    if(preg_match('/@/', $username) && !($this->checkFor("UserInfo","Email",$username))){
        return "Invalid Email";
    }
    else if(!(preg_match('/@/', $username)) && !($this->checkFor("UserInfo","Username",$username))){
      return "Invalid Username";
    }
    else if(!($this->validateLogin($username, $password))){
      return "Invalid Password";
    }
    else {
      if(!empty($_POST['mobileID']))
        $this->checkMobile($_POST['mobileID'],$username);
      $this->startUserSession($username);
      return "Login Successful";
    }
    $this->disconnect();
  }
  private function startUserSession($username){
    include_once("session_control.php");
    $userID = null;
    if(preg_match('/@/', $username)){
      $userID = $this->getUserField("UserInfo","Email",$username,"ID");
    }
    else{
      $userID = $this->getUserField("UserInfo","Username",$username,"ID");
    }
    LoginSession($userID);
  }
  private function checkMobile($mid,$username){
    if($mid != null){
      if($this->checkFor("UserMobile","MobileId",$mid)){

      }else{
        $uid = $this->getUserField("UserInfo","Username",$username,"ID");
        $sql = "INSERT INTO UserMobile(UserId,MobileId) VALUES (:userid,:mobileid)";
        $result = $this->conn->prepare($sql);
        $result->bindParam(":userid", $uid, PDO::PARAM_STR);
        $result->bindParam(":mobileid", $mid, PDO::PARAM_STR);
        $result->execute();
      }
    }
  }
  private function addUser(){
    $aUsername = $_POST['username'];
    $aPassword = $this->hashPassword($_POST['password']);
    $aEmail = $_POST['email'];

    $sql = "INSERT INTO UserInfo(Username, Password, Email) VALUES (:username,:password,:email)";
    $result = $this->conn->prepare($sql);
    $result->bindParam(":username", $aUsername, PDO::PARAM_STR);
    $result->bindParam(":password", $aPassword, PDO::PARAM_STR);
    $result->bindParam(":email", $aEmail, PDO::PARAM_STR);
    $result->execute();
  }
  public function getUserField($table,$column,$value,$field){
    $fieldValue = null;
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
  private function checkFor($table,$column,$value){
    $result = $this->getUserField($table,$column,$value,"ID");
    if($result != null){
      return true;
    }
    return false;
  }
  private function checkLength($value,$minlength,$maxlength){
    if((strlen($value) >= $minlength) && (strlen($value) <= $maxlength)){
      return true;
    }
    return false;
  }
  private function validateLogin($username, $password){
    $queryPassword = null;
    if(preg_match('/@/', $username)){
      $queryPassword = $this->getUserField("UserInfo","Email",$username,"Password");
    }
    else{
      $queryPassword = $this->getUserField("UserInfo","Username",$username,"Password");
    }
    if($queryPassword != null){
      return password_verify($password,$queryPassword);
    }
    return false;
  }
}
?>
