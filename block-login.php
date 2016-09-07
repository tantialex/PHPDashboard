<div id="Login">
  <div class="page_container">
    <div class="image_container">
      <img class="user_image" src="Images/unknown_user.png"/>
    </div>
    <form id="Login_Form" method="post">
      <input type="text" class="input_username input" autocorrect="on" autocapitalize="off" spellcheck="false" placeholder="Username or Email" tabindex=1 name="username"></input>
      <input type="password" class="input_password input" placeholder="Password" tabindex=2 name="password"></input>
      <input type="hidden" name="func" value="Login"/>
      <div class="button_wrapper">
        <a class="signUp_button" style="float:left;"><button type="button" name="button">Sign up</button></a
        ><a class="login_button"style="float:right;"><button type="submit" name="login">Login</button></a>
      </div>
    </form>
    <div class="underBox">
    </div>
  </div>
  <script src="Resources/login_control.js"></script>
  <script src="Resources/checker.js"></script>
</div>
