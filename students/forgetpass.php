<?php
session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists in the activated_users table
    $sql = "SELECT * FROM activated_student WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Generate a new code
        $code = mt_rand(100000, 999999);
        // Hash the code
        $hashedCode = password_hash($code, PASSWORD_DEFAULT);
        // Update hashed code in the database
        $update_sql = "UPDATE activated_student SET code = '$hashedCode' WHERE email = '$email'";
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
                // Store email and code in session for later use
                $_SESSION['email'] = $email;
                $_SESSION['code'] = $code;
                
                // Redirect to reset.php after sending the code
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
    <title>Verify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/nvidia.png">
    <!-- <link rel="stylesheet" href="login.css"> -->
    <link rel="stylesheet" href="../assets/css/forgetpass.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="confirm-ownership-container">
        <form id="registrationForm" method="post" action="forgetpass.php">
            <div class="infinity-free">
                <h1><img src="../assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
            </div>
            
            <h2 class="centered">Confirmation</h2>
            <p class="text-center" id="msg"></p>

            <div class="box">
                <p class="text-muted" style="text-align: center;">Our system will send a six-digit code as your token to the email provided below ⬇️.<span class="email-domain" style="color: #75A47F;"> Read only</span></p>
                <input class="form-control" type="email" name="email" value="<?php echo $_GET['email'] ?? ''; ?>" readonly style="text-align: center;">
            </div>

            <div class="button">
                <input type="submit" id="submitButton" value="Send Code" class="btn">
            </div>

            <p class="signup-label">Don't have an account yet?</p>
            <a href="search-email.php" class="return-to-search-email-link">Cancel</a>
        </form>
    </div>

    <script>
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
            // Display SweetAlert when the form is submitted
            Swal.fire({
                icon: 'success',
                title: 'Code Sent!',
                text: 'The password reset code has been sent to your email.',
                showConfirmButton: false,
                timer: 3000
            });
            
            // Change button text to "Sent" when the form is submitted
            document.getElementById("submitButton").value = "Sent";
        });
    </script>
</body>
</html>
