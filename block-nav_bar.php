<div id="Nav_bar">
  <div class="container">
    <?php
    new NavItem("Location","testMe","URLTEST","Children");
    new NavItem("Battery","testMe2","URLTEST2",null);
      class NavItem{
        function __construct($text,$action,$imagePath,$childrenArray){
          $html = "".
          "<a href='".$action."'>".
          "<div class='navItem'>".
          "<div class='left_panel'>".
          "<img class='wrapper' src='".$imagePath."'/>".
          "</div>".
          "<div class='middle_panel'>".
          "<p class='wrapper'>".$text."</p>".
          "</div>";
          if($childrenArray != null){
            $html = $html.
              "<div class='right_panel'>".
              "<img class='pointer wrapper' src='navItem_pointer.png'/>".
              "</div>";
          }
          $html = $html.
          "</div>".
          "</a>";
          if($childrenArray != null){

          }
          error_log($html);
          echo $html;
        }

      }
     ?>
  </div>
</div>
