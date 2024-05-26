<?php
require_once("../connection/connection.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sanitize($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST['signup'])) {
  
  $name = sanitize($_POST['name']);
  $email = sanitize($_POST['email']);
  $password = sanitize($_POST['password']);
  $confirmPassword = sanitize($_POST['confirm_password']);

  // Check if passwords match
  if ($password !== $confirmPassword) {
    $_SESSION['errors'] = "Passwords do not match!";
    header('Location: signup.php');
    exit;
  }

  $name = mysqli_real_escape_string($conn, $name);
  $email = mysqli_real_escape_string($conn, $email);

  // Check if username already exists in pending_student
  $checkUsernameQuery = "SELECT * FROM pending_student WHERE name = '$name'";
  $resultUsername = mysqli_query($conn, $checkUsernameQuery);
  if (mysqli_num_rows($resultUsername) > 0) {
    $_SESSION['errors'] = "Username already taken!";
    header('Location: signup.php');
    exit;
  }

  // Check if username already exists in activated_student
  $checkUsernameQuery = "SELECT * FROM activated_student WHERE name = '$name'";
  $resultUsername = mysqli_query($conn, $checkUsernameQuery);
  if (mysqli_num_rows($resultUsername) > 0) {
    $_SESSION['errors'] = "Username already taken!";
    header('Location: signup.php');
    exit;
  }

  // Check if email already exists in pending_student
  $checkEmailQuery = "SELECT * FROM pending_student WHERE email = '$email'";
  $resultEmail = mysqli_query($conn, $checkEmailQuery);
  if (mysqli_num_rows($resultEmail) > 0) {
    $_SESSION['errors'] = "Email already exists!";
    header('Location: signup.php');
    exit;
  }

  // Check if email already exists in activated_student
  $checkEmailQuery = "SELECT * FROM activated_student WHERE email = '$email'";
  $resultEmail = mysqli_query($conn, $checkEmailQuery);
  if (mysqli_num_rows($resultEmail) > 0) {
    $_SESSION['errors'] = "Email already exists!";
    header('Location: signup.php');
    exit;
  }

  // Hash the password
  $hashedPass = password_hash($password, PASSWORD_DEFAULT);

  $active = 0; // We insert active as zero by default so that we can manage to activate our user later on

  $code = mt_rand(100000, 999999); // Generating a 6-digit random code

  // Hash the code using password_hash
  $hashedCode = password_hash($code, PASSWORD_DEFAULT);

  // Default access value
  $access = 'student';

  $sql = "INSERT INTO pending_student (name, email, password, code, active, access) VALUES ('$name', '$email', '$hashedPass', '$hashedCode', '$active', '$access')";

  if (mysqli_query($conn, $sql)) {
    
    $mail = new PHPMailer(true);

    try {
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'programmerferg@gmail.com';   // Enter your gmail-id              
      $mail->Password   = 'tgjonvgztrmgukrf';     // Enter your gmail app password that you generated 
      $mail->SMTPSecure = 'ssl';
      $mail->Port       = 465;

      $mail->setFrom('cdm.ics.internship@gmail.com', 'CDM Internship'); // This mail-id will be same as your gmail-id
      $mail->addAddress($email, $name);      // Enter your receiver email-id

      $mail->isHTML(true);
      $mail->Subject = 'Activation Code';      // Your email subject line
      $mail->Body    = 'Your Activation Code is: ' . $code;   // Body of email here
      $mail->send();

      $_SESSION['errors'] = "Signup Successful. Please Check your email for the activation code!";
      header('Location: activate.php');
      exit;
    } catch (Exception $e) {
      $_SESSION['errors'] = "Email sending failed! Error: " . $mail->ErrorInfo;
      header('Location: signup.php');
      exit;
    }
  } else {
    $_SESSION['errors'] = "Signup failed! Please try again.";
    header('Location: signup.php');
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/id-card.png">

    <title>Login & Registration</title>
</head>

<body>
    <!-- start -->
    <div class="signup-container">

        <form id="signupForm" action="signup.php" method="post">
            <div class="infinity-free">
            <a href="../employer/signup.php" style="text-decoration: none;"><h1><img src="../assets/img/student.png" alt="Icon"><span class="primary"> Student</span></h1></a>
            </div>

            <h2 class="centered">Create an Account</h2>
              <div class="section-divider-top"></div>
            <?php if(isset($_SESSION['errors'])): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['errors']; ?>
              </div>
            <?php unset($_SESSION['errors']); endif; ?>

            <div class="alert-container">
                <p class="alert-message" id="msg"></p>
            </div>

            <div class="box">
                <p class="text-muted">Full Name</p>
                <input class="form-control" type="text" name="name" id="username" placeholder="Your full name" required>
            </div>

            <div class="box">
                <p class="text-muted">Email Address</p>
                <input class="form-control" type="email" name="email" id="email" placeholder="ferg@gmail.com" required>
            </div>

            <div class="box">
                <p class="text-muted">Password</p>
                <input class="form-control" type="password" name="password" id="password" placeholder="Your password" required>
            </div>

            <div class="box">
                <p class="text-muted">Confirm Password</p>
                <input class="form-control" type="password" name="confirm_password" id="confirm_password"
                    placeholder="Confirm your password" required>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                <label class="form-check-label" for="flexCheckDefault">
                    I've read and agree to the <a href="#" style="color:#75A47F;">terms of service.</a>.
                </label>
            </div>

            <div class="button">
                <input type="submit" value="Sign up" class="btn" name="signup">
            </div>

            <p class="goto-login-label">Already have account?</p><a href="index.php"
                class="goto-login-link">Sign in</a>

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
