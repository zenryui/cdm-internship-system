<?php
session_start();
ob_start();

require 'vendor/autoload.php';
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['errors'] = "Passwords do not match!";
        header('Location: changepass.php');
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Retrieve the email from session
    $email = $_SESSION['email']; // Assuming you store the email in '$_SESSION['email']'

    // Update the password in the database
    $update_sql = "UPDATE activated_users SET password = '$hashedPassword' WHERE email = '$email'";
    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['success'] = "Password updated successfully!";
        // Redirect to login page or wherever you want
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['errors'] = "Error updating password in database";
        header("Location: changepass.php");
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
    <link rel="stylesheet" href="assets/css/create-pass.css">
    
</head>
<body>
    

    <div class="change-password-container">
            <form id="registrationForm" method="post" action="changepass.php">
            <div class="infinity-free">
                <h1><img src="assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
            </div>
                    
            <h2 class="centered">Create new password</h2>
            <!-- Ajax message -->
            <p class="text-center" id="msg"></p>

            <div class="box">
                <p class="text-muted">New password</p>
                <input class="form-control" type="password" name="password" id="password" placeholder="Your new password">
            </div>
            <div class="box">
                <p class="text-muted">Confirm Password </p>
                <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your new password">
            </div>

            <div class="button">
                <input type="submit" value="Create new password" class="btn">
            </div>
            <p class="signup-label">Don't have account yet?</p><a href="signup.php" class="signup-link">Cancel</a>
        </form>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="ajax-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>




</html>