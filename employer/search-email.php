<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/id-card.png">
    <link rel="stylesheet" href="../assets/css/search-email.css">
</head>
<body>
    <div class="search-email-container" id="SearchEmailContainer"> <!-- Added id attribute -->
        <form id="searchForm" method="post" action="search-email.php">
            <!-- added start -->
            <?php
session_start();
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the activated_users table
    require '../connection/connection.php';
    $sql = "SELECT * FROM activated_employer WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $name = $user_data['name'];
        ?>
        <div class="result-container">
            <div class="box">
                <div class="alert alert-success">User found: <?php echo $name; ?></div>
            </div>
            <div class="send-button">
                <a href="#" class='btn btn-primary' id="confirmButton">Select</a>
            </div>
        </div>
        <script>
            document.getElementById('confirmButton').addEventListener('click', function() {
                if (confirm("Are you sure this account is yours <?php echo $email; ?>?")) {
                    window.location.href = 'forgetpass.php?email=<?php echo $email; ?>';
                }
            });
        </script>
        <?php
    } else {
        ?>
        <div class="result-container">
            <div class="box">
                <div class="alert alert-danger">User not found!</div>
            </div>
        </div>
        <?php
    }

    mysqli_close($conn);
}
?>

            <!-- added end -->

            <div class="box">
                <p class="text-muted" style="text-align: center;">Search for your recovery email</p>
                <!-- Store the value of email using PHP -->
                <input class="form-control" type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required placeholder="ferg@gmail.com" style= "text-align: center;">

            </div>

            <div class="button">
                <input type="submit" id="searchBtn" value="Search" class="btn">
            </div>

            <p class="signup-label">Don't have an account yet?</p>
            <a href="index.php" class="back-to-login-link">Back to Login</a>
        </form>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../js/ajax-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



