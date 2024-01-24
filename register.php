<?php
include_once "./includes/header-auth.php";
?>
<div class="container">
  <div class="form-box">
    <h1 id="title">Sign Up</h1>
    <form method="post" enctype="multipart/form-data" id="reg-form">
      <div class="input-group">
        <div class="input-field" id="nameField">
          <ion-icon name="person-circle-outline"></ion-icon>
          <input type="text" name="first_name" id="first_name" placeholder="Enter first name" required />
        </div>
        <div class="input-field" id="nameField">
          <ion-icon name="person-circle-outline"></ion-icon>
          <input type="text" name="last_name" id="last_name" placeholder=" Enter last name" required />
        </div>
        <div class="input-field">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="email" name="email" id="email" placeholder="Enter email" required />
        </div>
        <div class="input-field">
          <ion-icon name="call-outline"></ion-icon>
          <input type="number" name="phone" id="phone" placeholder="Enter phone" required />
        </div>
        <div class="input-field">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input type="password" name="password" placeholder="Create password" required />
        </div>
        <div class="input-field">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input type="password" name="conf_password" id="conf_password" placeholder="Confirm password" required />
        </div>
        <button type="submit" id="signupbtn">Sign Up</button>
        <p>
          Already have an Account?
          <a href="login.php">Sign In</a>
        </p>
      </div>
    </form>
  </div>
</div>

<?php
include_once "./includes/footer-auth.php";
?>