var previousSelected = null;
$(".navItem").on("click",function(){
  var elemName = ".children"+$(this).attr("name");
  if(!$(elemName).hasClass("duringTransition")){
    $(elemName).addClass("duringTransition");
    var deg_start = 0;
    if(!$(elemName).hasClass("Open")){
      $(elemName).css("height","auto");
      var autoHeight = $(elemName).css("height");
      $(elemName).css("height","0");
      $(elemName).css("display","block");
      $(elemName).animate({
        height:autoHeight
      },500,function(){
        $(elemName).addClass("Open");
        $(elemName).removeClass("duringTransition");
      });
    } else {
      deg_start = 180;
      $(elemName).animate({
        height:"0"
      },500,function(){
        $(elemName).removeClass("Open");
        $(elemName).css("display","none");
        $(elemName).removeClass("duringTransition");
      });
    }
    var navPointer = $(this).find(".pointer");
    $({deg: deg_start}).animate({deg: deg_start+180}, {
        duration: 500,
        step: function(now) {
            $(navPointer).css({
                transform: 'translate(0%,-50%) rotate('+now+'deg)'
            });
        }
    });
  }
  return false;
});

$(".navItemChild").click(function(){
  var preFix = "Images/NavBar/";
  if(previousSelected != null){
    var src = $($(previousSelected).find("img")).attr("src").split("/").pop();
    $($(previousSelected).find("img")).attr("src",preFix+src.substr(9,src.length));
    $($(previousSelected).find("p")).css("color","e6e6e6");
  }
  var prevSrc = $($(this).find("img")).attr("src").split("/").pop();
  $($(this).find("img")).attr("src",preFix+"selected_"+prevSrc);
  $($(this).find("p")).css("color","#1bbc9b");
  previousSelected = this;
});
