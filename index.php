<?php
require_once("connection.php");
session_start();

function sanitize($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST['login'])) {                                                                                                                        
  $email = sanitize($_POST['email']);
  $inputpassword = sanitize($_POST['password']);

  // Select relevant data from the activated_users table
  $sql = "SELECT * FROM activated_users WHERE email = '$email' AND active = 1";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Fetch user data
    $user_data = mysqli_fetch_assoc($result);

    // Verify the entered password with the hashed password
    if (password_verify($inputpassword, $user_data['password'])) {

      // Store user data in session
      $_SESSION['user_data'] = $user_data;

      // Redirect to log.php
      header("Location: log.php");
      exit();
    } else {
      $_SESSION['errors'] = "Login Error! Check Email & Password";
      header("Location: index.php");
      exit();
    }
  } else {
    $_SESSION['errors'] = "Login Error! Check Email & Password";
    header("Location: index.php");
    exit();
  }
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/login.css">

  <title>Login</title>
</head>

<body>

<div class="change-password-container">
    <form id="registrationForm" method="post" action="index.php">
        <div class="infinity-free">
            <h1><img src="assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
        </div>
        <h2 class="centered">Login to your account</h2>
        <div class="box">
            <p class="text-muted">Email Address</p>
            <input class="form-control" type="email" name="email" placeholder="ferg@gmail.com">
        </div>
        <div class="box">
            <p class="text-muted">Password <span class="forget-pass"><a href="search-email.php">I forgot my password </a></span></p>
            <input class="form-control" type="password" name="password" placeholder="Your password">
        </div>
        <div class="button">
            <input type="submit" value="Sign in" class="btn" name="login">
        </div>
        <p class="signup-label">Don't have an account yet?</p>
        <a href="signup.php" class="signup-link">Sign up</a>
    </form>
</div>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="ajax-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
