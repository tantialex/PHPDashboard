<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "../Logs/location.log");
error_reporting(E_ALL);
if(!empty($_POST['json'])){
  echo(var_dump($_POST['json']));
  error_log($_POST['json']);
}
$headers = apache_request_headers();

?>
