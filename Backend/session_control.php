<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "../Logs/error.log");

session_start();
if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === true){
  if(isset($_POST['func'])){
    if($_POST['func'] = "log-out"){
      error_log(session_id()." --- Session Ended");
      StopSession();
    }
  }
}

function LoginSession($userID){
  setSessionID($userID);
  error_log(session_id()." --- Session Started");
}

function setSessionID($userID){
  if(!isset($_SESSION['logged-in'])){
    if(!empty(session_id())){
      StopSession();
    }
    session_id(uniqid(session_id(),false));
    session_start();
    $_SESSION['logged-in'] = true;
    $_SESSION['_uid'] = $userID;
  }
}
function StopSession(){
  session_unset();
  $_SESSION = Array();
  session_destroy();
}
?>
