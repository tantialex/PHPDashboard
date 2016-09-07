$("#Register .back_button").click(function() {
  setPage("block-login.php");
});

$("#Register_Form").submit(function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "/TrackBack/Backend/userdb_control.php",
    data: $(this).serialize()
  }).done(function(msg) {
      loadErrorBox(msg);
    if(msg == "Sign Up Successful"){
      setPage("block-login.php");
    }
  });
});
