<?php
session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists in the activated_users table
    $sql = "SELECT * FROM activated_users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Generate a new code
        $code = mt_rand(100000, 999999);
        // Hash the code
        $hashedCode = password_hash($code, PASSWORD_DEFAULT);
        // Update hashed code in the database
        $update_sql = "UPDATE activated_users SET code = '$hashedCode' WHERE email = '$email'";
        if (mysqli_query($conn, $update_sql)) {
            // Send code to user's email using PHPMailer
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cdm.ics.internship@gmail.com'; // Replace with your email address
            $mail->Password   = 'bhvgbxexullmszdk'; // Replace with your email password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('cdm.ics.internship@gmail.com', 'CDM Internship');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body    = "Your password reset code is: $code";

            if ($mail->send()) {
                // Redirect to reset.php
                $_SESSION['email'] = $email;
                header("Location: reset.php");
                exit();
            } else {
                $_SESSION['errors'] = "Error sending email: " . $mail->ErrorInfo;
                header("Location: forgetpass.php");
                exit();
            }
        } else {
            $_SESSION['errors'] = "Error updating code in database";
            header("Location: forgetpass.php");
            exit();
        }
    } else {
        $_SESSION['errors'] = "Email not found!";
        header("Location: forgetpass.php");
        exit();
    }
}
?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="./Student-Dashboard/images/id-card.png">
    <!-- <link rel="stylesheet" href="login.css"> -->
    <link rel="stylesheet" href="assets/css/forgetpass.css">
    
</head>
<body>
 
    <div class="change-password-container">
        <form id="registrationForm" method="post" action="forgetpass.php">
            <div class="infinity-free">
                <h1><img src="assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
            </div>
            
            <h2 class="centered">Forget Password</h2>
            <p class="text-center" id="msg"></p>

            <div class="box">
                <p class="text-muted">Email Address</p>
                <input class="form-control" type="email" name="email" required>
            </div>

            <div class="button">
                <input type="submit" value="Send" class="btn">
            </div>

            <p class="signup-label">Don't have an account yet?</p>
            <a href="index.php" class="signup-link">Cancel</a>
        </form>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="ajax-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>




</html>