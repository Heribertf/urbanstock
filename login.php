<?php
session_start();
include_once "./includes/header-auth.php";
?>

<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["user_type"] === 2) {
  header("location: ./investment.php");
  exit;
}
?>
<div class="container">
  <div class="form-box">
    <h1 id="title">Sign In</h1>
    <form method="post" enctype="multipart/form-data" id="log-form">
      <div class="input-group">
        <div class="input-field">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="email" name="email" id="email" placeholder="Email" />
        </div>
        <div class="input-field">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input type="password" name="password" id="password" placeholder="Password" />
        </div>
        <button type="submit" id="signupbtn">Sign In</button>
        <p>
          Don't have an Account?
          <a href="register.php">Register</a>
        </p>
      </div>
    </form>
  </div>
</div>
<?php
include_once "./includes/footer-auth.php";
?>