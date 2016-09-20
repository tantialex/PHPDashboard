<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "../Logs/error.log");#

require("db_control.php");
class User_Database_Control extends Database_Control{
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
    else if($this->checkExists("UserInfo","Username",$_POST['username'])){
      return "Username already exists";
    }
    else if($this->checkExists("UserInfo","Email",$_POST['email'])){
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
    if(preg_match('/@/', $username) && !($this->checkExists("UserInfo","Email",$username))){
        return "Invalid Email";
    }
    else if(!(preg_match('/@/', $username)) && !($this->checkExists("UserInfo","Username",$username))){
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
      $userID = $this->getField("UserInfo","Email",$username,"ID");
    }
    else{
      $userID = $this->getField("UserInfo","Username",$username,"ID");
    }
    LoginSession($userID);
  }

  private function checkMobile($mid,$username){
    if($mid != null){
      if($this->checkExists("UserMobile","MobileId",$mid)){

      }else{
        $uid = $this->getField("UserInfo","Username",$username,"ID");
        //UserMobile
        $this->insertRecord("UserMobile",["UserId","MobileId"],[$uid,$mid]);
      }
    }
  }
  private function addUser(){
    $aUsername = $_POST['username'];
    $aPassword = $this->hashPassword($_POST['password']);
    $aEmail = $_POST['email'];
    //UserInfo
    $this->insertRecord("UserInfo",["Username","Password","Email"],[$aUsername,$aPassword,$aEmail]);
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
      $queryPassword = $this->getField("UserInfo","Email",$username,"Password");
    }
    else{
      $queryPassword = $this->getField("UserInfo","Username",$username,"Password");
    }
    if($queryPassword != null){
      return password_verify($password,$queryPassword);
    }
    return false;
  }
}

if(isset($_POST['func'])){
  $result = null;
  $userControl = new User_Database_Control;
  if($_POST['func'] == "Register"){
    $result = $userControl->SignUp();
  }
  else if($_POST['func'] == "Login"){
    $result = $userControl->Login($_POST['username'],$_POST['password']);
  }else{
    $result = "Invalid Function";
  }
  echo $result;
}else{
  echo("Access Denied");
}

?>
