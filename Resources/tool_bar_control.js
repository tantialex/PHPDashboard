$("#Tool_Bar .log-off_anchor").click(function(){
  $.ajax({
    type: "POST",
    url: "/PHPDashboard/Backend/session_control.php",
    data: { func: "log-out" }
  });
  setPage("block-login.php");
});
