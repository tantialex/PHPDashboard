<?php
if(empty($_SESSION['_uid'])){
  session_start();
}
?>
<div id="Frame">
 <div class="left_panel">
   <div class="absolute_wrapper">
     <div id="Logo_container">
       <?php include 'block-logo.php'; ?>
     </div>
     <div id="Profile_container">
       <?php include 'block-profile_toast.php'; ?>
     </div>
     <?php include 'block-nav_bar.php'; ?>
     <div id="Tool_bar">
       <?php include 'block-tool_bar.php'; ?>
     </div>
   </div>
 </div>
 <div class="right_panel">
   <div id="Top_bar">
     <?php include 'block-top_bar.php'; ?>
   </div>
   <div id="Content">
   </div>
 </div>
</div>
