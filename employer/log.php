<?php
session_start();

// Check if the employer is not logged in
if (!isset($_SESSION['employer_data'])) {
    // Redirect the employer to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// If the employer is logged in, display the log.php content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
</head>
<body>
    <h2>Employer Dashboard</h2>

    <!-- Buttons for different actions -->
    <form action="change_pass.php" method="post">
        <input type="submit" value="Change Password">
    </form>

    <form action="profile.php" method="post">
        <input type="submit" value="Profile Management">
    </form>

    <form action="post_internship.php" method="post">
        <input type="submit" value="Post Internship Openings">
    </form>

    <form action="application_list.php" method="post">
        <input type="submit" value="See Applications">
    </form>

    <!-- Button for logout -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
