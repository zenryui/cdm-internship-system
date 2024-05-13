<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// If the user is logged in, display the log.php content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <h2>Employer Dashboard</h2>

    <!-- Button for logout -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
