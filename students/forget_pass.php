<?php
session_start();
ob_start();

require '../vendor/autoload.php';
require '../connection/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_data'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo json_encode(array("success" => false, "message" => "Passwords do not match!"));
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Retrieve the email from session
    $email = $_SESSION['user_data']['email']; // Assuming the email is stored in '$_SESSION['user_data']['email']'

    // Update the password in the database
    $update_sql = "UPDATE activated_student SET password = '$hashedPassword' WHERE email = '$email'";
    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['success'] = "Password updated successfully!";
        echo json_encode(array("success" => true, "message" => "Password updated successfully!"));
        exit();
    } else {
        echo json_encode(array("success" => false, "message" => "Error updating password in database"));
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/id-card.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- sweet alert -->
    <link rel="stylesheet" href="../assets/css/forget_pass.css">
    <style>
        /* Alert message */
        .alert-container {
            position: absolute;
            top: 15%; /* Adjust as needed */
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            text-align: center;
            padding: 10px;
        }

        .alert-message {
            display: none;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: .25rem;
        }

        .alert-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="change-password-container">
            <form id="registrationForm" method="post" action="javascript:void(0);">
                <div class="infinity-free">
                    <h1><img src="../assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
                </div>
                        
                <h2 class="centered">Create new password</h2>
                <div class="section-divider-top"></div>
                <!-- Alert container for errors -->
                <div class="alert-container">
                    <div class="alert alert-danger alert-message" id="alertMessage"></div>
                </div>

                <div class="box">
                    <p class="text-muted">New password</p>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Your new password" required>
                </div>
                <div class="box">
                    <p class="text-muted">Confirm Password </p>
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your new password" required>
                </div>

                <div class="button">
                    <input type="button" value="Create new password" class="btn" onclick="submitForm()">
                </div>
                <p class="signup-label">Don't have account yet?</p><a href="change_pass.php" class="signup-link">Cancel</a>
            </form>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function submitForm() {
        var password = $("#password").val();
        var confirmPassword = $("#confirm_password").val();
        
        if (!password || !confirmPassword) {
            $("#alertMessage").text("Both fields are required!").addClass("show");
            return;
        }

        if (password !== confirmPassword) {
            $("#alertMessage").text("Passwords do not match!").addClass("show");
            return;
        }

        $.ajax({
            type: "POST",
            url: "changepass.php",
            data: $("#registrationForm").serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Redirect to log.php or any other page
                        window.location.href = "log.php";
                    });
                } else {
                    $("#alertMessage").text(response.message).addClass("show");
                }
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>


