<?php
session_start();
include '../connection/connection.php'; // Ensure this path is correct based on your file structure

// Check if the employer is logged in
if (!isset($_SESSION['employer_data'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $requirements = $conn->real_escape_string($_POST['requirements']);
    $duration = $conn->real_escape_string($_POST['duration']);
    
    // Get the company_id from the session data
    $company_id = $_SESSION['employer_data']['Company_ID'];

    $sql = "INSERT INTO internship (Title, Description, Requirements, Duration, Company_ID) VALUES ('$title', '$description', '$requirements', '$duration', '$company_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New internship created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    header("Location: post_internship.php");
    exit();
}
?>
