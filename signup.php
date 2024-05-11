<?php
require_once("connection.php");
session_start();

// This code will prevent exisiting user from accessing signup page when logged in
if (isset($_SESSION['login_active'])) {
  header('Location: admin.php');
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Bootstrap CSS -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Login & Registration</title>
</head>

<body>
    <!-- start -->
    <div class="change-password-container">

        <form id="signupForm" action="register.php" method="post">
            <div class="infinity-free">
                <h1><img src="assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
            </div>

            <h2 class="centered">Sign Up for Internship</h2>

            <div class="alert-container">
                <p class="alert-message" id="msg"></p>
            </div>


            <div class="box">
                <p class="text-muted">Username</p>
                <input class="form-control" type="text" name="name" id="username" placeholder="Your username">
            </div>

            <div class="box">
                <p class="text-muted">Email Address</p>
                <input class="form-control" type="email" name="email" id="email" placeholder="ferg@gmail.com">
            </div>

            <div class="box">
                <p class="text-muted">Password</p>
                <input class="form-control" type="password" name="password" id="password" placeholder="Your password">
            </div>

            <div class="box">
                <p class="text-muted">Confirm Password</p>
                <input class="form-control" type="password" name="confirm_password" id="confirm_password"
                    placeholder="Confirm your password">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    I've read and agree to the <a href="#">terms of service.</a>.
                </label>
            </div>

            <div class="button">
                <input type="submit" value="Sign up" class="btn" name="signup">
            </div>

            <p class="forget-password-label">Already have account?</p><a href="index.php"
                class="forget-password-link">Sign in</a>

        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
          $(document).ready(function () {
              $('#signupForm').submit(function (e) {
                  var password = $('#password').val();
                  var confirmPassword = $('#confirm_password').val();

                  // Check if passwords match
                  if (password !== confirmPassword) {
                      e.preventDefault(); // Prevent form submission
                      $('.alert-message').html('Passwords do not match!').addClass('show');
                  }
              });
          });

    </script>
</body>

</html>