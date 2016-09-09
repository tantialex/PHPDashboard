<?php
include_once "Backend/userdb_control.php";
$userControl = new Database_Users_Control;
$userControl->connect();
$username = $userControl->getUserField("ID",$_SESSION['_uid'],"Username");
$imagePath = $userControl->getUserField("ID",$_SESSION['_uid'],"ImageUrl");
if($imagePath == null){
  $imagePath = "user_default.png";
}
$userControl->disconnect();
?>
<div id="Profile_Toast">
  <div class="left_panel panel">
    <div class="wrapper">
      <img src="Users/Profile Pictures/<?php echo $imagePath?>"/>
    </div>
  </div>
  <div class="middle_panel panel">
    <div class="wrapper">
      <div class="status_square"></div>
    </div>
  </div>
  <div class="right_panel panel">
      <p class="profile_name"><?php echo $username;?></p>
  </div>
</div>
