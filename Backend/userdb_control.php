//TODO: FIX ALL OF THIS FAST.

<?php
$servername = "localhost";
$username = "atanti98";
$password = "testing123";
$dbname = "PHPDashboardUsers";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
  echo "<html>Connected<br></html>";
}

function SignUp(){
  echo "<html>Loaded<br></html>";
  if(!empty($_POST['username'])){
    $sql = "SELECT * FROM `Users` WHERE `Username` = '".$_POST['username']."'";
    if (!($conn->query($sql)) {
      echo "User already exists";
    } else {
      echo "User doesn't exist";
    }
    echo "Done";
  }
}

if(isset($_POST['submit']))
{
  echo "<html>in <br></html>";
	SignUp();
}
?>

<?php
$servername = "localhost";
$username = "atanti98";
$password = "testing123";
$dbname = "PHPDashboardUsers";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function hashPassword($password){
  $hased = password_hash($password, PASSWORD_BCRYPT);
  return $hased;
}

function addUser($UserUsername, $UserPassword, $UserEmail){
  $sql = "INSERT INTO `Users` VALUES (''+$UserUsername+', '+hashPassword($UserPassword)+', '+$UserEmail+')";
  if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function SignUp(){
  if(!empty($_POST['username'])){
    $sql = "SELECT * FROM `Users` WHERE username = $_POST['username']";
    if ($conn->query($sql) === TRUE) {
      echo "User already exists";
    } else {
      addUser($_POST['username'],$_POST['password'],$_POST['email']);
    }
  }
}
function SignUp(){
  echo "Loaded Method";
}

if(isset($_POST['submit']))
{
	SignUp();
  print "In";
}
?>
