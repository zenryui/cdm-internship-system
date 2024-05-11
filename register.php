<?php
session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'connection.php';

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

  // Hash the password
  $hashedPass = password_hash($password, PASSWORD_DEFAULT);

  $active = 0; // We insert active as zero by default so that we can manage to activate our use later on

  $code = mt_rand(100000, 999999); // Generating a 6-digit random code

  // Hash the code using password_hash
  $hashedCode = password_hash($code, PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (name, email, password, code, active) VALUES ('$name', '$email', '$hashedPass', '$hashedCode', '$active')";

  if (mysqli_query($conn, $sql)) {
    
    $mail = new PHPMailer();

    try {
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com;';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'cdm.ics.internship@gmail.com';   // Enter your gmail-id              
      $mail->Password   = 'bhvgbxexullmszdk';     // Enter your gmail app password that you generated 
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

      $_SESSION['errors'] = "Email sending failed!";
      header('Location: http://localhost/registration-form/signup.php');
      exit;
    }
  }
}
?>
