<?php
session_start();
require_once("../connection/connection.php");

if (!isset($_SESSION['user_data']) || !isset($_POST['id'])) {
    // Invalid access
    http_response_code(400);
    exit;
}

$applicationID = $_POST['id'];

// Fetch the application details
$applicationQuery = "SELECT internship_ID FROM application_internship WHERE id = ?";
$stmt = $conn->prepare($applicationQuery);
$stmt->bind_param("i", $applicationID);
$stmt->execute();
$stmt->bind_result($internshipID);
$stmt->fetch();
$stmt->close();

if (!$internshipID) {
    // Application not found
    http_response_code(404);
    exit;
}

// Update the application status to 'Cancelled'
$updateQuery = "UPDATE application_internship SET status = 'Cancelled' WHERE id = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("i", $applicationID);
$updateStmt->execute();
$updateStmt->close();

// Increment the available slots for the internship
$updateInternshipQuery = "UPDATE internship SET availability = availability + 1 WHERE Internship_ID = ?";
$updateInternshipStmt = $conn->prepare($updateInternshipQuery);
$updateInternshipStmt->bind_param("i", $internshipID);
$updateInternshipStmt->execute();
$updateInternshipStmt->close();

echo "Application cancelled successfully";
?>
