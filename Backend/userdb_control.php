<?php
ini_set('display_errors', 1);
$result = null;
$userControl = new Database_Users_Control;
if(isset($_POST['func'])){
  if($_POST['func'] == "Register"){
    $result = $userControl->SignUp();
  }
  else if($_POST['func'] == "Login"){
    $result = $userControl->Login($_POST['username'],$_POST['password']);
  }
}
echo $result;

class Database_Users_Control{
  private $conn = null;

  private function connect(){
    if (!defined('PDO::ATTR_DRIVER_NAME'))
      error_log( 'PDO driver unavailable');
    try{
      $this->conn = new PDO('mysql:host=n1plcpnl0058.prod.ams1.secureserver.net; dbname=PHPDashboard', 'atanti98', 'testing123');
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
      error_log( "Connection failed:".$e->getMessage()."");
    }
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
    else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['username'])){
      return "Username contains special characters";
    }
    else if(empty($_POST['email'])){
      return "Email is missing";
    }
    else if(empty($_POST['password'])){
      return "Password is missing";
    }
    else if($_POST['password'] != $_POST['passwordConfirm']){
      return "Passwords do not match";
    }
    else if($this->checkFor("Username",$_POST['username'])){
      return "Username already exists";
    }
    else if($this->checkFor("Email",$_POST['email'])){
      return "Email already exists";
    }
    else{
      $this->addUser();
      return "Sign Up Successful";
    }
    $this->conn = null;
  }

  public function Login($username, $password){
    $this->connect();
    if(preg_match('/@/', $username) && !($this->checkFor("Email",$username))){
        return "Invalid Email";
    }
    else if(!(preg_match('/@/', $username)) && !($this->checkFor("Username",$username))){
      return "Invalid Username";
    }
    else if(!($this->validateLogin($username, $password))){
      return "Invalid Password";
    }
    else {
      return "Login Successful";
    }
    $this->conn = null;
  }

  private function addUser(){
    $aUsername = $_POST['username'];
    $aPassword = $this->hashPassword($_POST['password']);
    $aEmail = $_POST['email'];

    $sql = "INSERT INTO Users(Username, Password, Email) VALUES (:username,:password,:email)";
    $result = $this->conn->prepare($sql);
    $result->bindParam(":username", $aUsername, PDO::PARAM_STR);
    $result->bindParam(":password", $aPassword, PDO::PARAM_STR);
    $result->bindParam(":email", $aEmail, PDO::PARAM_STR);
    $result->execute();
  }

  private function checkFor($column,$value){
    $flag = false;
    $sql = "SELECT COUNT(*) FROM Users WHERE ".$column." = :value";
    $result = $this->conn->prepare($sql);
    $result->bindParam(":value", $value, PDO::PARAM_STR);
    $result->execute();
    if($result) {
      $num = $result->fetchColumn();
      if($num != 0) $flag = true;
    } else {
      error_log( "Failed SQL check for ".$column." = '".$value."'" );
    }
    return $flag;
  }
  private function validateLogin($username, $password){
    $flag = null;
    $queryPassword = null;
    $type = "Username";
    if(preg_match('/@/', $username)){
      $type = "Email";
    }
    $sql = "SELECT * FROM Users WHERE ".$type." = :username";
    $result = $this->conn->prepare($sql);
    $result->bindParam(":username", $username, PDO::PARAM_STR);
    $result->execute();
    $results = $result->fetch(PDO::FETCH_ASSOC);
    if($result || ($results['Password'] != null)){
      $flag = password_verify($password,$results['Password']);
    }
    return $flag;
  }
}
?>
