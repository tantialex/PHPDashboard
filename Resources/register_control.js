$("#Register .back_button").click(function() {
  setPage("block-login.php");
});

$("#Register .done_button").click(function() {
  var flag = false;
  $.ajax({
    type: "POST",
    url: "userdb_control.php",
    data: { password: "Alex" }
  }).done(function( msg ) {
    flag = true;
  });
  do{

  } while(!flag);
});
