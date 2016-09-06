var buttonTransition = false;
var isOpened = true;

setInterval(function(){
  checkButtons();
},200)

function checkButtons(){
  if(!buttonTransition){
    buttonTransition = true;
    if(($(".input_username").val() != "") && ($(".input_password").val() != "") && isOpened){
      closeButtons();
    }
    else if((($(".input_username").val() == "") || ($(".input_password").val() == "")) && !isOpened){
      openButtons();
    }
    else{
      buttonTransition = false;
    }
  }
}

function closeButtons(){
  $(".signUp_button").css("color","transparent");
  $(".signUp_button").animate({
    width:"0px",
  },1000);
  $(".login_button").animate({
    width:"100%"
  },1000,function(){
    isOpened = false;
    buttonTransition = false;
  });
}
function openButtons(){
  $(".login_button").animate({
    width:"45%",
  },1000);
  setTimeout(function(){
    $(".signUp_button").animate({
      width:"45%",
    },1000,function(){
      $(".signUp_button").css("color","#eee8d5");
      isOpened = true;
      buttonTransition = false;
    });
  },100);
}
