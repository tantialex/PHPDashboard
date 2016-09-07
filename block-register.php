<div id="Register">
  <div class="page_container">
    <div class="content_wrapper">
      <form id="Register_Form" method="post">
        <input class="register_username" type="text" placeholder="Username" autocorrect="on" autocapitalize="off" spellcheck="false" name="username" pattern=".{5,15}" required></input>
        <input class="register_email" type="email" placeholder="Email" autocorrect="on" autocapitalize="off" spellcheck="false" name="email" pattern=".{5,30}" required></input>
        <input class="register_password" type="password" placeholder="Password" name="password" pattern=".{6,15}" required></input>
        <input class="register_passwordConfirm" type="password" placeholder="Confirm Password" name="passwordConfirm" pattern=".{6,15}" required></input>
        <input type="hidden" name="func" value="Register" />
        <div class="button_wrapper">
          <a class="back_button" style="float:left;"><button type="button" name="button">Back</button></a
          ><a class="done_button"style="float:right;"><button type="submit" name="register">Done</button></a>
        </div>
      </form>
    </div>
    <div class="underBox">
    </div>
  </div>
  <script src="Resources/register_control.js"></script>
</div>
