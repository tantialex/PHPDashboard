<div id="Nav_bar">
  <div class="container">
    <?php
    new NavItem("Home","Images/NavBar/icon_home.png",array(
      new NavChild("Home Page","#2"),
    ));
    new NavItem("Location","Images/NavBar/icon_location.png",array(
      new NavChild("LocationChild","#2"),
      new NavChild("LocationChild","#3"),
      new NavChild("LocationChild","#4")
    ));
    new NavItem("Battery","Images/NavBar/icon_battery.png",array(
      new NavChild("BatteryChild","#1")
    ));
    new NavItem("Test",null,array(
      new NavChild("BatteryChild","#1")
    ));
    new NavItem("Test2",null,array(
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1")
    ));
    new NavItem("Test3",null,array(
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1")
    ));
    new NavItem("Test4",null,array(
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1"),
      new NavChild("BatteryChild","#1")
    ));
     ?>
  </div>
</div>
<script src="Resources/nav_bar_control.js"></script>
<?php
class NavItem{
  function __construct($text,$imagePath,$childrenArray){
    if($imagePath == null)$imagePath = "Images/NavBar/icon_missing.png";
    $html = "".
    "<div class='navItem' name='".$text."'>".
    "<div class='left_panel'>".
    "<img class='wrapper' src='".$imagePath."'/>".
    "</div>".
    "<div class='middle_panel'>".
    "<p class='wrapper'>".$text."</p>".
    "</div>";
    if($childrenArray != null){
      $html = $html.
        "<div class='right_panel'>".
        "<img class='pointer wrapper' src='Images/NavBar/pointer.png'/>".
        "</div>";
    }
    $html = $html.
    "</div>";
    if($childrenArray != null){
      $html = $html.
      "<div class='children".$text." navItemDropdown'>";
      $currentNumChild = 0;
      foreach($childrenArray as $child){
        if(count($childrenArray) == 1){
          $child->imagePath = "Images/NavBar/only_joint.png";
        }
        else if($currentNumChild == 0){
          $child->imagePath = "Images/NavBar/first_joint.png";
        }
        else if($currentNumChild == (count($childrenArray)-1)){
          $child->imagePath = "Images/NavBar/last_joint.png";
        }

        $html = $html.
        "<a href='".$child->action."'>".
        "<div class='navItemChild'>".
        "<div class='left_panel'>".
        "<img class='wrapper' src='".$child->imagePath."'/>".
        "</div>".
        "<div class='middle_panel'>".
        "<p class='wrapper'>".$child->text."</p>".
        "</div>".
        "</div>".
        "</a>";
        $currentNumChild++;
      }
      $html = $html.
      "</div>";
    }
    echo $html;
  }
}
class NavChild{
  public $text = null;
  public $action = null;
  public $imagePath = "Images/NavBar/middle_joint.png";
  function __construct($text,$action){
    $this->text = $text;
    $this->action = $action;
  }
}
?>
