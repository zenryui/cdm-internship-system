<?php
session_start();
ob_start();

require 'connection.php';

$errors = array(); // Initialize an empty array to store errors

if (isset($_POST['submit'])) {
    // Sanitize user input
    $code = mysqli_real_escape_string($conn, $_POST['code']);

    // Check if the code is provided
    if (empty($code)) {
        $errors[] = "Code is required";
    }

    if (empty($errors)) {
        // Hash the code provided by the user
        $hashed_code = password_hash($code, PASSWORD_DEFAULT);

        // Check if the hashed code exists in the database
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)) {
            if (password_verify($code, $row['code'])) {
                // Fetch user data
                $user_data = $row;
                
                // Insert user data into 'activated_users' table
                $insert_sql = "INSERT INTO activated_users (name, email, password, code, active) VALUES ('{$user_data['name']}', '{$user_data['email']}', '{$user_data['password']}', '{$user_data['code']}', 1)";
                if (mysqli_query($conn, $insert_sql)) {
                    // Delete user data from 'users' table
                    $delete_sql = "DELETE FROM users WHERE code = '{$user_data['code']}'";
                    if (mysqli_query($conn, $delete_sql)) {
                        $_SESSION['success'] = "Your account has been activated successfully!";
                        $_SESSION['registered'] = true; // Set registered to true
                        // Display alert window
                        echo "<script>alert('Your account has been activated successfully!')</script>";
                        // Redirect to index.php
                        echo "<script>window.location.href = 'index.php';</script>";
                        exit;
                    } else {
                        $errors[] = "Error deleting user data";
                    }
                } else {
                    $errors[] = "Error inserting user data into activated_users table";
                }
            }
        }
        // If no matching code found
        $errors[] = "Invalid code";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Account</title>
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
    
                <h2 class="centered">Account Activation</h2>
                <p class="text-muted">Enter the code from your email address at: <span class="email-domain">@gmail.com</span></p>
                <div class="box">
                    <input class="form-control" type="text" name="code" id="code" maxlength="6" minlength="6" placeholder="XXXXXX">
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
