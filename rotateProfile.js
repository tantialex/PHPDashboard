var profileIsRotated = false;
var duringTransition = false;
$(".login_button").on("click",function(){
  console.log("pressed");
  if(($(".input_username").val() === "atanti98@gmail.com") && ($(".input_password").val() === "luster61")){
    if(!duringTransition){
      $(".input_username").val("");
      $(".input_password").val("");
      $("#Login_Page").animate({
        opacity:0,
      },500,function(){
        $("#Login_Page").css("display","none");
      });
      setProfilePage();
      $("#Profile_Page").css("display","block");
      $("#Profile_Page").animate({
        opacity:1,
      },500);
    }
  }
});

function setProfilePage(){
  $("#Profile_Page").load("template.php");
}

function deleteProfilePage(){
  $("#Profile_Page").html("");
}

function logout(){
  duringTransition = true;
  $("#Profile_Page").animate({
    opacity:0,
  },500,function(){
    $("#Profile_Page").css("display","none");
    $("#Login_Page").css("display","block");
    $("#Login_Page").animate({
      opacity:1,
    },500,function(){
      profileIsRotated = false;
      duringTransition = false;
    });
    deleteProfilePage();
  });
}
