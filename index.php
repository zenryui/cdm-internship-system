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

  $errors = []; // Array to store errors

  if (mysqli_num_rows($result) > 0) {
    // Fetch user data
    $user_data = mysqli_fetch_assoc($result);

    // Verify the entered password with the hashed password
    if (!password_verify($inputpassword, $user_data['password'])) {
      // Incorrect password
      $errors[] = "Wrong password!";
    }
  } else {
    // Email does not exist
    $errors[] = "Email does not exist!";
  }

  if (empty($errors)) {
    // Check if both email and password are incorrect
    if (mysqli_num_rows($result) == 0) {
      $errors[] = "Wrong credentials!";
    }
  }

  if (!empty($errors)) {
    // Return errors as JSON response
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit();
  } else {
    // Successful login
    $_SESSION['user_data'] = $user_data;
    echo json_encode(['status' => 'success']);
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
  <link rel="stylesheet" href="assets/css/login.css">

  <title>Login</title>
</head>
<body>
<div class="login-container">
    <form id="loginForm" method="post">
        <!-- Form content -->
        <div class="infinity-free">
            <h1><img src="assets/img/id-card.png" alt="Icon"><span class="primary"> CDM Internship</span></h1>
        </div>
        <h2 class="centered">Login to your account</h2>
        <div class="box">
            <p class="text-muted">Email Address</p>
            <input class="form-control" type="email" name="email" id="email" placeholder="ferg@gmail.com" required>
        </div>
        <div class="box">
            <p class="text-muted">Password <span class="forget-pass"><a href="search-email.php">I forgot my password </a></span></p>
            <input class="form-control" type="password" name="password" id="password" placeholder="Your password" required>
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

