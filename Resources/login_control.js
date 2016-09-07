$("#Login .signUp_button").click(function(){
  setPage("block-register.php");
});

$("#Login_Form").submit(function(e){
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "/TrackBack/Backend/userdb_control.php",
    data: $(this).serialize()
  }).done(function(msg) {
      loadErrorBox(msg);
  });
});
