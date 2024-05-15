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
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Student Dashboard</h2>

    <!-- Buttons for different actions -->
    <form action="change_pass.php" method="post">
        <input type="submit" value="Change Password">
    </form>

    <form action="profile.php" method="post">
        <input type="submit" value="Profile Management">
    </form>

    <form action="intern_application.php" method="post">
        <input type="submit" value="Internship Application">
    </form>

    <form action="notification.php" method="post">
        <input type="submit" value="Notification">
    </form>

    <!-- Button for logout -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
