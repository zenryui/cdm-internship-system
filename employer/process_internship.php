<?php
session_start(); // Start the session

require_once("../connection/connection.php");

// Retrieve form data
$title = $_POST['title'];
$description = $_POST['description'];
$requirements = $_POST['requirements'];
$duration = $_POST['duration'];

// Check if the user is logged in and Company_ID is set in session
if(isset($_SESSION['employer_data']['Company_ID'])) {
    $companyID = $_SESSION['employer_data']['Company_ID'];

    // Insert internship program into database
    $sql = "INSERT INTO internship (Title, Description, Requirements, Duration, Company_ID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $requirements, $duration, $companyID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Internship program created successfully
        header("Location: log.php");
        exit();
    } else {
        // Error handling
        echo "Error creating internship program: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Redirect the user to login page or display an error message
    header("Location: login.php");
    exit();
}

$conn->close();
?>
