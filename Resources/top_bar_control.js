var toggleNav = true;
$(".nav_toggle").click(function(){
  if(!$(this).hasClass("duringTransition")){
    $(this).addClass("duringTransition");
    if(toggleNav){
      $("#Frame >.left_panel").animate({
        width:"0"
      },1000,function(){
        toggleNav = false;
        $(".nav_toggle").removeClass("duringTransition");
      });
    } else if(!toggleNav){
      $("#Frame >.left_panel").animate({
        width:"275px"
      },1000,function(){
        toggleNav = true;
        $(".nav_toggle").removeClass("duringTransition");
      });
    }
  }
});
