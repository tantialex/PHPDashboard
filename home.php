<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="Resources/stylesheet.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <body>
    <div class="background"></div>
    <div id="Page">
      <?php
      ini_set('display_errors', 1);
      ini_set('log_errors', 1);
      ini_set("error_log", "Logs/error.log");

      session_start();
      if(!empty($_SESSION['logged-in'])&& $_SESSION['logged-in'] === true){
        include('template.php');
        error_log(session_id()." --- Session Continued");
      }
      else{
        include('block-login.php');
        error_log(session_id()." --- Not Logged In");
      }
      ?>
    </div>
  </body>
</html>
<script src="Resources/page_control.js"></script>
