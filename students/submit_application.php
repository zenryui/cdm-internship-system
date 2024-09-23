<?php
session_start();
require_once("../connection/connection.php");

// Check if the user is not logged in
if (!isset($_SESSION['user_data'])) {
    echo "error: User not logged in";
    exit;
}

// Assuming user data is stored in the session
$user_data = $_SESSION['user_data']; 
$student_email = $user_data['email']; // Replace with actual session variable for user email

// Get POST data
$internshipID = $_POST['internshipID'];
$internshipTitle = $_POST['internshipTitle'];
$companyID = $_POST['companyID'];
$companyName = $_POST['companyName'];
$resumePath = ""; // Initialize resume path

// Handle file upload
if (isset($_FILES['resumeFile']) && $_FILES['resumeFile']['error'] == 0) {
    $resumePath = 'uploads/' . basename($_FILES['resumeFile']['name']);
    if (!move_uploaded_file($_FILES['resumeFile']['tmp_name'], $resumePath)) {
        echo "error: Failed to upload resume";
        exit;
    }
} else {
    echo "error: No resume uploaded or error during upload";
    exit;
}

// Insert application into the database
$insertQuery = "INSERT INTO application_internship (internship_ID, title, company_ID, company_name, student_email, resume_path, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("ississ", $internshipID, $internshipTitle, $companyID, $companyName, $student_email, $resumePath);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: Failed to insert application";
}

$stmt->close();
$conn->close();
?>
