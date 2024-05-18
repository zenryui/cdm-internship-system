<?php
require_once("../connection/connection.php");
session_start();

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = sanitize($_POST['email']);
    $inputpassword = sanitize($_POST['password']);

    // Select relevant data from the activated_employer table
    $sql = "SELECT * FROM activated_employer WHERE email = ? AND active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $errors = []; // Array to store errors

    if ($result->num_rows > 0) {
        // Fetch employer data
        $employer_data = $result->fetch_assoc();

        // Verify the entered password with the hashed password
        if (!password_verify($inputpassword, $employer_data['password'])) {
            // Incorrect password
            $errors[] = "Wrong password!";
        }
    } else {
        // Email does not exist
        $errors[] = "Email does not exist!";
    }

    if (empty($errors)) {
        // Successful login
        $_SESSION['employer_data'] = $employer_data;
        echo json_encode(['status' => 'success']);
        exit();
    } else {
        // Return errors as JSON response
        echo json_encode(['status' => 'error', 'errors' => $errors]);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- sweet alert -->
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="shortcut icon" href="../assets/img/id-card.png">

    <title>Login</title>
</head>
<body>
<div class="login-container">
    <form id="loginForm" method="post">
        <!-- Form content -->
        <div class="infinity-free">
            <h1><img src="../assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
        </div>
        <h2 class="centered">Login to your account</h2>
        <div class="box">
            <p class="text-muted">Email Address</p>
            <input class="form-control" type="email" required name="email" id="email" placeholder="ferg@gmail.com">
        </div>
        <div class="box">
            <p class="text-muted">Password <span class="forget-pass"><a href="search-email.php">I forgot my password </a></span></p>
            <input class="form-control" type="password" required name="password" id="password" placeholder="Your password">
        </div>
        <div class="button">
            <input type="button" value="Sign in" class="btn" id="loginBtn">
        </div>
        <p class="goto-signup-label">Don't have an account yet?</p>
        <a href="signup.php" class="goto-signup-link">Sign up</a>

        <!-- Alert container for errors -->
        <div class="alert-container" id="alertContainer">
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#loginBtn").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();

        // Manually check if required fields are filled out
        if (!email || !password) {
            $("#alertContainer").html('<p class="alert-message show">Please fill out all required fields.</p>');
            return; // Prevent further execution
        }

        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                email: email,
                password: password,
                login: 1
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.status == "success") {
                    // Show SweetAlert for successful login
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Redirect to logged-in page
                        window.location.href = "log.php";
                    });
                } else {
                    var errors = responseData.errors;
                    var errorHTML = '';
                    errors.forEach(function(error) {
                        errorHTML += '<p class="alert-message show">' + error + '</p>';
                    });
                    $("#alertContainer").html(errorHTML);
                    // Clear the password field upon error
                    $("#password").val('');
                }
            }
        });
    });
});
</script>

</body>
</html>
