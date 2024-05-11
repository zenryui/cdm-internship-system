<?php
session_start();
ob_start();

require 'vendor/autoload.php';
require 'connection.php';

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    
    // Retrieve the email from session
    $email = $_SESSION['email'];

    // Check if the code matches the one stored in the database
    $sql = "SELECT * FROM activated_users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $storedCode = $user_data['code'];
        
        // Verify the entered code with the stored hashed code
        if (password_verify($code, $storedCode)) {
            // Code is valid, redirect to changepass.php
            header("Location: changepass.php");
            exit();
        } else {
            // Invalid code, display error message
            $errors[] = "Invalid code";
        }
    } else {
        // User not found, display error message
        $errors[] = "User not found";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="./Student-Dashboard/images/id-card.png">
    <link rel="stylesheet" href="assets/css/activate.css">
</head>
<body>
    <div class="container">
        <div class="alert-container">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php echo $errors[0]; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="change-password-container">
            <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="infinity-free">
                    <h1><img src="assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
                </div>
    
                <h2 class="centered">Enter OTP</h2>
                <p class="text-muted">Enter the code from your email address at: <span class="email-domain">@gmail.com</span></p>
                <div class="box">
                    <input class="form-control" type="text" name="code" id="code" maxlength="6">
                </div>
                <div class="button">
                    <input type="submit" value="Continue" class="btn" name="submit">
                </div>
                <p class="signup-label">Don't have an account yet?</p>
                <a href="sign-in.php" class="signup-link">Cancel</a>
            </form>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="ajax-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
