$("#Login .signUp_button").click(function(){
  setPage("block-register.php");
});

$("#Login .login_button").click(function(){
  setPage("template.php");
});

function checkLogin(){
  var flag = false;
  $.ajax({
    type: "POST",
    url: "userdb_control.php",
    data: { password: "Alex" }
  }).done(function( msg ) {

  });
}
